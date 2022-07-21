
drop table if exists `tb_users`;
create table `tb_users`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `dni` varchar(15) not null unique,
    `name` varchar(15) not null,
    `lastName` varchar(15) not null,
    `sex` char(1) not null,
    `email` varchar(100) not null unique,
    `password` varchar(500) not null,
    `rule` tinyint not null,
    `disable` boolean not null
);

drop table if exists `tb_users_access`;
create table `tb_users_access`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `user` int not null,
    `token` varchar(50) not null unique,
    `device` int,
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

drop table if exists `tb_persons`;
create table `tb_persons`
(
    `dni` varchar(15) primary key,
    `dniType` varchar(5) not null,
    `date` datetime not null default current_timestamp,
    `name` varchar(20) not null,
    `lastName` varchar(20) not null,
    `cellphone` char(10),
    `email` varchar(100),
    `sex` char(1),
    `birthDate` date,
    `address` varchar(100),
    `eps` int,
    `sisben` boolean,
    `regime` boolean,
    `population` boolean
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
    `note` varchar(400) not null,
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
    `nnaNunaccompaniedAdult` boolean,
);

drop table if exists `tb_sac_cases_comments`;
create table `tb_sac_cases_comments`
(
    `id` int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `user` int not null,
    `case` int not null,
    `content` varchar(400) not null 
);


drop table if exists `tb_surveys`;
create table `tb_surveys`
(
    'id' int primary key auto_increment,
    `date` datetime not null default current_timestamp,
    `type` varchar(20) not null,
    `user` int not null,
    `dni` varchar(15) not null,
    `questions` json not null
);