<?php

use HNova\Db\Pull;

$pull = new Pull();

$sql = "select 
t1.id,
t1.date,
t1.`status`,
json_object('id', t1.user, 'name', concat(t4.name, ' ', t4.lastName) ) as 'user',
t1.dni,
lower(concat(t2.name, ' ', t2.lastName)) as 'name',
t2.cellphones,
t2.email,
t2.address,
t3.attention,
t1.note,
( 
    select
    if(count(tt1.id)=0,
    '[]', 
    JSON_ARRAYAGG(
        JSON_OBJECT(
            'id', tt1.id, 
            'date', tt1.`date`,
            'user', JSON_OBJECT(
                'id', tt1.`user`,
                'name', concat(tt2.name, ' ', tt2.lastName)
            ), 
            'content', tt1.`content`)
        )
    )
    from tb_sac_cases_comments tt1
    inner join tb_users tt2 on tt2.id = tt1.user
    where tt1.`case`= t1.id
) as comments
from tb_sac_cases t1
inner join tb_persons t2 on t1.dni = t2.dni
inner join tb_sac_cases_required_attentions t3 on t1.requiredAttention = t3.id
inner join tb_users t4 on t4.id = t1.user
group by t1.id";

$rows = $pull->query($sql)->rows();

$rows = array_map(function($row){
    $row['user'] = json_decode( $row['user'] );
    $row['comments'] = json_decode($row['comments']);
    $row['cellphones'] = json_decode($row['cellphones']);
    return $row;
}, $rows);

return $rows;