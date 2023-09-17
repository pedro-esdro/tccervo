create database dbTccervo;
use dbTccervo;

create table tbCurso(
idCurso int primary key,
nomeCurso varchar(30) not null);

create table tbOds(
idOds int primary key,
nomeOds varchar(30) not null);

create table tbUsuario(
idUsuario int primary key auto_increment,
nomeUsuario varchar(50) not null,
emailUsuario varchar(50) not null,
linkedinUsuario varchar(100),
sobreUsuario varchar(250),
senhaUsuario varchar(100) not null,
idCurso int,
verificacaoUsuario varchar(10) not null,
cargoUsuario varchar(10) not null,
codUsuario varchar(4) not null,
FOREIGN KEY (idCurso) REFERENCES tbCurso(idCurso));

create table tbTcc(
idTcc int primary key auto_increment,
nomeTcc varchar(50) not null,
descricaoTcc varchar(250),
capaTcc varchar(100),
anoTcc date not null,
arquivoTcc varchar(100) not null,
idUsuario int,
idCurso int,
FOREIGN KEY (idUsuario) REFERENCES tbUsuario(idUsuario), 
FOREIGN KEY (idCurso) REFERENCES tbUsuario(idCurso));

create table tbOds_tbTcc(
idOds int,
idTcc int,
PRIMARY KEY (idOds, idTcc),
FOREIGN KEY (idOds) REFERENCES tbOds(idOds), 
FOREIGN KEY (idTcc) REFERENCES tbTcc(idTcc));

insert into tbCurso(idCurso, nomeCurso) values
(1, "Informática para Internet"),
(2, "Administração"),
(3, "Contabilidade"),
(4, "Recursos Humanos"),
(5, "Enfermagem");


select * from tbUsuario;

delete from tbUsuario where idUsuario = 3991285;
