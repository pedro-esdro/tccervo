<?php
include_once './db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $curso = $_POST['curso'] ?? "";
    $ano = $_POST['ano'] ?? "";;
    $ods = $_POST['ods'] ?? "";

    $idCursos = array(
        "Informática para Internet" => 1,
        "Administração" => 2,
        "Contabilidade" => 3,
        "Recursos Humanos" => 4,
        "Enfermagem" => 5,
        "Desenvolvimento de Sistemas" => 6,
        "Segurança do Trabalho" => 7
    );

    if (empty($curso) && empty($ano) && empty($ods)) {
        echo "<div class='alerta'>Escolha pelo menos um filtro.</div>";
    } else {
        $cursoCheck = false;
        $anoCheck = false;

        if (!empty($curso)) {
            $cursoCheck = true;
            $idCurso = $idCursos[$curso];
        }
        if (!empty($ano)) {
            $anoCheck = true;
            $ano = $ano . "-12-31";
        }
        if (!empty($ods)) {
            $nomeOds = mysqli_real_escape_string($conexao, $ods);
            $sql = "SELECT idOds FROM tbOds WHERE nomeOds = '$nomeOds'";
            $result = mysqli_query($conexao, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $idOds = $row['idOds'];

                $sqlSelectOds = "SELECT * FROM tbOds_tbTcc WHERE idOds = $idOds";
                $resultTccOds = mysqli_query($conexao, $sqlSelectOds);

                if (mysqli_num_rows($resultTccOds) > 0) {
                    $idTccs = array();
                    $allTccs = array();
                    while ($queryResultTccOds = mysqli_fetch_assoc($resultTccOds)) {
                        $idTccs[] = $queryResultTccOds['idTcc'];
                    }

                    $slqAllTcc = "SELECT * FROM tbTcc";
                    $resultAllTcc = mysqli_query($conexao, $slqAllTcc);
                    if ($resultAllTcc) {
                        while ($queryResultAllTcc = mysqli_fetch_assoc($resultAllTcc)) {
                            $allTccs[] = $queryResultAllTcc['idTcc'];
                        }
                        $tccComuns = array_intersect($idTccs, $allTccs);


                        if ($cursoCheck) {

                            $sqlTccCurso = "SELECT * FROM tbTcc where idCurso = $idCurso";
                            $resultTccCurso = mysqli_query($conexao, $sqlTccCurso);

                            if ($resultTccCurso && mysqli_num_rows($resultTccCurso) > 0) {
                                $tccsCurso = array();
                                while ($queryTccCurso = mysqli_fetch_assoc($resultTccCurso)) {
                                    $tccsCurso[] = $queryTccCurso['idTcc'];
                                }
                                $tccComunsCurso = array_intersect($tccComuns, $tccsCurso);

                                if ($anoCheck) {
                                    $sqlTccAno = "SELECT * FROM tbTcc where anoTcc = '$ano'";
                                    $resultTccAno = mysqli_query($conexao, $sqlTccAno);

                                    if ($resultTccAno && mysqli_num_rows($resultTccAno) > 0) {
                                        $tccsAno = array();
                                        while ($queryTccAno = mysqli_fetch_assoc(($resultTccAno))) {
                                            $tccsAno[] = $queryTccAno['idTcc'];
                                        }
                                        $tccComunsCursoAno = array_intersect($tccComunsCurso, $tccsAno);

                                        selectTcc($tccComunsCursoAno, $conexao);
                                    } else {
                                        echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
                                    }
                                } else {
                                    selectTcc($tccComunsCurso, $conexao);
                                }
                            } else {
                                echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
                            }
                        } else if ($anoCheck) {
                            $sqlTccAno = "SELECT * FROM tbTcc where anoTcc = '$ano'";
                            $resultTccAno = mysqli_query($conexao, $sqlTccAno);

                            if ($resultTccAno && mysqli_num_rows($resultTccAno) > 0) {
                                $tccsAno = array();
                                while ($queryTccAno = mysqli_fetch_assoc(($resultTccAno))) {
                                    $tccsAno[] = $queryTccAno['idTcc'];
                                }
                                $tccComunsAno = array_intersect($tccComuns, $tccsAno);

                                selectTcc($tccComunsAno, $conexao);
                            } else {
                                echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
                            }
                        } else {
                            selectTcc($tccComuns, $conexao);
                        }
                    }
                } else {
                    echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
                }
            }
        } else if ($cursoCheck) {
            $sqlTccCurso = "SELECT * FROM tbTcc where idCurso = $idCurso";
            $resultTccCurso = mysqli_query($conexao, $sqlTccCurso);

            if ($resultTccCurso && mysqli_num_rows($resultTccCurso) > 0) {
                $tccsCurso = array();
                while ($queryTccCurso = mysqli_fetch_assoc($resultTccCurso)) {
                    $tccsCurso[] = $queryTccCurso['idTcc'];
                }

                if ($anoCheck) {
                    $sqlTccAno = "SELECT * FROM tbTcc where anoTcc = '$ano'";
                    $resultTccAno = mysqli_query($conexao, $sqlTccAno);

                    if ($resultTccAno && mysqli_num_rows($resultTccAno) > 0) {

                        $tccsAno = array();
                        while ($queryTccAno = mysqli_fetch_assoc(($resultTccAno))) {
                            $tccsAno[] = $queryTccAno['idTcc'];
                        }

                        $tccComunsCursoAno = array_intersect($tccsCurso, $tccsAno);

                        selectTcc($tccComunsCursoAno, $conexao);
                    } else {
                        echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
                    }
                } else {
                    selectTcc($tccsCurso, $conexao);
                }
            } else {
                echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
            }
        } else {
            $sqlTccAno = "SELECT * FROM tbTcc where anoTcc = '$ano'";
            $resultTccAno = mysqli_query($conexao, $sqlTccAno);

            if ($resultTccAno && mysqli_num_rows($resultTccAno) > 0) {
                $tccsAno = array();
                while ($queryTccAno = mysqli_fetch_assoc(($resultTccAno))) {
                    $tccsAno[] = $queryTccAno['idTcc'];
                }
                selectTcc($tccsAno, $conexao);
            } else {
                echo "<div class='alerta'>Nada foi encontrado. Modifique os filtros.</div>";
            }
        }
    }
}

function selectTcc($tccarray, $conexao)
{
    foreach ($tccarray as $tccId) {
        $sqlselectTcc = "SELECT * FROM tbTcc where idTcc = $tccId";
        $resultSelectTcc = mysqli_query($conexao, $sqlselectTcc);

        if ($resultSelectTcc && mysqli_num_rows($resultSelectTcc) > 0) {
            while ($tccRow = mysqli_fetch_assoc($resultSelectTcc)) {
                $resultNomeCurso = mysqli_query($conexao, "SELECT nomeCurso from tbCurso where idCurso = {$tccRow['idCurso']}");
                $rowNomeCurso = mysqli_fetch_assoc($resultNomeCurso);
                $nomeCurso = $rowNomeCurso['nomeCurso'];

                $capa = "https://placehold.co/150x180?text=Capa";

                if (!empty($tccRow['capaTcc'])) {
                    $caminhocapa = "database/tcc/capas/" . $tccRow['capaTcc'];

                    if (file_exists("../" . $caminhocapa)) {
                        $capa = $caminhocapa;
                    }
                }
?>
                <div class="cardtcc">
                    <div class="box">
                        <div class="imgbox"><img src="<?= $capa ?>"></div>
                        <div class="cardtcc-info">
                            <h3><?php echo $tccRow['nomeTcc'] ?></h3>
                            <p><?php echo $nomeCurso ?></p>
                            <p><?php echo date("Y", strtotime($tccRow['anoTcc'])); ?></p>
                            <p class="resumo">
                                <?php
                                if (!empty($tccRow['descricaoTcc'])) {
                                    echo "{$tccRow['descricaoTcc']}";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="tcc-detalhes.php?idBuscTcc=<?php echo $tccRow['idTcc'] ?>">Detalhes</a>
                    </div>
                </div>
<?php }
        }
    }
}
?>