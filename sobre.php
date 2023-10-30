<?php
    session_start();
    $idUsuario = $_SESSION['idUsuario'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/sobre-termos.css">
</head>
<body>
    <?php include 'html-components/navbar.php'?>
    <main>
        <h1>Sobre</h1>
        <div class="sobre-txt">
            <h2>Quem somos?</h2>
            <p>Somos um projeto voltado ao compartilhamento e reonhecimento dos TCCs feitos pelos estudantes da ETEC Antônio Furlan. Funcionamos como uma estante virtual, onde você pode publicar seu próprio TCC ou encontrar um para visualizá-lo. Tudo isso de forma simples, prática e organizada.</p>
        </div>
        <div class="sobre-txt">
            <h2>O que você pode fazer com o TCCervo?</h2>
            <p>
                <ul>
                    <li>Publicar seu TCC para que seja visualizado por outras pessoas;</li>
                    <li>Encontrar um TCC feito por outra pessoa;</li>
                </ul>
            </p>
            <p>Seja para inspiração ou achar alguém, você pode fazer isso facilmente no TCCervo!</p>
        </div>
        <div class="sobre-txt">
            <h2>Como usar o TCCervo?</h2>
            <p>Para publicar seu TCC, é necessário estar em uma conta registrada em nosso sistema. Para isso, <a href="login.php">Entre</a> ou <a href="cadastro.php">Cadastre-se.</a></p>
            <p>Não é necessário estar em uma conta para apenas visualizar outros projetos.</p>
        </div>
        <div class="sobre-txt">
            <p>
                Para retirada de dúvidas, <a href="fale-conosco.php">Fale Conosco.</a>
            </p>
        </div>
    </main>
    <?php include 'html-components/footer.php'?>
</body>
</html>