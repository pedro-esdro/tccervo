<?php
    session_start();
    $idUsuario = $_SESSION['idUsuario'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termos de uso</title>
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/sobre-termos.css">
</head>
<body>
    <?php include 'html-components/navbar.php'?>
    <main>
        <h1>Termos de uso e privacidade</h1>
        <div class="sobre-txt">
            <h2>Termos de Uso</h2>
            <p>Podemos suspender de forma temporaria ou permanente seu acesso ao serviço sem aviso prévio por qualquer motivo, inclusive se, em nossa única e exclusiva determinação, você violar qualquer disposição desses termos de uso ou qualquer lei ou regulamentação aplicável.</p>
            <p>
                <ul>
                    <li>Conteúdo não permitido. Exemplo: discriminatório, preconceituoso, adulto etc.</li>
                    <li>Fuga do tema do projeto.</li>
                </ul>
            </p>
        </div>
        <div class="sobre-txt">
            <h2>Privacidade</h2>
            <p>Apenas agentes autorizados possuem acesso a seus dados cadastrais sensíveis. Outros usuários só possuem acesso a dados públicos como o Linkedin.</p>
            <p>Todos os dados ficam armazenados de forma segura e idônea.  O TCCervo se compromete com a LGPD &#40;Lei Geral de Proteção de Dados&#41;.</p>
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