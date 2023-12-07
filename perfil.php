<?php
include_once "php/db.php";
session_start();

$idUsuario = $_SESSION['idUsuario'] ?? "";
if (isset($_GET['idBusc']) && !empty($_GET['idBusc'])) {
    $idBusc = $_GET['idBusc'];
    unset($_SESSION['idRecemEdit']);
} elseif (isset($_SESSION['idRecemEdit']) && !empty($_SESSION['idRecemEdit'])) {
    $idBusc = $_SESSION['idRecemEdit'];
} elseif (isset($_SESSION['idUsuario']) && !empty($_SESSION['idUsuario'])) {
    $idBusc = $_SESSION['idUsuario'];
} else {
    header("Location: login.php");
}


$buscarUsuario = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = $idBusc");

if ($buscarUsuario && mysqli_num_rows($buscarUsuario) > 0) {
    $row = mysqli_fetch_assoc($buscarUsuario);
    $nome = $row["nomeUsuario"];
    $email = $row["emailUsuario"];

    // Inicialize um array para armazenar os cursos
    $cursos = array();

    $buscaCursosUsuario = mysqli_query($conexao, "SELECT C.nomeCurso
        FROM tbUsuario_tbCurso AS UCurso
        JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
        WHERE UCurso.idUsuario = {$row['idUsuario']};");

    if ($buscaCursosUsuario && mysqli_num_rows($buscaCursosUsuario) > 0) {
        while ($rowCurso = mysqli_fetch_assoc($buscaCursosUsuario)) {
            $cursos[] = $rowCurso["nomeCurso"];
        }
    }

    if (!empty($row["linkedinUsuario"])) {
        $linkedin = $row["linkedinUsuario"];
    } else {
        $linkedin = false;
    }
    if (!empty($row["sobreUsuario"])) {
        $sobre = $row["sobreUsuario"];
    } else {
        $sobre = "Sem bio ainda.";
    }
    if (!empty($row['fotoUsuario'])) {
        $caminhofoto = "database/fotosUsuarios/" . $row['fotoUsuario'];
        if (file_exists($caminhofoto)) {
            $foto = $caminhofoto;
        } else {
            $foto = "assets/icons/avatar.svg";
        }
    } else {
        $foto = "assets/icons/avatar.svg";
    }
} else {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
                    <ul class="cursos-perfil">
                        <?php
                        foreach ($cursos as $curso) {
                            echo "<li class='cursos'>$curso</li>";
                        }
                        ?>
                    </ul>
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
                <button id="botao-informacoes">Informações</button>
                <button id="botao-publicacoes">Publicações</button>
            </div>
            <div id="conteudo">
                <div id="informacoes-conteudo">
                    <div class="info">
                        <h3>Informações de contato</h3>
                        <div class="links-info">
                            <p>
                                <?php  
                                    if ($linkedin)
                                    {
                                ?>       <a target="_blank"href="<?= $linkedin ?>"><img src="assets/icons/linkedin.png" alt="logo do linkedin">Linkedin | Link para o perfil </a>
                                <?php  }
                                else{
                                    ?>
                                    <p><img src="assets/icons/linkedin.png" alt="logo do linkedin">Linkedin | Sem Linkedin associado</p>
                                <?php
                                ;}?>
                                       
                            </p>
                            <p>
                                <img src="assets/icons/email.png" alt="imagem de email">
                                Email | <?= $email ?>
                            </p>
                        </div>
                    </div>
                    <div class="info2">
                        <h3>Sobre</h3>
                        <p><strong>Id de usuário:</strong> <?= $idBusc?></p>
                        <p><?= $sobre ?></p>
                    </div>
                </div>
                <div id="publicacoes-conteudo">

                </div>
            </div>
        </div>
    </main>
    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editar').hide();
        $('#botao-informacoes').addClass('active');
        $('#informacoes-conteudo').show();

        $('#botao-informacoes').click(function() {
            $(this).addClass('active');
            $('#informacoes-conteudo').show();
            $('#publicacoes-conteudo').hide()
            $('#botao-publicacoes').removeClass('active');

        });

        $('#botao-publicacoes').click(function() {
            $(this).addClass('active');
            var idBusc = <?php echo $idBusc; ?>;
            $('#informacoes-conteudo').hide();
            $('#publicacoes-conteudo').show();
            $('#botao-informacoes').removeClass('active');

            $.get('php/pesquisa-pub.php', {
                idPesq: idBusc
            }, function(resp) {
                $('#publicacoes-conteudo').html(resp);
                $('#postar').hide();
                <?php
                if (!empty($idUsuario) && !empty($idBusc) && $idUsuario == $idBusc) {
                    $_SESSION['idEditar'] = $idUsuario;
                ?>
                    $('#postar').show();
                <?php
                }
                ?>
            }).fail(function() {
                alert("Erro ao exibir");
            });
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