<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
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
    <script src="js/login.js"></script>
</body>
</html>