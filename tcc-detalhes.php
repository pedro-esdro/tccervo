<?php
include_once 'php/db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'] ?? "";
$idTcc = $_GET['idBuscTcc'] ?? "";
if (!empty($idTcc)) {
    // Recupere as informações do TCC do banco de dados (você precisa escrever a lógica para isso)
    $tccId = $idTcc; // Suponha que você tenha um parâmetro na URL com o ID do TCC
    $sqlTcc = "SELECT * FROM tbTcc WHERE idTcc = $tccId"; // Personalize essa consulta de acordo com sua estrutura de banco de dados
    $resultTcc = mysqli_query($conexao, $sqlTcc);
    $tcc = mysqli_fetch_assoc($resultTcc);

    // Recupere as informações do curso do TCC
    $sqlCurso = "SELECT C.nomeCurso
                FROM tbCurso AS C
                WHERE C.idCurso = {$tcc['idCurso']}";
    $resultCurso = mysqli_query($conexao, $sqlCurso);
    $curso = mysqli_fetch_assoc($resultCurso);

    // Recupere as informações das ODS associadas ao TCC (você precisa escrever a lógica para isso)
    $sqlOds = "SELECT O.idOds
               FROM tbOds_tbTcc AS TOds
               JOIN tbOds AS O ON TOds.idOds = O.idOds
               WHERE TOds.idTcc = $tccId";
    $resultOds = mysqli_query($conexao, $sqlOds);

    $sqlUsuario = "SELECT U.idUsuario, U.nomeUsuario
        FROM tbUsuario AS U
        JOIN tbUsuario_tbTcc AS UT ON U.idUsuario = UT.idUsuario
        WHERE UT.idTcc = $tccId";

    $resultUsuario = mysqli_query($conexao, $sqlUsuario);

    if (!empty($tcc["descricaoTcc"])) {
        $descricao = $tcc["descricaoTcc"];
    } else {
        $descricao = "Sem descrição ainda.";
    }
    if (!empty($tcc['capaTcc'])) {
        $caminhocapa = "database/tcc/capas/" . $tcc['capaTcc'];
        if (file_exists($caminhocapa)) {
            $capa = $caminhocapa;
        } else {
            $capa = "https://placehold.co/150x180?text=Capa";
        }
    } else {
        $capa = "https://placehold.co/150x180?text=Capa";
    }
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do TCC</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tcc-detalhes.css">
    <link rel="stylesheet" href="css/navfooter.css">
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <main>
        <div class="row topr">
            <div id="foto-capa">
                <img id="imagem-preview" src="<?= $capa ?>" alt="capa do trabalho">
            </div>
            <div>
                <h2><?= $tcc['nomeTcc'];  ?></h2>
                <p><?= $curso['nomeCurso'] ?></p>
                <p><?= date("Y", strtotime($tcc['anoTcc'])) ?></p>
            </div>
            <div class="autores">
                <h2>Autores</h2>
                <?php
                while ($rowU = mysqli_fetch_assoc($resultUsuario)) {
                    echo "<p><a href='perfil.php?idBusc={$rowU['idUsuario']}'>{$rowU['nomeUsuario']}</a></p>";
                }
                ?>
            </div>
            <div id="editar" class="button">
                <a href="tcc-editar.php">Editar TCC</a>
            </div>
        </div>
        <hr>
        <div class="row">
                <div class="part">
                    <div>
                        <h3>Descrição</h3>
                        <p><?= $descricao ?></p>
                    </div>
                    <div>
                        <h3>Arquivo</h3>
                        <a download href="database/tcc/arquivos/<?=$tcc['arquivoTcc']?>">Encontre o arquivo aqui!</a>
                    </div>
                </div>
                <div class="part">
                    <h3>ODS</h3>
                    <div class="imgods">
                        <?php
                            while($odsrow = mysqli_fetch_assoc($resultOds))
                            {
                                echo "<img src='assets/carrossel/ods/ODS_{$odsrow['idOds']}.png'>";
                            }
                        ?>
                    </div>
                </div>
        </div>
    </main>
    <?php include 'html-components/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editar').hide();
            <?php

            if (!empty($idUsuario) && !empty($tccId)){
                $sqlUt = "SELECT * FROM tbUsuario_tbTcc where idUsuario = $idUsuario and idTcc = $tccId";
                $utResult = mysqli_query($conexao, $sqlUt);
                if(mysqli_num_rows($utResult) > 0){
                    $_SESSION['idEditarTcc'] = $idUsuario; ?>
                    $('#editar').show();
            <?php
                }
            }
            ?>
        });
    </script>
</body>

</html>