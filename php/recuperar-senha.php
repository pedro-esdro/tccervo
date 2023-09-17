<?php

    include_once "db.php";
    include_once './mail.php';

    session_start();
    $emailUsuario = $_POST['email'];
    
    if(!empty($emailUsuario))
    {

        if(filter_var($emailUsuario, FILTER_VALIDATE_EMAIL))
        {
            $buscarUsuario = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE emailUsuario = '{$emailUsuario}';");

            if(mysqli_num_rows($buscarUsuario) > 0)
            {
                $row = mysqli_fetch_assoc($buscarUsuario);
                $codUsuarioRec = mt_rand(1111, 9999);

                $_SESSION['idUsuario'] = $row['idUsuario'];
                $_SESSION['emailUsuarioRec'] = $row['emailUsuario'];
                $_SESSION['nomeUsuario'] = $row['nomeUsuario'];
                $_SESSION['codUsuarioRec'] = $codUsuarioRec;

                if($codUsuarioRec)
                {
                    if(sendEmail($row["nomeUsuario"], $row['emailUsuario'], $codUsuarioRec)){
                        echo "success";
                    }
                    else{
                        echo "Problema no envio do email. Tente novamente!";
                    }
                }
                else
                {
                    echo "Problema na criação do código de recuperação. Tente novamente!";
                }
            }
            else
            {
                echo "Esse email não consta em nosso sistema.";
            }
        }
        else
        {
            echo "Insira um e-mail válido!";
        }
    }
    else
    {
        echo "Preencha o campo!";
    }

?>