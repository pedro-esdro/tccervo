<?php

    include_once 'db.php';
    session_start();

    $cod1 = $_POST['cod1'];
    $cod2 = $_POST['cod2'];
    $cod3 = $_POST['cod3'];
    $cod4 = $_POST['cod4'];

    $codInserido = $cod1.$cod2.$cod3.$cod4;
    $codUsuarioRec = $_SESSION["codUsuarioRec"];

    if(!empty($codInserido))
    {
        if($codInserido == $codUsuarioRec)
        {
            $_SESSION["recIsOk"] = 1;
            echo "success";
        }
        else
        {
            echo "Insira o código correto!";
        }
    }
    else
    {
        echo "Insira o código completo!";
    }
?>