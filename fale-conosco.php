<?php

    include_once 'php/mail.php';

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
                    $success = "Mensagem enviada com sucesso!";
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
<html lang=pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/forms.css">
    <style>
        .sucesso {
            width: 300px;
            height: 200px;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            justify-content: center; align-items: center;
            border-radius: 12px;
        }
        .sucesso p, .sucesso a {
            display: block;
        }
        .sucesso a {
            background-color: #4D3F8F;
            text-decoration: none;
            color: #fff;
            padding: 10px;
            border-radius: 12px;
            margin-top: 15px;
        }

        .sucesso a:hover {
            border: 1px solid #4D3F8F;
            background-color: #Fff;
            color: #4D3F8F;
            transition: 0.2s;
        }
    </style>
</head>
<body>
    <?php if (isset($success)): ?>
        <div class="sucesso"><p><?php echo $success; ?></p><a href="index.php">Página inicial</a></div>
        <style>main {display: none;}</style>
    <?php endif; ?>
    <main class="form">
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
                <input type="text" name="assunto" placeholder="Insira o assunto" required>
            </div>
            <div class="input">
                <label>Mensagem</label><br>
                <textarea id="mensagem" name="mensagem" rows="4" cols="50" required></textarea>
            </div>
            <div class="submit">
                <input type="submit" value="Enviar" class="button">
            </div>
            <div class="link"><a href="index.php">Voltar à página inicial</a></div>
        </form>
    </main>
</body>
</html>