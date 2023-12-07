<?php
include_once 'php/db.php';
session_start();

if (!isset($_SESSION['idEditar']) || $_SESSION['idEditar'] != $_SESSION['idUsuario']) {
    unset($_SESSION['idEditar']);
    header("Location: perfil.php");
} else {
    $idUsuario = $_SESSION['idEditar'];

    $nome = $curso = $linkedin = $sobre = $foto = '';

    $buscarUsuario = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = $idUsuario");
    if ($buscarUsuario) {
        if (mysqli_num_rows($buscarUsuario) > 0) {
            $row = mysqli_fetch_assoc($buscarUsuario);
            if ($row) {
                $nome = $row["nomeUsuario"];
                $linkedin = !empty($row["linkedinUsuario"]) ? $row["linkedinUsuario"] : "";
                $sobre = !empty($row["sobreUsuario"]) ? $row["sobreUsuario"] : "";

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/perfil.css">
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <div id="customSpinner">
    </div>
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
                        <div class="input nome">
                            <label for="nome">Nome*: </label>
                            <input placeholder="Seu nome" type="text" name="nome" id="nome" value="<?= $nome ?>" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]*" required autocomplete="off">
                        </div>
                        <div class="input linkedin">
                            <label for="linkedin">Linkedin - Link de perfil:</label>
                            <input id="linkedin" placeholder="https://www.linkedin.com/in/exemplo/" value="<?= $linkedin ?>" type="text" name="linkedin" pattern="^https:\/\/www\.linkedin\.com\/in\/.+$" id="linkedin" autocomplete="off">
                            <small>Formato: <strong>https://www.linkedin.com/in/exemplo/</strong></small>
                        </div>
                        <div class="input sobreinput">
                            <label for="sobre">Sobre você:</label>
                            <textarea id="sobre" name="sobre" rows="4" cols="50" autocomplete="off" maxlength="255" placeholder="Fale sobre você"><?= $sobre ?></textarea>
                        </div>
                        <div id="cursos-atuais" class="botoes">
                            <h4>Cursos</h4>
                            <ul>
                                <?php
                                // Consulta SQL para buscar cursos do usuário
                                $sql = "SELECT UCurso.idCurso, C.nomeCurso
                                            FROM tbUsuario_tbCurso AS UCurso
                                            JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
                                            WHERE UCurso.idUsuario = $idUsuario";

                                // Execute a consulta e exiba os cursos
                                $result = mysqli_query($conexao, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<li>{$row['nomeCurso']} <button type='button'class='remover-curso' data-curso-id='{$row['idCurso']}'</button><i class='fas fa-times minibuttons'></i></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="cursos-disponiveis" class="botoes">
                            <h4>Adicionar cursos</h4>
                            <ul>
                                <?php
                                // Consulta SQL para buscar cursos que o usuário ainda não tem
                                $sql = "SELECT C.idCurso, C.nomeCurso
                                        FROM tbCurso AS C
                                        WHERE C.idCurso NOT IN (
                                            SELECT UCurso.idCurso
                                            FROM tbUsuario_tbCurso AS UCurso
                                            WHERE UCurso.idUsuario = $idUsuario
                                        )";

                                // Execute a consulta e exiba os cursos
                                $result = mysqli_query($conexao, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<li>{$row['nomeCurso']} <button type='button'class='adicionar-curso' data-curso-id='{$row['idCurso']}'><i class='fas fa-plus minibuttons'></i></button></li>";
                                }
                                ?>
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="edit-filho auxedit-filho">
                    <div class="inputsenha">
                        <input class="submit" type="submit" value="Concluir">
                        <br>
                        <a class="cancelar1" href="perfil.php?idBusc=<?php echo $_SESSION['idUsuario'] ?? "" ?>">Cancelar</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script src="js/perfil-editar.js"></script>

</html>