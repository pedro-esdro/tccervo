<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <main class="form">
        <h2>Cadastro</h2>
        <p>Realize o seu cadastro</p>
        <form method="post">
            <div class="error-text">Erro</div>
            <div class="grid-details">
                <div class="input">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Nome" required pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]*">
                </div>
                <div class="input">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Insira seu email" required>
                </div>
            </div>
            <div class="input">
                <label>Curso</label>
                <select name="curso" required>
                    <option value="">Selecione um curso</option>
                    <option value="Informática para Internet">Informática para Internet</option>
                    <option value="Administração">Administração</option>
                    <option value="Contabilidade">Contabilidade</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Enfermagem">Enfermagem</option>
                </select>
            </div>
            <div class="grid-details">
                <div class="input">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <div class="input">
                    <label>Confirmar senha</label>
                    <input type="password" name="csenha" placeholder="Confirme a senha" required>
                </div>
            </div>
            <div class="terms">
                <label>
                    <input type="checkbox" name="aceitarTermos" required>
                    Aceito os <a href="termos-de-uso.php" target="_blank">termos de uso</a>
                </label>
            </div>
            <div class="submit">
                <input type="submit" value="Cadastrar" class="button">
            </div>
        </form>
        <div class="link">Já tem uma conta? <a href="login.php">Entre</a></div>
        <div class="link"><a href="index.php">Voltar à página inicial</a></div>
    </main>
    <script src="js/cadastro.js"></script>
</body>
</html>