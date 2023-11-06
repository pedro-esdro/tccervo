<?php
    include_once './db.php';
    session_start();

    $nomeTcc = $_POST['nomeTcc'];
    $ano = $_POST['anoTcc'];
    $curso = $_POST['curso'];


    $idCursos = array(
        "Informática para Internet" => 1,
        "Administração" => 2,
        "Contabilidade" => 3,
        "Recursos Humanos" => 4,
        "Enfermagem" => 5
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {







        // // Verifique se o campo "ods" está definido e é um array não vazio
        // if (isset($_POST["ods"]) && is_array($_POST["ods"]) && !empty($_POST["ods"])) {
        //     $odsSelecionadas = $_POST["ods"];
            
        //     // Verifique o número de ODS selecionadas
        //     $minOds = 1;
        //     $maxOds = 3;
            
        //     if (count($odsSelecionadas) >= $minOds && count($odsSelecionadas) <= $maxOds) {
        //         // O número de ODS selecionadas está dentro do intervalo permitido
        //         // Faça o que for necessário com as ODS selecionadas
        //         foreach ($odsSelecionadas as $ods) {
        //             // Processar cada ODS selecionada
        //         }
        //     } else {
        //         echo "Escolha no máximo 3 ODS.";
        //     }
        // } else {
        //     echo "Escolha no mínimo 1 ODS.";
        // }
    }
?>