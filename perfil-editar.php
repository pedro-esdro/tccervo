<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/perfil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'html-components/navbar.php'; ?>
    <main>
        <div class="perfil-parte">
            <div id="foto-perfil">
                <img src="http://via.placeholder.com/150x180" alt="foto de perfil">
            </div>
            <div class="txts">
                <div class="txt">
                    <h2><?= $nome ?></h2>
                    <p>Técnico em <?= $curso ?></p>
                </div>
                <div class="txt">
                    <h2>Instituição</h2>
                    <p>ETEC ANTÔNIO FURLAN</p>
                </div>
            </div>
            <div class="button">
                <input type="submit" value="Editar Perfil">
            </div>
        </div>
        <hr>
        <div class="perfil-parte2">
            <div class="botoes">
                <button  id="botao-informacoes">Informações</button>
                <button  id="botao-publicacoes">Publicações</button>
            </div>
            <div id="conteudo">
                <div id="informacoes-conteudo">
                    <div class="info">
                        <h3>Informações de contato</h3>
                        <div class="links-info">
                            <a href="">
                                <img src="assets/icons/linkedin.png" alt="logo do linkedin">
                                Linkedin | <?=$linkedin ?></a>
                            <p>
                                <img src="assets/icons/email.png" alt="imagem de email">
                                Email | <?= $email ?>
                            </p>
                        </div>
                    </div>
                    <div class="info2">
                        <h3>Sobre</h3>
                        <p><?= $sobre ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'html-components/footer.php';?>
</body>