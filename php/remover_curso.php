<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cursoId']) && isset($_SESSION['idUsuario'])) {
    $cursoId = $_POST['cursoId'];
    $idUsuario = $_SESSION['idUsuario'];

    include 'db.php';

    // Verifique se o curso está associado ao usuário
    $checkQuery = "SELECT * FROM tbUsuario_tbCurso WHERE idUsuario = $idUsuario AND idCurso = $cursoId";
    $checkResult = mysqli_query($conexao, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // O curso está associado ao usuário, então podemos removê-lo
        $deleteQuery = "DELETE FROM tbUsuario_tbCurso WHERE idUsuario = $idUsuario AND idCurso = $cursoId";
        $deleteResult = mysqli_query($conexao, $deleteQuery);

        if ($deleteResult) {
            echo "Removido com sucesso";
        } }}
?>
