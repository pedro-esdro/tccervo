<?php
include_once 'db.php';
session_start();

$idUsuario = $_SESSION['idUsuario'] ?? "";
if(!isset($_SESSION['idEditar']) || $_SESSION['idEditar']!=$_SESSION['idUsuario']){
    unset($_SESSION['idEditar']);
    header("Location: perfil.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sqlUpdate = "UPDATE tbUsuario SET";

    $updates = array();

    $nome = $_POST['nome'];
    $foto = $_FILES['foto'] ?? "";
    $linkedin = $_POST['linkedin'] ?? "";
    $sobre = $_POST['sobre'] ?? "";

    if (!empty($nome)) {
        if (preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s\'-]+$/', $nome)) {
            $updates[] = "nomeUsuario = '$nome'";
            if (!empty($foto) && $foto["error"] === UPLOAD_ERR_OK) {
                $caminhoFoto = "../database/fotosUsuarios/";
                $nomeFoto = $foto["name"];
                $caminhoTemporario = $foto["tmp_name"];
        
                $nomeFoto = uniqid() . "_" . $nomeFoto;
                $caminhoFinal = $caminhoFoto . $nomeFoto;
        
                if (move_uploaded_file($caminhoTemporario, $caminhoFinal)) {
                    $updates[] = "fotoUsuario = '$nomeFoto'";
                } else {
                    echo "Erro ao carregar imagem";
                }
            }
            if (!empty($linkedin)) {
                $updates[] = "linkedinUsuario = '$linkedin'";
            }
            else {
                $updates[] = "linkedinUsuario = ''";
            }
    
            if (!empty($sobre)) {
                $updates[] = "sobreUsuario = '$sobre'";
            }
            else
            {
                $updates[] = "sobreUsuario = ''";
            }
            if (!empty($_POST['senhaatual']) || !empty($_POST['senhanova']) || !empty($_POST['csenhanova'])) {
                if (
                    empty($_POST['senhaatual']) ||
                    empty($_POST['senhanova']) ||
                    empty($_POST['csenhanova'])
                ) {
                    $updates = null;
                    echo "Erro: Insira todos os campos de senha obrigatórios (campos marcados com um \"*\")!";
                } else {
                    $senha = md5($_POST['senhaatual']);
                    $nsenha = md5($_POST['senhanova']);
                    $cnsenha = md5($_POST['csenhanova']);
            
                    $select = mysqli_query($conexao, "SELECT senhaUsuario FROM tbUsuario WHERE idUsuario = $idUsuario;");
                    if (mysqli_num_rows($select) > 0) {
                        $row = mysqli_fetch_assoc($select);
                        if ($senha == $row['senhaUsuario']) {
                            if (strlen($_POST['senhanova']) >= 8) { 
                                if ($nsenha == $cnsenha) {
                                    if ($senha != $nsenha) {
                                        $updates[] = "senhaUsuario = '$nsenha'";
                                    } else {
                                        $updates = null;
                                        echo "Você não pode alterar sua senha para ela mesma!";
                                    }
                                } else {
                                    $updates = null;
                                    echo "As novas senhas inseridas não estão iguais!";
                                }
                            } else {
                                $updates = null;
                                echo "A senha deve conter 8 ou mais caracteres!";
                            }
                        } else {
                            $updates = null;
                            echo "A senha inserida por você não é igual a sua senha atual!";
                        }
                    }
                }
            }
        } 
        else {
            echo "Erro: O nome deve conter apenas letras, caracteres acentuados e espaços.";
        }       
    }
    else
    {
        echo "Insira todas as informações obrigatórias! ( * )";
    }


    if (!empty($updates)) {
        $sqlUpdate .= " " . implode(", ", $updates);
        $sqlUpdate .= " WHERE idUsuario = $idUsuario;";
        $_SESSION['idRecemEdit'] = $idUsuario;

        if (mysqli_query($conexao, $sqlUpdate)) {
            echo "success";
        } else {
            echo "Erro ao atualizar";
        }
        
    }
}
?>