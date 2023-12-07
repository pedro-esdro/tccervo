<div id="postar" class="button">
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
        justify-content: space-between;
    }
    #postar {
        margin: 10px;
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
        flex-direction: column;
        justify-content: space-between;
    }

    .cardtcc a {
        display: block;
        padding: 4px;
        text-decoration: none;
        background-color: #4D3F8F;
        color: #fff;
        border: 1px solid #4D3F8F;
        border-radius: 6px;
    }

    .cardtcc a:hover {
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

    .box {
        display: flex;
    }

    .resumo {
        max-height: 120px;
        max-width: 740px;
        word-wrap: break-word;
        overflow-y: auto;
        text-align: justify;
        padding-right: 5px;
    }

    .resumo::-webkit-scrollbar {
        width: 8px;
    }

    .resumo::-webkit-scrollbar-track {
        background: #d2cbf5;
    }

    .resumo::-webkit-scrollbar-thumb {
        background: #7d6dc2;
        border-radius: 6px;
    }

    .resumo::-webkit-scrollbar-thumb:hover {
        background: #4D3F8F;
    }

    @media screen and (max-width: 760px) {
        .cardtcc {
            flex-direction: column;
        }
        .cardtcc a{
            width: 30%;
            text-align: center;
        }
        .cardtcc img {
            width: 120px;
            height: 120px;
    }
        .box {
            flex-direction: column;
            width: 100%;
        }
        .imgbox {
            display: flex;
            width: 100%;
            justify-content: center;
        }
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

            if (file_exists("../" . $caminhocapa)) {
                $capa = $caminhocapa;
            }
        }
?>
        <div class="cardtcc">
            <div class="box">
                <div class="imgbox"><img src="<?= $capa ?>"></div>
                <div class="cardtcc-info">
                    <h3><?php echo $queryRow['nomeTcc'] ?></h3>
                    <p><?php echo $nomeCurso ?></p>
                    <p><?php echo date("Y", strtotime($queryRow['anoTcc'])); ?></p>
                    <p class="resumo">
                        <?php
                        if (!empty($queryRow['descricaoTcc'])) {
                            echo "{$queryRow['descricaoTcc']}";
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div>
                <a href="tcc-detalhes.php?idBuscTcc=<?php echo $queryRow['idTcc'] ?>">Detalhes</a>
            </div>
        </div>
<?php
    }
}else
{
    ?>
    <p style="text-align: center; display: flex; flex-direction: column; justify-content:center; align-items: center;"><img src="./assets/icons/tccnaopub.png" width="64px" height="64px">Nenhuma publicação ainda.</p>
    <?php
}
?>