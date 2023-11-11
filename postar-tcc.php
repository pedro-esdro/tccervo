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
    header("Location: index.php");
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
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
</head>

<body>
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

                <div class="add-colaboradores">
                    <button id="add-col-button">Adicionar outros autores</button>
                </div>
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <h2>Adicionar outros autores</h2>
                        <input type="text" id="search-users-modal" placeholder="Pesquisar usuários...">
                        <div id="usuarios-no-projeto">
                            <h3>Usuários no Projeto</h3>
                            <div id="adicionados-modal"></div>
                        </div>
                        <div id="usuarios-disponiveis">
                            <h3>Usuários Disponíveis</h3>
                            <div id="disponiveis-modal"></div>
                        </div>
                    </div>
                </div>


                <div class="buttons">
                    <input class="submit" type="submit" value="Postar TCC"><br>
                    <a href="index.php">Cancelar</a>
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
                    <div class="form-group">
                        <label for="descricaoTcc">Descrição do TCC*:</label>
                        <textarea name="descricaoTcc" id="descricaoTcc" required rows="4" cols="50" autocomplete="off" maxlength="255" placeholder="Fale sobre o trabalho"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tipoArquivo">Escolha o tipo de envio:</label>
                        <select class="semborda" name="tipoArquivo" id="tipoArquivo">
                            <option value="link">Inserir Link</option>
                            <option value="upload">Fazer Upload</option>
                        </select>
                    </div>


                </div>

                <div class="form-row">
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
                    <div class="form-group" id="linkArquivo">
                        <label for="linkArquivo">Link para o arquivo*:</label>
                        <input type="text" name="linkArquivo" id="linkArquivo" placeholder="https://www.exemplo.com">
                    </div>

                    <div class="form-group" id="uploadArquivo" style="display: none;">
                        <div style="visibility: hidden;">a</div>
                        <label class="arquivoinput" for="arquivoTcc">Arquivo (.PDF, .ZIP ou .RAR)*</label>
                        <input type="file" name="arquivoTcc" id="arquivoTcc" style="display:none;">
                        <p id="arquivoPreviewNome"></p>
                    </div>


                </div>
                <h3 id="odshead">ODS - Escolha até 3:</h3>
                <div class="form-row ods-row">
                    <?php while ($rowOds = mysqli_fetch_assoc($resultOds)) : ?>
                        <label class="custom-checkbox">
                            <input type="checkbox" name="ods[]" value="<?php echo $rowOds['nomeOds'] ?>">
                            <img src="assets/carrossel/ods/ODS_<?php echo $rowOds['idOds'] ?>.png" alt="ods">
                        </label>
                    <?php endwhile; ?>
                </div>

            </div>

        </div>
    </form>
    <!-- Adicione esta div ao seu HTML -->
    <div id="overlay"></div>

    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/postartcc.js"></script>
<script>
$(document).ready(function () {
    var modal = $('#modal');
    var overlay = $('#overlay');
    var addButton = $('#add-col-button');
    var closeModalButton = $('.close-modal');

    addButton.click(function (event) {
        event.preventDefault();

        modal.show();
        overlay.show();
        
    });

    closeModalButton.click(function () {
        modal.hide();
        overlay.hide();
    });
    
    });
    
</script>

</html>