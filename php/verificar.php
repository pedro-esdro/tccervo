<?php

    include_once 'db.php';
    session_start();

    //Recebendo os números inseridos
    $cod1 = $_POST['cod1'];
    $cod2 = $_POST['cod2'];
    $cod3 = $_POST['cod3'];
    $cod4 = $_POST['cod4'];
    //Recendo o id e o código gerado para o usuário
    $idUsuario = $_SESSION['idUsuario'];
    $codUsuario = $_SESSION['codUsuario'];
    //Código inserido pelo usuário
    $codInserido = $cod1.$cod2.$cod3.$cod4;

    if(!empty($codInserido))
    {
        // Checa se o código inserido é igual ao código gerado
        if($codInserido == $codUsuario)
        {
            // Pesquisa um registro para saber se o id do usuario confere com o código inserido
            $sqlCheckIdCod = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE idUsuario = '{$idUsuario}' AND codUsuario = '{$codInserido}';");
            if (mysqli_num_rows($sqlCheckIdCod) > 0)
            {
                $codVazio = 0; // Deixa o código como 0 já que verificou e muda o status de verificação do usuário para verificado
                $sqlDeixarVerificado = mysqli_query($conexao, "UPDATE tbUsuario SET `verificacaoUsuario` = 'Verificado',`codUsuario` = '$codVazio' WHERE idUsuario = '{$idUsuario}';");

                if($sqlDeixarVerificado)
                {
                    $row = mysqli_fetch_assoc($sqlCheckIdCod);
                    if($row)
                    {
                        $_SESSION['idUsuario'] = $row['idUsuario'];
                        $_SESSION['verificacaoUsuario'] = $row['verificacaoUsuario'];
                        echo "success";
                    }
                }
            }
        }
        else
        {
            echo "Código errado!";
        }
    }
    else
    {
        echo "Insira o código completo.";
    }

?>