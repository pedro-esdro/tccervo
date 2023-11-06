<?php
    include_once 'php/db.php'; 
    session_start();
    $idUsuario = $_SESSION['idUsuario'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de TCC</title>
    <link rel="stylesheet" type="text/css" href="css/tcc.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navfooter.css">
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
                    <label class="arquivoinput" for="foto">Escolher uma capa</label>
                    <input type="file" name="foto" id="foto" style="display:none">
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
                        <input type="text" name="nomeTcc" id="nomeTcc" required>
                    </div>

                    <div class="form-group">
                        <label for="anoTcc">Ano do TCC*:</label>
                        <select name="anoTcc" id="anoTcc" required>
                        <option value="">Selecione um ano</option>
                            <?php
                            $anoAtual = date("Y");
                            for ($ano = 1970; $ano <= $anoAtual; $ano++) {
                                echo "<option value='$ano'>$ano</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="descricaoTcc">Descrição do TCC:</label>
                        <textarea name="descricaoTcc" id="descricaoTcc" rows="4" cols="50" autocomplete="off" maxlength="255"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tipoArquivo">Escolha o tipo de envio:</label>
                        <select name="tipoArquivo" id="tipoArquivo">
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
                            <option value="Informática para Internet">Informática para Internet</option>
                            <option value="Administração">Administração</option>
                            <option value="Contabilidade">Contabilidade</option>
                            <option value="Recursos Humanos">Recursos Humanos</option>
                            <option value="Enfermagem">Enfermagem</option>
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
                <div class="form-row">
                    <div class="form-group">
                        <div class="ods-dropdown">
                            <div class="ods-dropdown-label">ODS</div>
                            <div class="ods-dropdown-content" id="odsDropdown">
                                <label><input type="checkbox" name="ods[]" value="1"><span>Sustentabilidade</span></label>
                                <label><input type="checkbox" name="ods[]" value="2"><span>ODS 2</span></label>
                                <label><input type="checkbox" name="ods[]" value="3"><span>ODS 3</span></label>
                                <label><input type="checkbox" name="ods[]" value="4"><span>ODS 4</span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </form>
    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/postartcc.js"></script>

</html>