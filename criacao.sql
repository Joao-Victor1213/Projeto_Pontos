create database pontoMeta;
use pontoMeta;

create table if not exists administradores(
	userName varchar(100) not null unique,
    senha varchar(100) not null,
	nivel int  not null
);

create table if not exists funcionarios(
	email varchar(100) not null unique primary key,
    cpf varchar(45) not null unique,
    nome varchar(100) not null,
    senha varchar(100) not null
);

create table if not exists pontos(
	fk_cpf varchar(45) not null,
    mes int,
    dia int,
    horaEntrada time,
    horaEntradaAlmoco time,
    horaSaidaAlmoco time,
    horaSaida time,
    dataPonto date,
    foreign key (fk_cpf) references funcionarios(cpf)
);
