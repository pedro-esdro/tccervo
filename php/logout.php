<?php

    session_start();
    include_once 'db.php';
    if(isset($_SESSION['idUsuario']))
    {
        $idLogout = mysqli_real_escape_string($conexao, $_GET['logout_id']);
        if(isset($idLogout))
        {
            session_unset();
            session_destroy();
            header("location: ../login.php");
        }
        else
        {
            header("location: ../index.php");
        }
    }
    else
    {
        header("location: ../login.php");
    }