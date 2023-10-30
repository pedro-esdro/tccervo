<?php
include_once 'php/db.php';
session_start();
    if(!isset($_SESSION['idEditar']) || $_SESSION['idEditar']!=$_SESSION['idUsuario']){
        unset($_SESSION['idEditar']);
        header("Location: perfil.php");
    }
    else
    {
        $buscarUsuario = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = {$_SESSION['idEditar']}");
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
                            if (!empty($row["linkedinUsuario"])) {
                                $linkedin = $row["linkedinUsuario"];
                            }
                            else {
                                $linkedin = "";
                            }
                            if (!empty($row["sobreUsuario"])) {
                                $sobre = $row["sobreUsuario"];
                            }
                            else{
                                $sobre = "";
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
                        <img id="imagem-preview" src="<?= $foto ?>" alt="foto de perfil"><br>
                        <label class="fotoinput" for="foto">Escolha uma foto</label>
                        <input type="file" name="foto" id="foto" style="display:none">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="nome">Nome*: </label>
                            <input placeholder="Seu nome" type="text" name="nome" id="nome" value="<?= $nome ?>" pattern="[a-zA-z'-'\s]*" required autocomplete="off">
                        </div>
                        <div class="input">
                            <label for="curso">Curso*:</label>
                            <select name="curso" required>
                                <option value="">Selecione um curso</option>
                                <option value="Informática para Internet" <?php if ($curso == "Informática para Internet") echo "selected"; ?>>Informática para Internet</option>
                                <option value="Administração" <?php if ($curso == "Admnistração") echo "selected"; ?>>Administração</option>
                                <option value="Contabilidade" <?php if ($curso == "Contabilidade") echo "selected"; ?>>Contabilidade</option>
                                <option value="Recursos Humanos" <?php if ($curso == "Recursos Humanos") echo "selected"; ?>>Recursos Humanos</option>
                                <option value="Enfermagem" <?php if ($curso == "Enfermagem") echo "selected"; ?>>Enfermagem</option>
                            </select>
                        </div>
                        <div class="input">
                            <label for="linkedin">Linkedin:</label>
                            <input placeholder="Seu usuário do Linkedin" value="<?= $linkedin ?>"type="text" name="linkedin" id="linkedin" autocomplete="off">
                        </div>
                        <div class="input">
                            <label for="sobre">Sobre você:</label>
                            <textarea id="sobre" name="sobre" rows="4" cols="50" autocomplete="off" maxlength="255" placeholder="Fale sobre você"><?= $sobre ?></textarea>
                        </div>
                    </div>

                </div>
                <div class="edit-filho auxedit-filho">
                    <div class="inputsenha">
                        <input  class="submit" type="submit" value="Concluir">
                        <a href="perfil.php?idBusc=<?php echo $_SESSION['idUsuario'] ?? ""?>">Cancelar</a>
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