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
idOds int,
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

select * from tbOds;

select * from tbUsuario;
update tbUsuario set senhaUsuario = 'cae8af46a192bf5b2ed659eff69c7ac4' where idUsuario = 4327242;
delete from tbUsuario where idUsuario = 3235263;


