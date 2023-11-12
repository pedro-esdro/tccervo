<div class="button">
    <a href="postar-tcc.php">Publicar TCC</a>
</div>
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
            object-fit: cover;
            margin-right: 10px;
        }

        .cardtcc-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
        }
        .cardtcc-info a {
            display: block;
            padding: 4px;
            text-decoration: none;
            background-color: #4D3F8F;
            color: #fff;
            border: 1px solid #4D3F8F;
            border-radius: 6px;
        }
        .cardtcc-info a:hover {
            background-color: #fff;
            color: #4D3F8F;
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

    $idPesq = $_GET['idPesq'];

    $sqlSelect = "SELECT TCC.* 
    FROM tbUsuario AS U
    JOIN tbUsuario_tbTcc AS UT ON U.idUsuario = UT.idUsuario
    JOIN tbTcc AS TCC ON UT.idTcc = TCC.idTcc
    WHERE U.idUsuario = $idPesq
    ORDER BY TCC.`data_postagem` DESC;
    ";

$sqlQuery = mysqli_query($conexao, $sqlSelect);

if ($sqlQuery && mysqli_num_rows($sqlQuery) > 0) {
    while ($queryRow = mysqli_fetch_assoc($sqlQuery)) {
        $sqlCurso = mysqli_query($conexao, "SELECT nomeCurso from tbCurso WHERE idCurso = {$queryRow['idCurso']}");
        $resultCurso = mysqli_fetch_assoc($sqlCurso);
        $nomeCurso = $resultCurso['nomeCurso'];

        
        $capa = "https://placehold.co/150x180?text=Capa";

        if (!empty($queryRow['capaTcc'])) {
            $caminhocapa = "database/tcc/capas/" . $queryRow['capaTcc'];
            
            if (file_exists("../".$caminhocapa)) {
                $capa = $caminhocapa;
            }
    
        }
        ?>
        <div class="cardtcc">
            <img src="<?= $capa?>">
            <div class="cardtcc-info">
                <div>
                    <h3><?php echo $queryRow['nomeTcc'] ?></h3>
                    <p><?php echo $nomeCurso ?></p>
                    <p><?php echo date("Y", strtotime($queryRow['anoTcc'])); ?></p>
                    <?php
                        if(!empty($queryRow['descricaoTcc'])){
                            echo "<p> {$queryRow['descricaoTcc']}</p>";
                        }
                    ?>
                </div>
                <div>
                    <a href="tcc-detalhes.php?idBuscTcc=<?php echo $queryRow['idTcc']?>">Detalhes</a>
                </div>
            </div>
        </div>
        <?php
    }
}
?>