<?php

    // redireciona o usuário verificado para a index
    session_start();

    include 'php/db.php';
    $idUsuario = $_SESSION['idUsuario'];
    $emailUsuario = $_SESSION['emailUsuario'];

    if(empty($idUsuario))
    {
        header("Location: login.php");
    }
    $sql = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = '{$idUsuario}';");
    if(mysqli_num_rows($sql)>0)
    {
        $row = mysqli_fetch_assoc($sql);
        if($row)
        {
            $_SESSION['verificacaoUsuario'] = $row['verificacaoUsuario'];
            if($row['verificacaoUsuario'] == "Verificado")
            {
                header("Location: index.php");
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de conta</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/verify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
</head>
<body>
    <div id="customSpinner">
    </div>
    <main class="form" style="text-align: center;">
        <h2>Verifique sua conta</h2>
        <p>Um email com o código de verificação foi enviado para você no email <?php echo "<b>$emailUsuario</b>";?>. Insira o código a seguir para confirmar sua conta</p>
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
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="js/verify.js"></script>
</body>
</html>