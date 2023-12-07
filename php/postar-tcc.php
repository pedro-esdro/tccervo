<?php
include_once './db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'] ?? "";
$idUsuarioFinal = $idUsuario;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeTcc = $_POST['nomeTcc'];
    $ano = $_POST['anoTcc'];
    $curso = $_POST['curso'];
    $descricao = $_POST['descricaoTcc'];
    $linkArquivo = $_POST['linkArquivo'] ?? "";
    $arquivoTcc = $_FILES['arquivoTcc'] ?? "";
    $foto = $_FILES['capaTcc'] ?? "";
    $odsSelecionadas = $_POST["ods"] ?? [];
    $autores = $_POST['autores'] ?? [];
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
    } else if (!isset($_FILES['arquivoTcc']) || $_FILES['arquivoTcc']['error'] != UPLOAD_ERR_OK) {
        echo "Insira um arquivo PDF.";
    } else if ($odsError) {
        echo "Selecione no mínimo 1 e no máximo 3 ODS.";
    } else {
        $idCurso = $idCursos[$curso];
        $ano = $ano . "-12-31";
        $horaAtual = date("Y-m-d H:i:s");
        $idTcc = rand(1000000, 9999999);

        $nomeTcc = mysqli_real_escape_string($conexao, $nomeTcc);
        $ano = mysqli_real_escape_string($conexao, $ano);
        $descricao = str_replace(array("\r", "\n"), '', $descricao);
        $descricao = mysqli_real_escape_string($conexao, $descricao);

        $caminhoArquivo = "../database/tcc/arquivos/";
        $nomeArquivo = $arquivoTcc["name"];
        $caminhoTemporarioArquivo = $arquivoTcc["tmp_name"];
        $nomeArquivo = uniqid() . "_" . $nomeArquivo;
        $caminhoFinalArquivo = $caminhoArquivo . $nomeArquivo;

        $existemnoBanco = array();
        $valoresDuplicados = array();
        if (isset($autores) && !empty($autores)) {
            if (!in_array($idUsuarioFinal, $autores)) {
                

                foreach ($autores as $autorAdicionar) {
                    if (ctype_digit($autorAdicionar)) {
                        $idUsuario = intval($autorAdicionar);
                        $stmt = $conexao->prepare("SELECT idUsuario FROM tbUsuario WHERE idUsuario = ?");
                        $stmt->bind_param('i', $idUsuario);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            // Verificar duplicatas
                            if (in_array($idUsuario, $existemnoBanco)) {
                                $valoresDuplicados[] = $idUsuario;
                            } else {
                                $existemnoBanco[] = $idUsuario;
                            }
                        } else {

                            echo "Usuário com ID $idUsuario não encontrado.";
                            die();
                        }
                    }
                }
                if (!empty($valoresDuplicados)) {
                    echo "Erro: Não insira IDs iguais nos campos de autores.";
                    die();
                }
            } else {
                echo "Erro: Não insira seu próprio id ($idUsuario) no campo de outros autores";
                die();
            }
        }

        if (move_uploaded_file($caminhoTemporarioArquivo, $caminhoFinalArquivo)) {
            $sqlInsert = "INSERT INTO tbTcc (idTcc, nomeTcc, anoTcc, descricaoTcc, arquivoTcc, data_postagem, idCurso) VALUES ($idTcc, '$nomeTcc', '$ano', '$descricao', '$nomeArquivo', '$horaAtual', $idCurso)";
            if (mysqli_query($conexao, $sqlInsert)) {
                if (!empty($foto) && $foto["error"] === UPLOAD_ERR_OK) {
                    $caminhoFoto = "../database/tcc/capas/";
                    $nomeFoto = $foto["name"];
                    $caminhoTemporario = $foto["tmp_name"];

                    $nomeFoto = uniqid() . "_" . $nomeFoto;
                    $caminhoFinal = $caminhoFoto . $nomeFoto;

                    if (move_uploaded_file($caminhoTemporario, $caminhoFinal)) {
                        mysqli_query($conexao, "UPDATE tbTcc SET capaTcc = '$nomeFoto' WHERE idTcc = $idTcc");
                    } else {
                        echo "Erro ao carregar imagem";
                    }
                }
                if (!empty($linkArquivo)) {
                    $linkArquivo = mysqli_real_escape_string($conexao, $linkArquivo);
                    $sqlInsertLink = "UPDATE tbTcc SET linkTcc = '$linkArquivo' WHERE idTcc = $idTcc";
                    if (!mysqli_query($conexao, $sqlInsertLink)) {
                        echo "Erro ao inserir link";
                    }
                }


                foreach ($odsSelecionadas as $ods) {
                    $idOds = obterIdDaOdsPorNome($ods, $conexao);

                    if ($idOds !== null) {
                        $sqlInsertOds = "INSERT INTO tbOds_tbTcc (idOds, idTcc) VALUES ($idOds, $idTcc)";
                        mysqli_query($conexao, $sqlInsertOds);
                    }
                }
                if (!empty($existemnoBanco)) {
                    foreach($existemnoBanco as $usuario)
                    {
                        mysqli_query($conexao, "INSERT INTO tbUsuario_tbTcc (idUsuario, idTcc) VALUES ($usuario, $idTcc)");      
                    }
                }
                mysqli_query($conexao, "INSERT INTO tbUsuario_tbTcc (idUsuario, idTcc) VALUES ($idUsuarioFinal, $idTcc)");
                $_SESSION['idRecemCriado'] = $idTcc;
                echo "success";
            } else {
                echo "Erro ao carregar TCC";
            }
        } else {
            echo "Erro ao carregar arquivo";
        }
    }
}


// Função para obter o ID da ODS a partir do nome
function obterIdDaOdsPorNome($nomeOds, $conexao)
{
    $nomeOds = mysqli_real_escape_string($conexao, $nomeOds);

    $sql = "SELECT idOds FROM tbOds WHERE nomeOds = '$nomeOds'";
    $result = mysqli_query($conexao, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['idOds'];
    } else {
        return null; // Retorne null se a ODS não for encontrada
    }
}
