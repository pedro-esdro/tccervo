create database dbTccervo;
use dbTccervo;

create table tbCurso(
idCurso int primary key,
nomeCurso varchar(30) not null);

create table tbOds(
idOds int primary key,
nomeOds varchar(70) not null);

create table tbUsuario(
idUsuario int primary key,
nomeUsuario varchar(100) not null,
emailUsuario varchar(100) not null,
linkedinUsuario varchar(50),
sobreUsuario varchar(255),
senhaUsuario varchar(100) not null,
fotoUsuario varchar(255),
verificacaoUsuario varchar(10) not null,
cargoUsuario varchar(10) not null,
codUsuario varchar(4) not null);

create table tbTcc(
idTcc int primary key auto_increment,
nomeTcc varchar(50) not null,
descricaoTcc varchar(2000) not null,
capaTcc varchar(255),
anoTcc date not null,
arquivoTcc varchar(255) not null,
linkTcc varchar(255),
data_postagem datetime not null,
idCurso int,
FOREIGN KEY (idCurso) REFERENCES tbCurso(idCurso));

create table tbUsuario_tbCurso(
idCurso int,
idUsuario int,
PRIMARY KEY(idCurso, idUsuario),
FOREIGN KEY (idCurso) REFERENCES tbCurso(idCurso),
FOREIGN KEY (idUsuario) REFERENCES tbUsuario(idUsuario));

create table tbUsuario_tbTcc(
idUsuario int,
idTcc int,
PRIMARY KEY(idUsuario, idTcc),
FOREIGN KEY (idUsuario) REFERENCES tbUsuario(idUsuario), 
FOREIGN KEY (idTcc) REFERENCES tbTcc(idTcc));

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
(5, "Enfermagem"),
(6, "Desenvolvimento de Sistemas"),
(7, "Segurança do Trabalho");

INSERT INTO tbOds (idOds, nomeOds) VALUES
(1, 'Erradicação da Pobreza'),
(2, 'Fome Zero e Agricultura Sustentável'),
(3, 'Saúde e Bem-Estar'),
(4, 'Educação de Qualidade'),
(5, 'Igualdade de Gênero'),
(6, 'Água Limpa e Saneamento'),
(7, 'Energia Acessível e Limpa'),
(8, 'Trabalho Decente e Crescimento Econômico'),
(9, 'Indústria, Inovação e Infraestrutura'),
(10, 'Redução das Desigualdades'),
(11, 'Cidades e Comunidades Sustentáveis'),
(12, 'Consumo e Produção Responsáveis'),
(13, 'Ação contra a Mudança Global do Clima'),
(14, 'Vida na Água'),
(15, 'Vida Terrestre'),
(16, 'Paz, Justiça e Instituições Eficazes'),
(17, 'Parcerias e Meios de Implementação');

select * from tbUsuario;