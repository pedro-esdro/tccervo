<?php
include_once 'php/db.php';
session_start();
$odsId = isset($_GET['ods_id']) ? intval($_GET['ods_id']) : 0;
$idUsuario = $_SESSION['idUsuario'] ?? "";
$sqlOds = "SELECT * from tbOds";
$resultOds = mysqli_query($conexao, $sqlOds);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/filtros.css">
    <title>Busca avançada</title>
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <div id="customSpinner">
    </div>
    <main>
        <form method="post">
            <div class="formhead">
                <h1>Busca avançada</h1>
                <h2>Filtros</h2>
            </div>
            <div class="formcontent">
                <div class="formselect">
                    <label for="curso">Curso</label>
                    <select name="curso">
                        <option value="">Não especificado</option>
                        <option value="Informática para Internet">Informática para Internet</option>
                        <option value="Administração">Administração</option>
                        <option value="Contabilidade">Contabilidade</option>
                        <option value="Recursos Humanos">Recursos Humanos</option>
                        <option value="Enfermagem">Enfermagem</option>
                        <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
                        <option value="Segurança do Trabalho">Segurança do Trabalho</option>
                    </select>
                </div>
                <div class="formselect">
                    <label for="ano">Ano</label>
                    <select name="ano">
                        <option value="">Não especificado</option>
                        <?php
                        $anoAtual = date("Y");
                        for ($ano = 2011; $ano <= $anoAtual; $ano++) {
                            echo "<option value='$ano'>$ano</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="formselect odsselect">
                    <p class="odst">Ods - Escolha 1 - <a href="https://brasil.un.org/pt-br/sdgs" target="_blank"><img src="assets/icons/questionIcon.png" width="20px" height="20px"><span>O que são ODS?</span></a></p>
                    <div class="odsbox">
                        <?php while ($rowOds = mysqli_fetch_assoc($resultOds)) : ?>
                            <label class="custom-checkbox">
                                <input type="checkbox" name="ods" value="<?php echo $rowOds['nomeOds'] ?>" <?php echo ($rowOds['idOds'] == $odsId) ? 'checked' : ''; ?>>
                                <img src="assets/carrossel/ods/ODS_<?php echo $rowOds['idOds'] ?>.png" alt="ods">
                            </label>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            </div>
            <div class="formbutton">
                <input id="buscar" type="submit" value="Buscar">
            </div>
        </form>
        <section id="pesquisa">
        </section>
    </main>
    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script src="js/filtros.js"></script>

</html>