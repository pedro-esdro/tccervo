<?php
    include_once './db.php'; 
    session_start();

    $senha = md5($_POST['senha']);
    $csenha = md5($_POST['csenha']);
    $emailUsuarioRec = $_SESSION['emailUsuarioRec'];
    $idUsuario = $_SESSION['idUsuario'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Se o formulário foi enviado via POST
        if (empty($_POST['senha']) || empty($_POST['csenha'])) {
            echo "Insira todos os campos!";
            exit; // Sai do script
        }
        else {
            if (strlen($_POST['senha']) >= 8){
                if($senha == $csenha)
                {
                    $registro = mysqli_query($conexao, "SELECT * FROM tbUsuario where emailUsuario = '$emailUsuarioRec'");
                    if($registro)
                    {
                        $row = mysqli_fetch_assoc($registro);
                        if($row)
                        {
                            if($row["idUsuario"] == $idUsuario)
                            {
                                $alterarsenha = mysqli_query($conexao, "UPDATE tbUsuario SET senhaUsuario = '$senha' WHERE idUsuario = '{$idUsuario}';");
                                if($alterarsenha)
                                {
                                    session_unset();
                                    session_destroy();
                                    echo "success";
                                }
                                else
                                {
                                    echo "Erro ao alterar senha";
                                }
                            }
                            else
                            {
                                echo "Erro ao alterar senha";
                            }
                        }
                        else
                        {
                            echo "Erro ao alterar senha";
                        }
                    }
                    else
                    {
                        echo "Erro ao alterar senha";
                    }
                }
                else
                {
                    echo "As senhas inseridas não são iguais!";
                }
            }
            else {
                echo "A senha deve ter 8 ou mais caracteres";
            }
        }
    } else {
        echo "Algum erro aconteceu";
    }
?>