<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
</head>
<body>
    <main class="form">
        <h2>Recupere sua senha</h2>
        <form action="">
            <div class="error-text">Erro</div>
            <div class="input">
                <label>Email para recuperação da senha</label>
                <input type="email" name="email" placeholder="Insira seu email" required>
            </div>
            <div class="submit">
                <input type="submit" value="Enviar email" class="button">
            </div>
            <div class="link"><a href="login.php">Cancelar</a></div>
        </form>
    </main>
    <script src="js/recuperar-senha.js"></script>
</body>
</html>