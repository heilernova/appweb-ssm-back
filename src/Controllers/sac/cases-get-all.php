<?php

use HNova\Db\Pull;

$pull = new Pull();

$sql = "select 
t1.id,
t1.date,
t1.`status`,
t1.user,
t1.dni,
lower(concat(t2.name, ' ', t2.lastName)) as 'name',
t2.cellphone as 'cellphones',
t2.email,
t2.address,
t3.attention,
t1.note,
( 
    select
    if(count(*)=0,'[]', JSON_ARRAYAGG(JSON_OBJECT('id', id, 'date', `date`, 'user', user, 'content', `content`)))
    from tb_sac_cases_comments 
    where `case`= t1.id 
) as comments
from tb_sac_cases t1
inner join tb_persons t2 on t1.dni = t2.dni
inner join tb_sac_cases_required_attentions t3 on t1.requiredAttention = t3.id 
group by t1.id";

$rows = $pull->query($sql)->rows();

$rows = array_map(function($row){
    $row['comments'] = json_decode($row['comments']);
    $row['cellphones'] = json_decode($row['cellphones']);
    return $row;
}, $rows);

return $rows;