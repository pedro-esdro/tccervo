<?php

session_start();

include 'php/db.php';

$idUsuario = $_SESSION['idUsuario'] ?? "";
$nome = "visitante";

$sql = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = '{$idUsuario}';");
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
    if ($row) {
        $_SESSION['verificacaoUsuario'] = $row['verificacaoUsuario'];
        $_SESSION['nomeUsuario'] = $row['nomeUsuario'];
        $nome = $_SESSION['nomeUsuario'];
        if ($row['verificacaoUsuario'] != "Verificado") {
            header("Location: verificar.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCCERVO</title>
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/index-carrossel.css">
    <link rel="stylesheet" href="css/index-carrossel-ods.css">
    <link rel="stylesheet" href="css/index-carrossel-tcc.css">
</head>

<body>
    <?php
    include 'html-components/index_navbar.php';
    ?>
    <header>
        <h1>Bem-vindo ao TCCERVO!</h1>
        <p>Olá, <b><?php echo $nome; ?></b><br>Tenha acesso ao acervo digital de TCCs da ETEC Antônio Furlan</p>
        <div class="search-box">
            <input type="search" name="search" id="buscatxt" placeholder="Busque aqui">
            <span id="busca" class="fa fa-search"></span>
            <a class="adv-search" href="filtros.php">Busca avançada</a>
        </div>
    </header>
    <main>
        <section class="carrossel-main">
            <div class="slider">
                <div class="slides">
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <div class="slide first">
                        <div class="botoes">
                            <a href="cadastro.php">Cadastre-se</a>
                            <a href="login.php">Entre</a>
                        </div>
                        <img src="assets/carrossel/carrossel_main_01.png" alt="img1" class="img1">
                    </div>
                    <div class="slide">
                        <img src="assets/carrossel/carrossel_main_02.png" alt="img1" class="img2">
                    </div>
                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                    </div>
                </div>
                <div class="manual-navigation">
                    <label for="radio1" class="manual-btn"></label>
                    <label for="radio2" class="manual-btn"></label>
                </div>
            </div>
        </section>
        <section class="carrossel-ods">
            <h2>Navegue por ODS</h2>
            <div class="sub-container4">
                <div class="button-container">
                    <button id="prev-button"><img src="assets/carrossel/ods/prev-button.png" alt="prev"></button>
                </div>
                <div class="slider-container">
                    <div class="slides2">
                        <a href="">
                            <div class="slide2 first">
                                <img src="assets/carrossel/ods/ODS_1.png" alt="ODS_1">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_2.png" alt="ODS_2">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_3.png" alt="ODS_3">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_4.png" alt="ODS_4">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_5.png" alt="ODS_5">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_6.png" alt="ODS_6">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_7.png" alt="ODS_7">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_8.png" alt="ODS_8">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_9.png" alt="ODS_9">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_10.png" alt="ODS_10">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_11.png" alt="ODS_11">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_12.png" alt="ODS_12">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_13.png" alt="ODS_13">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_14.png" alt="ODS_14">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_15.png" alt="ODS_15">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_16.png" alt="ODS_16">
                            </div>
                        </a>
                        <a href="">
                            <div class="slide2">
                                <img src="assets/carrossel/ods/ODS_17.png" alt="ODS_17" class="img">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="button-container">
                    <button id="next-button"><img src="assets/carrossel/ods/next-button.png" alt="next"></button>
                </div>
            </div>
        </section>
        <section class="carrossel-tcc">
            <h2>TCCs recentes</h2>
            <div class="sub-container6">
                <div class="button-container2">
                    <button id="prev-button2"><img src="assets/carrossel/ods/prev-button.png" alt="prev"></button>
                </div>
                <div class="slider-container2">
                    <div class="slides3">
                        <div class="slide3 first">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc"></div>
                        </div>
                        <div class="slide3">
                            <div class="espaco_tcc2"></div>
                        </div>
                    </div>
                </div>
                <div class="button-container2">
                    <button id="next-button2"><img src="assets/carrossel/ods/next-button.png" alt="next"></button>
                </div>
            </div>
        </section>
    </main>
    <?php include 'html-components/footer.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/index-carrossel.js"></script>
    <script src="js/index-carrossel-ods.js"></script>
    <script src="js/index-carrossel-tcc.js"></script>
    <script>
        $(document).ready(function() {
            $('#busca').click(function() {
                var termoBusca = $('#buscatxt').val();
                if (termoBusca !== '') {
                    window.location.href = 'buscar.php?busca=' + encodeURIComponent(termoBusca);
                }
            });
        });
    </script>
</body>

</html>