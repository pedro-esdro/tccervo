<?php
// Certifique-se de que o usuário esteja autenticado e obtenha o ID do usuário
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cursoId']) && isset($_SESSION['idUsuario'])) {
    $cursoId = $_POST['cursoId'];
    $idUsuario = $_SESSION['idUsuario'];
    // Conecte-se ao banco de dados
    include 'db.php';

    // Verifique se o curso já não está associado ao usuário
    $checkQuery = "SELECT * FROM tbUsuario_tbCurso WHERE idUsuario = $idUsuario AND idCurso = $cursoId";
    $checkResult = mysqli_query($conexao, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // O curso ainda não está associado ao usuário, então podemos adicioná-lo
        $insertQuery = "INSERT INTO tbUsuario_tbCurso (idUsuario, idCurso) VALUES ($idUsuario, $cursoId)";
        $insertResult = mysqli_query($conexao, $insertQuery);

        if ($insertResult) {
            // Se a inserção for bem-sucedida, você pode retornar uma resposta JSON
            echo "Sucesso";
        } 
}}
?>
