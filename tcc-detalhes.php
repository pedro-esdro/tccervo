<?php
include_once 'php/db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'] ?? "";
if (isset($_GET['idBuscTcc']) && !empty($_GET['idBuscTcc'])) {
    $idTcc = $_GET['idBuscTcc'];
    unset($_SESSION['idRecemEditTcc']);
    unset($_SESSION['idRecemCriado']);
} elseif (isset($_SESSION['idRecemEditTcc']) && !empty($_SESSION['idRecemEditTcc'])) {
    $idTcc = $_SESSION['idRecemEditTcc'];
    unset($_SESSION['idRecemCriado']);
}
elseif (isset($_SESSION['idRecemCriado']) && !empty($_SESSION['idRecemCriado'])){
    $idTcc = $_SESSION['idRecemCriado'];
    unset($_SESSION['idRecemEditTcc']);
}
if (!empty($idTcc)) {
    // Recupere as informações do TCC do banco de dados (você precisa escrever a lógica para isso)
    $tccId = $idTcc; // Suponha que você tenha um parâmetro na URL com o ID do TCC
    $sqlTcc = "SELECT * FROM tbTcc WHERE idTcc = $tccId"; // Personalize essa consulta de acordo com sua estrutura de banco de dados
    $resultTcc = mysqli_query($conexao, $sqlTcc);

    $tcc = mysqli_fetch_assoc($resultTcc);

    $nomeArquivo = $tcc['arquivoTcc'];
    $caminhoArquivo = "./database/tcc/arquivos/".$nomeArquivo;

    $descricao = $tcc["descricaoTcc"];
    // Recupere as informações do curso do TCC
    $sqlCurso = "SELECT C.nomeCurso
                FROM tbCurso AS C
                WHERE C.idCurso = {$tcc['idCurso']}";
    $resultCurso = mysqli_query($conexao, $sqlCurso);
    $curso = mysqli_fetch_assoc($resultCurso);


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
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <main>
        <div class="row topr">
            <div id="foto-capa">
                <img id="imagem-preview" src="<?= $capa ?>" alt="capa do trabalho">
            </div>
            <div class="detalhes-tcc">
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
                <a href="tcc-editar.php?id_tcc=<?= $tcc['idTcc'] ?>">Editar TCC</a>
            </div>
        </div>
        <hr>
        <div class="row botr">
            <div class="partbox">
                <div class="part resumo">
                    <h3>Resumo</h3>
                    <p><?= $descricao ?></p>
                </div>
                <div class="part">
                    <h3>Trabalho</h3>
                    <a href="<?=$caminhoArquivo?>" class="pdf" download>
                        <img src="assets/icons/pdf.png">
                        <p>Arquivo PDF</p>
                    </a>
                    <?php

                        if (!empty($tcc['linkTcc'])){
                            $link = $tcc['linkTcc'];

                            $parsedLink = parse_url($link);

                            $dominioLink = $parsedLink['host'];
                            echo "<h3>Link externo</h3>";
                            echo "<a href='$link' target='_blank'>$dominioLink</a>";
                        }
                    ?>
                </div>
            </div>


            <div class="part odspart">
                <h3 class="odst">ODS - <a href="https://brasil.un.org/pt-br/sdgs" target="_blank"><img src="assets/icons/questionIcon.png" width="20px" height="20px"><span>O que são ODS?</span></a></h3>
                <div class="imgods">
                    <?php
                    while ($odsrow = mysqli_fetch_assoc($resultOds)) {
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

            if (!empty($idUsuario) && !empty($tccId)) {
                $sqlUt = "SELECT * FROM tbUsuario_tbTcc where idUsuario = $idUsuario and idTcc = $tccId";
                $utResult = mysqli_query($conexao, $sqlUt);
                if (mysqli_num_rows($utResult) > 0) {
                    $_SESSION['idEditarTcc_idTcc'] = $tccId;
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