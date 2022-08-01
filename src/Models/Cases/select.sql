select 
t1.id,
t1.date,
t1.`status`,
json_object('id', t1.user, 'name', concat(t4.name, ' ', t4.lastName) ) as 'user',
json_object(
    'dni', t1.dni,
    'name', lower(concat(t2.name, ' ', t2.lastName)),
    'age',if(`t2`.`birthDate` = NULL,0,timestampdiff(YEAR,`t2`.`birthDate`,current_timestamp())),
    'cellphones', t2.cellphones,
    'email', t2.email,
    'address', t2.address,
    'regime', t2.regime,
    'population', t2.population
)
as 'client',
t5.name as 'eps',
t3.attention,
json_object(
    'Adulto mayor', t1.olderAdult,
    'Discapacitado', t1.disabled,
    'Gestante', t1.pregnant,
    'Mujer cabeza de hogar', t1.womenHeadHousehold,
    'Afrodecendiente', t1.afrodescendent,
    'LGTBI', t1.lgtbi,
    'Victima', t1.victim,
    'Discapacitado', t1.displaced,
    'Desmobilizado', t1.demobilized,
    'Reinsertado', t1.reinserted,
    'Panel raizal', t1.palenRaizal,
    'Room gitado', t1.roomGintano,
    'NNA sin acompañamiento', t1.nnaNunaccompaniedAdult
) as 'populationGroup',
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
left join tb_eps t5 on t5.id = t1.eps
group by t1.id
order by t1.id DESC