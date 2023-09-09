<?php

    session_start();
    include_once 'db.php';

    $emailUsuario = $_POST['email'];
    $senhaUsuario = md5($_POST['senha']);

    if(!empty($emailUsuario) && !empty($senhaUsuario))
    {
        $buscarUsuario = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE emailUsuario = '{$emailUsuario}' and senhaUsuario = '{$senhaUsuario}';");
        if(mysqli_num_rows($buscarUsuario) > 0)
        {
            $row = mysqli_fetch_assoc($buscarUsuario);
            if($row)
            {
                $_SESSION['idUsuario'] = $row['idUsuario'];
                $_SESSION['emailUsuario'] = $row['emailUsuario'];
                $_SESSION['codUsuario'] = $row['codUsuario'];
                echo "success";
            }
        }
        else
        {
            echo "A senha ou email estão incorretos";
        }
    }
    else
    {
        echo "Insira todos os dados!";
    }

?>