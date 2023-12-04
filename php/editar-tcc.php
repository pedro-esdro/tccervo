<?php
include_once './db.php';
session_start();

$idUsuario = $_SESSION['idUsuario'] ?? "";
if (!isset($_SESSION['idEditarTcc']) || $_SESSION['idEditarTcc'] != $idUsuario) {
    unset($_SESSION['idEditarTcc']);
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idTccParaEditar = $_SESSION['idEditarTcc_idTcc'];

    // Verificar se o ID do TCC a ser editado foi fornecido na URL
    if (empty($idTccParaEditar)) {
        echo "ID do TCC não fornecido.";
        exit;
    }

    // Buscar as ODS atualmente associadas ao TCC no banco de dados
    $sqlOdsDoTcc = "SELECT idOds FROM tbOds_tbTcc WHERE idTcc = $idTccParaEditar";
    $resultOdsDoTcc = mysqli_query($conexao, $sqlOdsDoTcc);

    // Lista das ODS associadas atualmente ao TCC
    $odsAtuais = [];
    while ($rowOdsDoTcc = mysqli_fetch_assoc($resultOdsDoTcc)) {
        $odsAtuais[] = $rowOdsDoTcc['idOds'];
    }

    // ODS selecionadas no formulário
    $odsSelecionadas = $_POST["ods"] ?? [];

    // Identificar ODS a serem removidas
    $odsParaRemover = array_diff($odsAtuais, $odsSelecionadas);

    // Identificar ODS a serem adicionadas
    $odsParaAdicionar = array_diff($odsSelecionadas, $odsAtuais);

    // Remover as ODS que foram desselecionadas
    foreach ($odsParaRemover as $odsRemover) {
        $sqlRemoverOds = "DELETE FROM tbOds_tbTcc WHERE idTcc = $idTccParaEditar AND idOds = $odsRemover";
        mysqli_query($conexao, $sqlRemoverOds);
    }

    // Adicionar as novas ODS selecionadas
    foreach ($odsParaAdicionar as $odsAdicionar) {
        $sqlAdicionarOds = "INSERT INTO tbOds_tbTcc (idOds, idTcc) VALUES ($odsAdicionar, $idTccParaEditar)";
        mysqli_query($conexao, $sqlAdicionarOds);
    }

    // Atualizar o restante das informações do TCC
    $nomeTcc = $_POST['nomeTcc'];
    $ano = $_POST['anoTcc'];
    $curso = $_POST['curso'];
    $descricao = $_POST['descricaoTcc'];
    $arquivoTcc = $_FILES['arquivoTcc'] ?? "";
    $linkArquivo = $_POST['linkArquivo'] ?? "";
    $foto = $_FILES['capaTcc'] ?? "";
    $idCursos = array(
        "Informática para Internet" => 1,
        "Administração" => 2,
        "Contabilidade" => 3,
        "Recursos Humanos" => 4,
        "Enfermagem" => 5,
        "Desenvolvimento de Sistemas" => 6,
        "Segurança do Trabalho" => 7
    );

    $odsError = false; // Variável para controlar erros relacionados às ODS

    if (empty($odsSelecionadas) || count($odsSelecionadas) < 1 || count($odsSelecionadas) > 3) {
        $odsError = true;
    }

    $otherFieldsError = empty($nomeTcc) || empty($ano) || !isset($curso);

    if (empty($nomeTcc) || empty($ano) || empty($curso) || empty($descricao)) {
        echo "Preencha todas as informações obrigatórias(*).";
    } elseif ($odsError) {
        echo "Selecione no mínimo 1 e no máximo 3 ODS.";
    } else {
        $idCurso = $idCursos[$curso];
        $ano = $ano . "-12-31";

        $nomeTcc = mysqli_real_escape_string($conexao, $nomeTcc);
        $ano = mysqli_real_escape_string($conexao, $ano);
        $descricao = str_replace(array("\r", "\n"), '', $descricao);
        $descricao = mysqli_real_escape_string($conexao, $descricao);
        $linkArquivo = mysqli_real_escape_string($conexao, $linkArquivo);
        $sqlUpdateTcc = "UPDATE tbTcc SET 
            nomeTcc = '$nomeTcc', 
            anoTcc = '$ano', 
            descricaoTcc = '$descricao', 
            idCurso = $idCurso 
            WHERE idTcc = $idTccParaEditar";

        if (mysqli_query($conexao, $sqlUpdateTcc)) {
            // Processar a imagem da capa se fornecida
            if (!empty($foto) && $foto["error"] === UPLOAD_ERR_OK) {
                $caminhoFoto = "../database/tcc/capas/";
                $nomeFoto = $foto["name"];
                $caminhoTemporario = $foto["tmp_name"];

                $nomeFoto = uniqid() . "_" . $nomeFoto;
                $caminhoFinal = $caminhoFoto . $nomeFoto;

                if (move_uploaded_file($caminhoTemporario, $caminhoFinal)) {
                    // Atualizar o nome da capa no banco de dados
                    mysqli_query($conexao, "UPDATE tbTcc SET capaTcc = '$nomeFoto' WHERE idTcc = $idTccParaEditar");
                } else {
                    echo "Erro ao carregar imagem";
                }
            }
            if (!empty($linkArquivo)){
                mysqli_query($conexao, "UPDATE tbTcc SET linkTcc = '$linkArquivo' WHERE idTcc = $idTccParaEditar");
            }
            else {
                mysqli_query($conexao, "UPDATE tbTcc SET linkTcc = '' WHERE idTcc = $idTccParaEditar");
            }
            if (isset($_FILES['arquivoTcc']) && $_FILES['arquivoTcc']['error'] == UPLOAD_ERR_OK){
                $caminhoArquivo = "../database/tcc/arquivos/";
                $nomeArquivo = $arquivoTcc["name"];
                $caminhoTemporarioArquivo = $arquivoTcc["tmp_name"];
                $nomeArquivo = uniqid() . "_" . $nomeArquivo;
                $caminhoFinalArquivo = $caminhoArquivo . $nomeArquivo;

                if (move_uploaded_file($caminhoTemporarioArquivo, $caminhoFinalArquivo)) {
                    mysqli_query($conexao, "UPDATE tbTcc SET arquivoTcc = '$nomeArquivo' WHERE idTcc = $idTccParaEditar");
                }
                else {
                    echo "Erro ao alterar o arquivo";
                }
            }
            $_SESSION['idRecemEditTcc'] = $idTccParaEditar;
            echo "success";
        } else {
            echo "Erro ao atualizar TCC";
        }
    }
}
?>
