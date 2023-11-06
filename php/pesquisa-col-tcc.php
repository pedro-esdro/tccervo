<?php
include 'db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'];

if (isset($_POST['query'])) {
    // Sanitize the input
    $searchTerm = mysqli_real_escape_string($conexao, $_POST['query']);

    $sqlConsulta = "SELECT * FROM tbUsuario WHERE nomeUsuario LIKE '%$searchTerm%' AND idUsuario <> $idUsuario";
    $sqlUsuarios = mysqli_query($conexao, $sqlConsulta);

    if ($sqlUsuarios && mysqli_num_rows($sqlUsuarios) > 0) {
        while ($rowUsuario = mysqli_fetch_assoc($sqlUsuarios)) : ?> 
        <?php
            if (!empty($rowUsuario['fotoUsuario'])) {
                $caminhofoto = "./database/fotosUsuarios/".$rowUsuario['fotoUsuario'];
                if (file_exists($caminhofoto)) {
                    $foto = $caminhofoto;
                } else {
                    $foto = "assets/icons/avatar.svg";
                }
            }
        ?>
        <div class="user-card-2">
            <img src="<?= $caminhofoto ?>" alt="Foto de perfil">
            <h3><?= $rowUsuario['nomeUsuario'] ?></h3>
            <br>
            <h4>Cursos</h4>
            <?php 
                    $sqlCurso = "SELECT UCurso.idCurso, C.nomeCurso
                    FROM tbUsuario_tbCurso AS UCurso
                    JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
                    WHERE UCurso.idUsuario = {$rowUsuario['idUsuario']}";
                    
                    $resultCursos = mysqli_query($conexao, $sqlCurso);

                    while ($rowCurso = mysqli_fetch_assoc(($resultCursos))){
                        echo "<p>{$rowCurso['nomeCurso']}</p>" ; 
                    }
            ?>
            <button class='adicionar-usuario' data-id="<?php echo $rowUsuario['idUsuario'] ?>">Adicionar</button>
            </a>
        </div>
    <?php endwhile; ?>
    <?php
    } else {
        echo "Nenhum resultado encontrado.";
    }
}
?>
