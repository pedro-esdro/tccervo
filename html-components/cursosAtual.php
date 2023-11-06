<h4>Cursos Atuais</h4>
<ul>
    <?php
    // Consulta SQL para buscar cursos do usuário
    $sql = "SELECT UCurso.idCurso, C.nomeCurso
                                            FROM tbUsuario_tbCurso AS UCurso
                                            JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
                                            WHERE UCurso.idUsuario = $idUsuario";

    // Execute a consulta e exiba os cursos
    $result = mysqli_query($conexao, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>{$row['nomeCurso']} <button class='remover-curso' data-curso-id='{$row['idCurso']}'</button><i class='fas fa-times minibuttons'></i></li>";
    }
    ?>
</ul>