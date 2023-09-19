<?php
session_start();
    if(!isset($_SESSION['idEditar']) || $_SESSION['idEditar']!=$_SESSION['idUsuario']){
        unset($_SESSION['idEditar']);
        header("Location: perfil.php");
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="perfil-edit">
                <div class="edit-filho">
                    <div class="error-text">
                    </div>
                </div>
                <div class="edit-filho">
                    <div id="foto-perfil">
                        <img id="imagem-preview" src="http://via.placeholder.com/150x180" alt="foto de perfil"><br>
                        <label class="fotoinput" for="foto">Escolha uma foto</label>
                        <input type="file" name="foto" id="foto" style="display:none">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="nome">Nome*: </label>
                            <input placeholder="Seu nome" type="text" name="nome" id="nome" value="" pattern="[a-zA-z'-'\s]*" required autocomplete="off">
                        </div>
                        <div class="input">
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
                        <div class="input">
                            <label for="linkedin">Linkedin:</label>
                            <input placeholder="Seu usuário do Linkedin" type="text" name="linkedin" id="linkedin" autocomplete="off">
                        </div>
                        <div class="input">
                            <label for="sobre">Sobre você:</label>
                            <textarea id="sobre" name="sobre" rows="4" cols="50" autocomplete="off" maxlength="255" placeholder="Fale sobre você"></textarea>
                        </div>
                    </div>

                </div>
                <div class="edit-filho auxedit-filho">
                    <div class="inputsenha">
                        <input  class="submit" type="submit" value="Concluir">
                        <a href="perfil.php">Cancelar</a>
                    </div>
                    <div class="inputsenha">
                        <div class="edit-filho">
                            <div class="input"><button type="button" id="botaosenha">Alterar senha</button></div>
                        </div>
                        <div class="edit-filho" id="inputsenha">
                            <div class="input">
                                <label for="senhaatual">Senha atual*:</label>
                                <input type="password" name="senhaatual" id="senhaatual" placeholder="Sua senha atual">
                            </div>
                            <div class="input">
                                <label for="senhanova">Nova senha*:</label>
                                <input type="password" name="senhanova" id="senhanova" placeholder="Nova senha">
                            </div>
                            <div class="input">
                                <label for="csenhanova">Confirmar nova senha*:</label>
                                <input type="password" name="csenhanova" id="csenhanova" placeholder="Confirme a nova senha">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
        </form>
    </main>
    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/perfil-editar.js"></script>

</html>