<style>
        /* Estilo para os cards */
        .cardtcc {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
        }

        .cardtcc img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .cardtcc-info {
            flex: 1;
        }

        .cardtcc h3 {
            margin: 0;
            font-size: 18px;
        }

        .cardtcc p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
<?php
    include 'db.php';

    $idBusc = 5226997;

    $sqlSelect = "SELECT TCC.* 
    FROM tbUsuario AS U
    JOIN tbUsuario_tbTcc AS UT ON U.idUsuario = UT.idUsuario
    JOIN tbTcc AS TCC ON UT.idTcc = TCC.idTcc
    WHERE U.idUsuario = $idBusc;
    ";

    $sqlQuery = mysqli_query($conexao, $sqlSelect);

    if($sqlQuery && mysqli_num_rows($sqlQuery) > 0)
    {
        while ($queryRow = mysqli_fetch_assoc($sqlQuery)) { 
            $sqlCurso = mysqli_query($conexao, "SELECT nomeCurso from tbCurso WHERE idCurso = {$queryRow['idCurso']}");
            $resultCurso = mysqli_fetch_assoc($sqlCurso);
            $nomeCurso = $resultCurso['nomeCurso'];
            if (!empty($queryRow['capaTcc'])) {
                $caminhocapa = "database/tcc/capas/" . $queryRow['capaTcc'];
                if (file_exists($caminhocapa)) {
                    $capa = $caminhocapa;
                } else {
                    $capa = "https://placehold.co/150x180?text=Capa";
                }}
        ?>
            <div class="cardtcc">
            <img src="<?php echo $capa?>" alt="Capa do tcc">
            <div class="cardtcc-info">
                <h3><?php echo $queryRow['nomeTcc']?></h3>
                <p><?php echo $nomeCurso?></p>
                <p>Ano: <?php echo $queryRow['anoTcc']?></p>
                <p>Descrição: Descrição do TCC do Usuário.</p>
                </div>
            </div>
        <?php }
    }
    ?>