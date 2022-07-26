
drop table if exists `tb_users`;
create table `tb_users`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `dni` varchar(15) not null unique,
    `name` varchar(15) not null,
    `lastName` varchar(15) not null,
    `sex` char(1),
    `username` varchar(20) unique,
    `email` varchar(100) unique,
    `password` varchar(500),
    `rule` tinyint not null,
    `disable` boolean
);

-- insert into `tb_users` values(default, default, '1006783343', 'DAYANNA', 'PINTO', 'F', 'ADMIN', 'DAYANAPINTO@GMAIL.COM','$2y$04$A8dGLVylvwo/0eLebRIam.jJ6xLqfrnMKay2m1xB7cmptEYAyGp9.', 1, 0);

drop table if exists `tb_users_access`;
create table `tb_users_access`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `user` int not null,
    `token` varchar(50) not null unique,
    `device` int
);

drop table if exists `tb_eps`;
create table `tb_eps`
(
    `id` int primary key auto_increment,
    `name` varchar(50) not null,
    `disable` boolean not null default false
);

drop table if exists `tb_ips`;
create table `tb_ips`
(
    `id` int primary key auto_increment,
    `name` varchar(50) not null,
    `disable` boolean not null default false
);

drop table if exists `tb_dni_types`;
create table `tb_dni_types`
(
    `id` varchar(5) primary key,
    `text` varchar(50) not null
);

insert into `tb_dni_types` values
('CC', 'Cédula de ciudadanía'),
('TI', 'Tarjeta de identidad'),
('RC', 'Registro civil'),
('CE', 'Cédula de extranjería'),
('PEP', 'PEP');

drop table if exists `tb_persons`;
create table `tb_persons`
(
    `dni` varchar(15) primary key,
    `dniType` varchar(5) not null,
    `date` datetime not null default current_timestamp,
    `name` varchar(20) not null,
    `lastName` varchar(20) not null,
    `cellphones` json not null default '[]',
    `email` varchar(100),
    `sex` char(1),
    `birthDate` date,
    `address` varchar(100),
    `eps` int,
    `sisben` char(2),
    `regime` char(1),
    `population` char(1)
);

drop table if exists `tb_sac_cases_required_attentions`;
create table `tb_sac_cases_required_attentions`
(
    `id` int primary key auto_increment,
    `attention` varchar(50) not null unique
);

drop table if exists `tb_sac_cases`;
create table `tb_sac_cases`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `status` char(1) not null,
    `user` int not null,
    `dni` varchar(15) not null,
    `eps` int not null,
    `requiredAttention` int not null,
    `note` varchar(600) not null,
    `sisben` boolean,
    `regime` boolean,
    `olderAdult` boolean, -- Adulto mayor
    `disabled` boolean, -- Discapacitado.
    `pregnant` boolean, -- Mujer en gestación
    `womenHeadHousehold` boolean, -- Mujer cabeza de hogar
    `afrodescendent` boolean,
    `indigenous` boolean,
    `lgtbi` boolean,
    `victim` boolean, -- Victima
    `displaced` boolean, -- Desplazado
    `demobilized` boolean, -- desmovilizado
    `reinserted` boolean, -- Reincertado
    `palenRaizal` boolean,
    `roomGintano` boolean,
    `nnaNunaccompaniedAdult` boolean
);

drop table if exists `tb_sac_cases_comments`;
create table `tb_sac_cases_comments`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `user` int not null,
    `case` int not null,
    `content` varchar(600) not null 
);

-- Tabla donde se guardan las respuestas de la encuestas
drop table if exists `tb_surveys_questions`;
create table `tb_surveys_questions`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `name` varchar(50) not null,
    `icon` varchar(30) not null,
    `description` varchar(400),
    `questions` json
);
insert into `tb_surveys_questions` values
(1, default, 'EPS', 'apartment', '', '{}'),
(2, default, 'IPS', 'business', '', '{}'),
(3, default, 'Hospital', 'local_hospital', '', '{}'),
(4, default, 'Farmacia', 'local_pharmacy', '', '{}'),
(5, default, 'Laboratorio', 'vaccines', '', '{}'),
(6, default, 'Medicina general', 'medication', '', '{}'),
(7, default, 'Odontologia', 'biotech', '', '{}');

drop table if exists `tb_surveys_answers`;
create table `tb_surveys_answers`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `user` int not null,
    `type` int not null,
    `dni` varchar(15) not null,
    `answers` json not null
);

-- Vista del los casos Excel
drop view if exists `vi_cases_excel`;
create view `vi_cases_excel` as
select 
`t1`.`id` AS `id`,
convert_tz(`t1`.`date`,'+00:00','-05:00') AS `date`,
`t1`.`dni` AS `dni`,
ucase(concat(`t2`.`name`,' ',`t2`.`lastName`)) AS `name`,
`t2`.`sex` AS `sex`,
`t2`.`cellphones` AS `cellphones`,
`t2`.`birthDate` AS `birthDate`,
if(`t2`.`birthDate` = NULL,0,timestampdiff(YEAR,`t2`.`birthDate`,current_timestamp())) AS `age`,
ucase(`t2`.`address`) AS `address`,
`t2`.`sisben`,
if(`t3`.`id` = NULL,NULL,`t3`.`name`) AS `eps`,
`t2`.`regime`,
`t2`.`population`,
`t4`.`attention` AS `requiredAttention`,
`t1`.`note` AS `note`,
if (`t1`.`olderAdult` = 1, 'Si', 'No') AS `olderAdult`,
if (`t1`.`disabled` = 1, 'Si', 'No') AS `disabled`,
if (`t1`.`pregnant` = 1, 'Si', 'No') AS `pregnant`,
if (`t1`.`womenHeadHousehold` = 1, 'Si', 'No') AS `womenHeadHousehold`,
if (`t1`.`afrodescendent` = 1, 'Si', 'No') AS `afrodescendent`,
if (`t1`.`indigenous` = 1, 'Si', 'No') AS `indigenous`,
if (`t1`.`lgtbi` = 1, 'Si', 'No') AS `lgtbi`,
if (`t1`.`victim` = 1, 'Si', 'No') AS `victim`,
if (`t1`.`displaced` = 1, 'Si', 'No') AS `displaced`,
if (`t1`.`demobilized` = 1, 'Si', 'No') AS `demobilized`,
if (`t1`.`reinserted` = 1, 'Si', 'No') AS `reinserted`,
if (`t1`.`palenRaizal` = 1, 'Si', 'No') AS `palenRaizal`,
if (`t1`.`roomGintano` = 1, 'Si', 'No') AS `roomGintano`,
if (`t1`.`nnaNunaccompaniedAdult` = 1, 'Si', 'No') AS `nnaNunaccompaniedAdult`,
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
from (((`tb_sac_cases` `t1` join `tb_persons` `t2` on(`t2`.`dni` = `t1`.`dni`)) join `tb_sac_cases_required_attentions` `t4` on(`t4`.`id` = `t1`.`requiredAttention`)) left join `tb_eps` `t3` on(`t3`.`id` = `t1`.`eps`)) order by `t1`.`id`;


drop view if exists vi_surveys_excel;
create view vi_surveys_excel as
select 
t1.id,
convert_tz(`t1`.`date`,'+00:00','-05:00') AS `date`,
t1.user,
t1.`type`,
concat(t2.name, ' ', t2.lastName) as 'interviewer',
t1.dni,
t3.dniType,
t3.name,
t3.lastName,
t3.sex,
if(`t3`.`birthDate` = NULL,0,timestampdiff(YEAR,`t3`.`birthDate`,current_timestamp())) AS `age`,
t3.cellphones,
t3.address,
t1.answers
from tb_surveys_answers t1
inner join tb_users t2 on t2.id = t1.user
inner join tb_persons t3 on t3.dni = t1.dni
order by t1.id;

drop view if exists `vi_cases`;
create view `vi_cases` as
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
    'Discapacitado', t1.`disabled`,
    'Gestante', t1.pregnant,
    'Mujer cabeza de hogar', t1.womenHeadHousehold,
    'Afrodecendiente', t1.afrodescendent,
    'LGTBI', t1.lgtbi,
    'Victima', t1.victim,
    'Desolazado', t1.displaced,
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