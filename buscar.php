<?php
include_once 'php/db.php'; 

if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $termoBusca = $_GET['busca'];

    // Consulta para buscar usuários por nome com o nome do curso
    $sqlUsuarios = "SELECT u.*, c.nomeCurso FROM tbUsuario u
                    LEFT JOIN tbCurso c ON u.idCurso = c.idCurso
                    WHERE u.nomeUsuario LIKE '%$termoBusca%'";
    $resultUsuarios = mysqli_query($conexao, $sqlUsuarios);

    // Consulta para buscar TCCs por nome
    $sqlTccs = "SELECT * FROM tbTcc WHERE nomeTcc LIKE '%$termoBusca%'";
    $resultTccs = mysqli_query($conexao, $sqlTccs);
} else {
    echo "aaaaaaaa";
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
    <?php while ($rowUsuario = mysqli_fetch_assoc($resultUsuarios)) : ?>
        <?php
        if (!empty($rowUsuario['fotoUsuario'])) {
            $caminhofoto = "database/fotosUsuarios/".$rowUsuario['fotoUsuario'];
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
            <p><?= $rowUsuario['nomeCurso'] ?></p>
            <a href="perfil.php?idBusc=<?php echo $rowUsuario['idUsuario']; ?>" class="btn-link">
            <button class="btn">Ver Perfil</button>
            </a>
        </div>
    <?php endwhile; ?>
</div>
    
    <h2>TCCs Encontrados</h2>
    <div class="tcc-cards">
        <?php while ($rowTcc = mysqli_fetch_assoc($resultTccs)) : ?>
            <div class="tcc-card">
                <h3><?= $rowTcc['nomeTcc'] ?></h3>
                <p>Descrição: <?= $rowTcc['descricaoTcc'] ?></p>
                <!-- Adicione outras informações do TCC conforme necessário -->
            </div>
        <?php endwhile; ?>
    </div>
</main>
<?php include 'html-components/footer.php'; ?>
</body>
</html>
