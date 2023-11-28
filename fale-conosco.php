<?php

    include_once 'php/mail.php';

    session_start();

    if (isset($_SESSION['faleConoscoS']) && $_SESSION['faleConoscoS'] === true)
    {
        unset($_SESSION['faleConoscoS']);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $assunto = $_POST['assunto'];
        $mensagem = $_POST['mensagem'];

        if(!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem))
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                if(sendEmailTccervo($nome, $email, $assunto, $mensagem))
                {
                    $_SESSION['faleConoscoS'] = true;
                    header("Location: fale-conosco-sucesso.php");
                    exit;
                }
                else
                {
                    $erro = "Erro ao enviar contato!";
                }
            }
            else {
                $erro = "Insira um e-mail válido";
            }
        }
        else
        {
            $erro = "Insira todas as informações";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
</head>
<style>
</style>
<body>
    <main class="form formcontato">
        <h2>Fale Conosco</h2>
        <form id="formulario"action="" method="post">
        <?php if (isset($erro)): ?>
            <div class="error-text" style="display: block;"><?php echo $erro; ?></div>
        <?php endif; ?>
            <div class="input">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Insira seu nome" required pattern="[a-zA-z'-'\s]*">
            </div>
            <div class="input">
                <label>Email</label>
                <input type="email" name="email" placeholder="Insira um email válido" required>
            </div>
            <div class="input">
                <label>Assunto</label>
                <input type="text" name="assunto" placeholder="Insira o assunto" autocomplete="off" required>
            </div>
            <div class="input">
                <label>Mensagem</label><br>
                <textarea id="mensagem" name="mensagem" rows="4" cols="50" autocomplete="off"required></textarea>
            </div>
            <div class="submit">
                <input type="submit" value="Enviar" class="button">
            </div>
            <div class="link"><a href="index.php">Voltar à página inicial</a></div>
        </form>
    </main>
</body>
</html>