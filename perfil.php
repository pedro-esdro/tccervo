<?php
    include_once "php/db.php";
    session_start();
    
    $idUsuario = $_SESSION['idUsuario'] ?? "";
    if(isset($_GET['idBusc']) && !empty($_GET['idBusc']))
    {
        $idBusc = $_GET['idBusc'];
        unset($_SESSION['idRecemEdit']);
    }
    if(isset($_SESSION['idRecemEdit']) && !empty($_SESSION['idRecemEdit'])){
        $idBusc = $_SESSION['idRecemEdit'];
    }
    
    
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
                            if(!empty($row['fotoUsuario'])){
                                $caminhofoto = "database/fotosUsuarios/".$row['fotoUsuario'];
                                if(file_exists($caminhofoto))
                                {
                                    $foto = $caminhofoto;
                                }
                                else{
                                    $foto = "assets/icons/avatar.svg";
                                }
                            }
                            else
                            {
                                $foto = "assets/icons/avatar.svg";
                            }
                        }
                    }
                }
            }
        }
    }
    else{
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
</head>
<body>
    <?php include 'html-components/navbar.php'; ?>
    <main>
        <div class="perfil-parte">
            <div id="foto-perfil">
                <img id="imagem-preview" src="<?= $foto ?>" alt="foto de perfil">
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
            <div id="editar" class="button">
                <a href="perfil-editar.php">Editar Perfil</a>
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
                            <p>
                                <img src="assets/icons/linkedin.png" alt="logo do linkedin">
                                Linkedin | <?=$linkedin ?></p>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#editar').hide();
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
            $_SESSION['idEditar'] = $idUsuario;
        ?>
            $('#editar').show();
        <?php
        }
        ?>
    });


</script>
</html>