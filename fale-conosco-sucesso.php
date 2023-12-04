<?php
    session_start();

    if(!isset($_SESSION['faleConoscoS']))
    {
        header("Location: fale-conosco.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco</title> 
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
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
    <div class="sucesso">
        <p>Mensagem enviada com sucesso!</p>
        <a href="index.php" onclick="limpar()">Página inicial</a>
    </div>
</body>
<script>
    function limpar()
    {
        <?php
            unset($_SESSION['faleConoscoS']);
        ?>
    }
</script>
</html>