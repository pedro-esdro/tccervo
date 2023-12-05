<?php

    session_start();

    $codUsuarioRec = $_SESSION['codUsuarioRec'];
    $emailUsuarioRec = $_SESSION['emailUsuarioRec'];

    if(empty($codUsuarioRec))
    {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/verify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
</head>
<body>
<div id="customSpinner">
    </div>
    <main class="form" style="text-align: center;">
        <h2>Recupere sua senha</h2>
        <p>Um email com o código de para recuperação de senha foi enviado para você no email <?php echo "<b>$emailUsuarioRec</b>";?>. Insira o código a seguir.</p>
        <form action="" autocomplete="off">
            <div class="error-text">Erro</div>
            <div class="fields-input">
                <input type="number" name="cod1" class="cod-field" placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="cod2" class="cod-field" placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="cod3" class="cod-field" placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="cod4" class="cod-field" placeholder="0" min="0" max="9" required onpaste="false">
            </div>
            <div class="submit">
                <input type="submit" value="Verificar" class="button">
            </div>
            <div class="link"><a href="recuperar-senha.php">Cancelar</a></div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="js/recuperar-senha-codigo.js"></script>
</body>
</html>