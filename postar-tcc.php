<?php
include_once 'php/db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'] ?? "";
if (!empty($idUsuario)) {
    $sqlCurso = "SELECT UCurso.idCurso, C.nomeCurso
                FROM tbUsuario_tbCurso AS UCurso
                JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
                WHERE UCurso.idUsuario = $idUsuario";

    $resultCursos = mysqli_query($conexao, $sqlCurso);

    $sqlOds = "SELECT * from tbOds";
    $resultOds = mysqli_query($conexao, $sqlOds);
} else {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publique seu TCC</title>
    <link rel="stylesheet" type="text/css" href="css/tcc.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/busca.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="customSpinner">
    </div>
    <?php include 'html-components/navbar.php'; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="error-text">
        </div>
        <h1>Postar TCC</h1>
        <br>
        <div class="tcc-container">
            <div class="left-column">
                <div id="foto-perfil">
                    <img id="imagem-preview" src="https://placehold.co/150x180?text=Capa" alt="Capa do TCC">
                    <label class="arquivoinput" for="capaTcc">Escolher uma capa</label>
                    <input type="file" name="capaTcc" id="capaTcc" style="display:none">
                </div>
                <div class="addAutores">
                    <h3>Adicionar autores -- opcional</h3>
                    <p>Adicione até 5 outros autores pelo id de usuário</p>
                    <input class="inputautor" type="text" name="autores[]" pattern="[0-9]+" title="Somente números são permitidos" placeholder="Id de usuário do Autor">
                    <input class="inputautor" type="text" name="autores[]" pattern="[0-9]+" title="Somente números são permitidos" placeholder="Id de usuário do Autor">
                    <input class="inputautor" type="text" name="autores[]" pattern="[0-9]+" title="Somente números são permitidos" placeholder="Id de usuário do Autor">
                    <input class="inputautor" type="text" name="autores[]" pattern="[0-9]+" title="Somente números são permitidos" placeholder="Id de usuário do Autor">
                    <input class="inputautor" type="text" name="autores[]" pattern="[0-9]+" title="Somente números são permitidos" placeholder="Id de usuário do Autor">
                </div>

                <div class="buttons sbt1">
                    <input class="submit" type="submit" value="Postar TCC"><br>
                    <a href="javascript:history.go(-1)">Cancelar</a>
                </div>
            </div>

            <div class="right-column">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nomeTcc">Nome do TCC*:</label>
                        <input type="text" name="nomeTcc" id="nomeTcc" placeholder="Nome do trabalho" required>
                    </div>

                    <div class="form-group">
                        <label for="anoTcc">Ano do TCC*:</label>
                        <select name="anoTcc" id="anoTcc" required>
                            <option value="">Selecione um ano</option>
                            <?php
                            $anoAtual = date("Y");
                            for ($ano = 2011; $ano <= $anoAtual; $ano++) {
                                echo "<option value='$ano'>$ano</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" id="linkArquivo">
                        <label for="linkArquivo">Link exterior:</label>
                        <input type="text" name="linkArquivo" id="linkArquivoInput" placeholder="https://www.exemplo.com" pattern="^https:\/\/[\w\d.-]+\.[a-z]{2,4}(\/\S*)?$">
                        <small>Um link opcional, como Github, Youtube, etc.<br>
                            Formato: <strong>https://www.exemplo.com</strong></small>
                    </div>

                    <div class="form-group">
                        <label for="curso">Curso*:</label>
                        <select name="curso" required>
                            <option value="">Selecione um curso</option>
                            <?php
                            while ($rowCurso = mysqli_fetch_assoc($resultCursos)) {
                                echo "<option value='{$rowCurso['nomeCurso']}'>{$rowCurso['nomeCurso']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group formresumo">
                        <label for="descricaoTcc">Resumo do TCC*:</label>
                        <textarea name="descricaoTcc" id="descricaoTcc" required rows="4" cols="50" autocomplete="off" maxlength="2000" placeholder="Fale sobre o trabalho"></textarea>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group" id="uploadArquivo">
                        <label class="arquivoinput" for="arquivoTcc">Arquivo PDF*</label>
                        <small>Monografia, documentação, etc.</small>
                        <input type="file" name="arquivoTcc" id="arquivoTcc" style="display:none;">
                        <div class="pdf">
                            <img src="assets/icons/pdf.png">
                            <p id="arquivoPreviewNome"></p>
                        </div>
                    </div>
                </div>

                <h3 id="odshead" class="odst">ODS - Escolha até 3 - <a href="https://brasil.un.org/pt-br/sdgs" target="_blank"><img src="assets/icons/questionIcon.png" width="20px" height="20px"><span>O que são ODS?</span></a></h3>
                <div class="form-row ods-row">
                    <?php while ($rowOds = mysqli_fetch_assoc($resultOds)) : ?>
                        <label class="custom-checkbox">
                            <input type="checkbox" name="ods[]" value="<?php echo $rowOds['nomeOds'] ?>">
                            <img src="assets/carrossel/ods/ODS_<?php echo $rowOds['idOds'] ?>.png" alt="ods">
                        </label>
                    <?php endwhile; ?>
                </div>
                <div class="form-row">
                    <div class="buttons sbt2">
                        <input class="submit" type="submit" value="Postar TCC"><br>
                        <a href="index.php">Cancelar</a>
                    </div>
                </div>

            </div>

        </div>
    </form>
        <?php include 'html-components/footer.php'; ?>
</body>
<!-- Adicione esta linha ao final do seu HTML para incluir o script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script src="js/postartcc.js"></script>
</html>