<?php

    $conexao = new mysqli('localhost', 'root', '12345678', 'dbtccervo');

    if (!$conexao){
        echo "Conexão com o banco de dados falhou" . mysqli_connect_error();
    }

?>