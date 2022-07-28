
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
if(`t2`.`sisben` = 0,'NO','SI') AS `sisben`,
if(`t3`.`id` = NULL,NULL,`t3`.`name`) AS `eps`,
if(`t2`.`regime` = 0,'SUBSIDIADO','CONTRIBUTIVO') AS `regime`,
if(`t2`.`population` = 'U','URBANA','RURAL') AS `population`,
`t4`.`attention` AS `requiredAttention`,
`t1`.`note` AS `note`,
`t1`.`olderAdult` AS `olderAdult`,
`t1`.`disabled` AS `disabled`,
`t1`.`pregnant` AS `pregnant`,
`t1`.`womenHeadHousehold` AS `womenHeadHousehold`,
`t1`.`afrodescendent` AS `afrodescendent`,
`t1`.`indigenous` AS `indigenous`,
`t1`.`lgtbi` AS `lgtbi`,
`t1`.`victim` AS `victim`,
`t1`.`displaced` AS `displaced`,
`t1`.`demobilized` AS `demobilized`,
`t1`.`reinserted` AS `reinserted`,
`t1`.`palenRaizal` AS `palenRaizal`,
`t1`.`roomGintano` AS `roomGintano`,
`t1`.`nnaNunaccompaniedAdult` AS `nnaNunaccompaniedAdult`,
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
t2.name as 'interviewer',
t1.dni,
t3.dniType,
concat(t3.name, ' ', t3.lastName) as 'name',
t3.sex,
if(`t3`.`birthDate` = NULL,0,timestampdiff(YEAR,`t3`.`birthDate`,current_timestamp())) AS `age`,
t3.cellphones,
t3.address,
t1.answers
from tb_surveys_answers t1
inner join tb_users t2 on t2.id = t1.user
inner join tb_persons t3 on t3.dni = t1.dni
order by t1.id;