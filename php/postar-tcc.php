<?php
include_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeTcc = $_POST['nomeTcc'];
    $ano = $_POST['anoTcc'];
    $curso = $_POST['curso'];
    $descricao = $_POST['descricaoTcc'] ?? "";
    $tipoArquivo = $_POST['tipoArquivo'];
    $linkArquivo = $_POST['linkArquivo'] ?? "";
    $uploadArquivo = $_FILES['arquivoTcc'] ?? "";
    $foto = $_FILES['capaTcc'] ?? "";
    $odsSelecionadas = $_POST["ods"] ?? [];

    $idCursos = array(
        "Informática para Internet" => 1,
        "Administração" => 2,
        "Contabilidade" => 3,
        "Recursos Humanos" => 4,
        "Enfermagem" => 5
    );

    if (empty($nomeTcc) || empty($ano) || empty($curso)) {
        echo "Insira todas as informações obrigatórias(*)";
    } else {
        $idCurso = $idCursos[$curso];
        $ano = $ano . "-12-31";
        $horaAtual = date("Y-m-d H:i:s");
        $idTcc = rand(1000000, 9999999);

        if ($tipoArquivo === "upload" && (!empty($uploadArquivo) && $uploadArquivo["error"] === UPLOAD_ERR_OK)) {
            $caminhoArquivo = "../database/tcc/arquivos/";
            $nomeArquivo = $uploadArquivo["name"];
            $caminhoTemp = $uploadArquivo["tmp_name"];

            $nomeArquivo = uniqid() . "_" . $nomeArquivo;
            $caminhoArquivoFinal = $caminhoArquivo . $nomeArquivo;
            
            if (move_uploaded_file($caminhoTemp, $caminhoArquivoFinal)) {
                $sqlInsert = "INSERT INTO tbTcc (idTcc, nomeTcc, anoTcc, arquivoTcc, data_postagem, idCurso) VALUES ($idTcc, '$nomeTcc', '$ano', '$nomeArquivo', '$horaAtual', $idCurso)";
                
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
                    
                    if (!empty($descricao)) {
                        mysqli_query($conexao, "UPDATE tbTcc SET descricaoTcc = '$descricao' WHERE idTcc = $idTcc");
                    }
                    
                    if (!empty($odsSelecionadas)) {
                        if (count($odsSelecionadas) >= 1 && count($odsSelecionadas) <= 3) {
                            foreach ($odsSelecionadas as $ods) {
                                $idOds = obterIdDaOdsPorNome($ods, $conexao);
                                
                                if ($idOds !== null) {
                                    $sqlInsertOds = "INSERT INTO tbOds_tbTcc (idOds, idTcc) VALUES ($idOds, $idTcc)";
                                    mysqli_query($conexao, $sqlInsertOds);
                                }
                            }
                            echo "success";
                        } else {
                            echo "Escolha no mínimo 1 e no máximo 3 ODS.";
                        }
                    } else {
                        echo "Escolha no mínimo 1 ODS.";
                    }
                } else {
                    echo "Erro ao carregar TCC";
                }
            } else {
                echo "Erro ao carregar TCC";
            }
        } elseif (!empty($linkArquivo)) {
            $nomeArquivo = $linkArquivo;
            $sqlInsert = "INSERT INTO tbTcc (idTcc, nomeTcc, anoTcc, arquivoTcc, data_postagem, idCurso) VALUES ($idTcc, '$nomeTcc', '$ano', '$nomeArquivo', '$horaAtual', $idCurso)";
            
            if (mysqli_query($conexao, $sqlInsert)) {
                if (!empty($odsSelecionadas)) {
                    if (count($odsSelecionadas) >= 1 && count($odsSelecionadas) <= 3) {
                        foreach ($odsSelecionadas as $ods) {
                            $idOds = obterIdDaOdsPorNome($ods, $conexao);
                            
                            if ($idOds !== null) {
                                $sqlInsertOds = "INSERT INTO tbOds_tbTcc (idOds, idTcc) VALUES ($idOds, $idTcc)";
                                mysqli_query($conexao, $sqlInsertOds);
                            }
                        }
                        echo "success";
                    } else {
                        echo "Escolha no mínimo 1 e no máximo 3 ODS.";
                    }
                } else {
                    echo "Escolha no mínimo 1 ODS.";
                }
            } else {
                echo "Erro ao carregar TCC";
            }
        } else {
            echo "Insira todas as informações obrigatórias(*)";
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
