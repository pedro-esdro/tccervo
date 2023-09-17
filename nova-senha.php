<?php 

    session_start();
    
    $emailUsuarioRec = $_SESSION["emailUsuarioRec"];
    $codUsuarioRec = $_SESSION["codUsuarioRec"];
    $recIsOk = $_SESSION["recIsOk"] ?? "";
    if(empty($emailUsuarioRec) || empty($codUsuarioRec) or empty($recIsOk))
    {
        header("Location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <main class="form">
        <h2>Crie uma nova senha</h2>
        <p>Crie uma senha para a conta associada ao email <?php echo $emailUsuarioRec;?></p>
        <form action="" method="post">
            <div class="error-text">Erro</div>
            <div class="input">
                <label>Nova Senha</label>
                <input type="password" name="senha" placeholder="Nova Senha" required>
            </div>
            <div class="input">
                <label>Confirmar senha</label>
                <input type="password" name="csenha" placeholder="Confirmar Senha" required>
            </div>
            <div class="submit">
                <input type="submit" value="Criar nova senha" class="button">
            </div>
            <div class="link"><a href="login.php">Cancelar</a></div>
        </form>
    </main>
    <script src="js/nova-senha.js"></script>
</body>
</html>