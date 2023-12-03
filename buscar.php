<?php
include_once 'php/db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'] ?? "";

if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $termoBusca = $_GET['busca'];

    $sqlUsuarios = "select * from tbUsuario where nomeUsuario LIKE '%$termoBusca%'";

    $resultUsuarios = mysqli_query($conexao, $sqlUsuarios);

    // Consulta para buscar TCCs por nome
    $sqlTccs = "SELECT * FROM tbTcc WHERE nomeTcc LIKE '%$termoBusca%'";
    $resultTccs = mysqli_query($conexao, $sqlTccs);
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca</title>
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/busca.css">
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <main>
        <h1>Resultados da Busca</h1>

        <h2>Usuários Encontrados</h2>
        <div class="user-cards">
            <?php
            if (mysqli_num_rows($resultUsuarios) > 0) {
                while ($rowUsuario = mysqli_fetch_assoc($resultUsuarios)) :
                    if (!empty($rowUsuario['fotoUsuario'])) {
                        $caminhofoto = "database/fotosUsuarios/" . $rowUsuario['fotoUsuario'];
                        if (file_exists($caminhofoto)) {
                            $foto = $caminhofoto;
                        } else {
                            $foto = "assets/icons/avatar.svg";
                        }
                    } else {
                        $foto = "assets/icons/avatar.svg";
                    }
            ?>
                    <div class="user-card">
                        <img src="<?= $foto ?>" alt="Foto de perfil">
                        <h3><?= $rowUsuario['nomeUsuario'] ?></h3>
                        <br>
                        <h4>Cursos</h4>
                        <?php
                        $sqlCurso = "SELECT UCurso.idCurso, C.nomeCurso
                    FROM tbUsuario_tbCurso AS UCurso
                    JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
                    WHERE UCurso.idUsuario = {$rowUsuario['idUsuario']}
                    LIMIT 3";
                        $cont = 0;

                        $resultCursos = mysqli_query($conexao, $sqlCurso);

                        while ($rowCurso = mysqli_fetch_assoc(($resultCursos))) {
                            $cont++;
                            if ($cont < 3) {
                                echo "<p>{$rowCurso['nomeCurso']}</p>";
                            } else {
                                echo "<p><strong>e outros...</strong></p>";
                            }
                        }
                        ?>
                        <a href="perfil.php?idBusc=<?php echo $rowUsuario['idUsuario']; ?>" class="btn-link" target="_blank">
                            <button class="btn">Ver Perfil</button>
                        </a>
                    </div>
                    
                <?php endwhile; ?>
            <?php
            } else {
                echo "<p>Nenhum usuário encontrado pela pesquisa.</p>";
            }
            ?>
        </div>

        <h2>TCCs Encontrados</h2>
        <div class="tcc-cards">
            <?php
            if (mysqli_num_rows($resultTccs) > 0) {
                while ($rowTcc = mysqli_fetch_assoc($resultTccs)) :
                    if (!empty($rowTcc['capaTcc'])) {
                        $caminhocapa = "database/tcc/capas/" . $rowTcc['capaTcc'];
                        if (file_exists($caminhocapa)) {
                            $capa = $caminhocapa;
                        } else {
                            $capa = "https://placehold.co/150x180?text=Capa";
                        }
                    } else {
                        $capa = "https://placehold.co/150x180?text=Capa";
                    }
                    $sqlCursoTcc = mysqli_query($conexao, "SELECT * FROM tbCurso where idCurso = {$rowTcc['idCurso']}");
                    $cursoTcc = mysqli_fetch_assoc($sqlCursoTcc)
            ?>
                    <div class="tcc-card">
                        <img src="<?= $capa ?>" alt="Foto da capa">
                        <h3><?= $rowTcc['nomeTcc'] ?></h3>
                        <br>
                        <h4>Curso</h4>
                        <p><?= $cursoTcc['nomeCurso'] ?></p>
                        <p><?= date("Y", strtotime($rowTcc['anoTcc'])) ?></p>
                        <a href="tcc-detalhes.php?idBuscTcc=<?php echo $rowTcc['idTcc']; ?>" class="btn-link" target="_blank">
                            <button class="btn">Ver mais detalhes</button>
                        </a>
                    </div>
            <?php endwhile;
            } else {
                echo "<p>Nenhum TCC encontrado pela pesquisa.</p>";
            }
            ?>
        </div>
    </main>
    <?php include 'html-components/footer.php'; ?>
</body>

</html>