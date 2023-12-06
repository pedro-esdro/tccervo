<?php

    $conexao = new mysqli('localhost:3307', 'root', '', 'dbtccervo');

    if (!$conexao){
        echo "Conexão com o banco de dados falhou" . mysqli_connect_error();
    }

?>