create database dbTccervo;
use dbTccervo;

create table tbCurso(
idCurso int primary key,
nomeCurso varchar(30) not null);

create table tbOds(
idOds int primary key,
nomeOds varchar(30) not null);

create table tbUsuario(
idUsuario int primary key,
nomeUsuario varchar(50) not null,
emailUsuario varchar(100) not null,
linkedinUsuario varchar(50),
sobreUsuario varchar(255),
senhaUsuario varchar(100) not null,
fotoUsuario varchar(255),
idCurso int,
verificacaoUsuario varchar(10) not null,
cargoUsuario varchar(10) not null,
codUsuario varchar(4) not null,
FOREIGN KEY (idCurso) REFERENCES tbCurso(idCurso));

create table tbTcc(
idTcc int primary key,
nomeTcc varchar(50) not null,
descricaoTcc varchar(255),
capaTcc varchar(255),
anoTcc date not null,
arquivoTcc varchar(255) not null,
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

ALTER TABLE tbUsuario
MODIFY COLUMN fotoUsuario varchar(150);

select * from tbUsuario;
update tbUsuario set senhaUsuario = 'cae8af46a192bf5b2ed659eff69c7ac4' where idUsuario = 4327242;
delete from tbUsuario where idUsuario = 3235263;


