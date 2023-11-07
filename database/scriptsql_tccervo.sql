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
verificacaoUsuario varchar(10) not null,
cargoUsuario varchar(10) not null,
codUsuario varchar(4) not null);

create table tbTcc(
idTcc int primary key auto_increment,
nomeTcc varchar(50) not null,
descricaoTcc varchar(255),
capaTcc varchar(255),
anoTcc date not null,
arquivoTcc varchar(255) not null,
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


select * from tbUsuario_tbCurso;
INSERT INTO tbUsuario_tbCurso (idCurso, idUsuario)
VALUES (2, 5132567);

SELECT C.nomeCurso
FROM tbUsuario_tbCurso AS UCurso
JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
WHERE UCurso.idUsuario = 5132567;

SELECT U.idUsuario, U.nomeUsuario, C.nomeCurso
            FROM tbUsuario AS U
            LEFT JOIN tbUsuario_tbCurso AS UC ON U.idUsuario = UC.idUsuario
            LEFT JOIN tbCurso AS C ON UC.idCurso = C.idCurso
            WHERE U.nomeUsuario LIKE '%josu%';


select * from tbOds_tbTcc;
select * from tbTcc;
select * from tbUsuario;
select * from tbUsuario_tbTcc;

delete from tbUsuario_tbTcc;
delete from tbTcc;
delete from tbOds_tbTCc;
SELECT TCC.* 
    FROM tbUsuario AS U
    JOIN tbUsuario_tbTcc AS UT ON U.idUsuario = UT.idUsuario
    JOIN tbTcc AS TCC ON UT.idTcc = TCC.idTcc
    WHERE U.idUsuario = 1434895;

SELECT U.idUsuario, U.nomeUsuario
        FROM tbUsuario AS U
        JOIN tbUsuario_tbTcc AS UT ON U.idUsuario = UT.idUsuario
        WHERE UT.idTcc = 6626988;
        
        SELECT O.idOds
               FROM tbOds_tbTcc AS TOds
               JOIN tbOds AS O ON TOds.idOds = O.idOds
               WHERE TOds.idTcc = 6626988;