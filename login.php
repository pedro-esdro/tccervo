<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
</head>
<body>
    <div id="customSpinner">
    </div>
    <main class="form">
        <h2>Entre</h2>
        <form action="">
            <div class="error-text">Erro</div>
            <div class="input">
                <label>Email</label>
                <input type="email" name="email" placeholder="Insira seu email" required>
            </div>
            <div class="input">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="submit">
                <input type="submit" value="Entrar" class="button">
            </div>
        </form>
        <div class="link"><a href="recuperar-senha.php">Esqueci minha senha</a></div>
        <div class="link">Ainda não está cadastrado? <a href="cadastro.php">Crie sua conta</a></div>
        <div class="link"><a href="index.php">Voltar à página inicial</a></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="js/login.js"></script>
</body>
</html>