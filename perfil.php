<?php
    include_once "php/db.php";
    session_start();
    
    $idUsuario = $_SESSION['idUsuario'] ?? "";
    $idBusc = $_SESSION['idBusc'] ?? "";
    
    if (!empty($idBusc)) {
        $buscarUsuario = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = $idBusc");
        if ($buscarUsuario) {
            if (mysqli_num_rows($buscarUsuario) > 0) {
                $row = mysqli_fetch_assoc($buscarUsuario);
                if ($row) {
                    $buscaCurso = mysqli_query($conexao, "SELECT * from tbCurso where idCurso = {$row['idCurso']};");
                    if ($buscaCurso) {
                        $row2 = mysqli_fetch_assoc($buscaCurso);
                        if ($row2) {
                            $nome = $row["nomeUsuario"];
                            $curso = $row2["nomeCurso"];
                            $email = $row["emailUsuario"];
                            if (!empty($row["linkedinUsuario"])) {
                                $linkedin = $row["linkedinUsuario"];
                            } else {
                                $linkedin = "Sem linkedin associado";
                            }
                            if (!empty($row["sobreUsuario"])) {
                                $sobre = $row["sobreUsuario"];
                            } else {
                                $sobre = "Sem bio ainda.";
                            }
                        }
                    }
                }
            }
        }
    }
    else{
        unset($_SESSION['idBusc']);
        header('Location: login.php');
    }
?>
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
                <input id="alterar" type="submit" value="Editar Perfil">
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
<script>
    $(document).ready(function(){
        $('#alterar').hide();
        $('#botao-informacoes').addClass('active');
        $('#informacoes-conteudo').show();

        $('#botao-informacoes').click(function(){
            $(this).addClass('active');
            $('#informacoes-conteudo').show();
            $('#botao-publicacoes').removeClass('active');
        });

        $('#botao-publicacoes').click(function(){
            $(this).addClass('active');
            $('#informacoes-conteudo').hide();
            $('#botao-informacoes').removeClass('active');
        });

        <?php
        if (!empty($idUsuario) && !empty($idBusc) && $idUsuario == $idBusc) {
        ?>
            $('#alterar').show();
        <?php
        }
        ?>
    });


</script>
</html>