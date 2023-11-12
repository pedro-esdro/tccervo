<?php
include_once './db.php';
session_start();

$idUsuario = $_SESSION['idUsuario'] ?? "";

// Verificar se o ID do TCC a ser deletado foi fornecido na URL
$idTccParaDeletar = $_POST['idTcc'] ?? null;
if (empty($idTccParaDeletar)) {
    echo json_encode(['success' => false]);
    exit;
}

// Deletar entradas associadas na tabela tcc_ods
$sqlDeletarOds = "DELETE FROM tbods_tbtcc  WHERE idTcc = $idTccParaDeletar";
mysqli_query($conexao, $sqlDeletarOds);

// Deletar entradas associadas na tabela tcc_usuario
$sqlDeletarUsuario = "DELETE FROM tbusuario_tbtcc WHERE idTcc = $idTccParaDeletar";
mysqli_query($conexao, $sqlDeletarUsuario);

// Deletar o TCC da tabela tcc
$sqlDeletarTcc = "DELETE FROM tbtcc WHERE idTcc = $idTccParaDeletar";
if (mysqli_query($conexao, $sqlDeletarTcc)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
