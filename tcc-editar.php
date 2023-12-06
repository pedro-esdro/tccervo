<?php
include_once 'php/db.php';
session_start();
$idUsuario = $_SESSION['idUsuario'] ?? "";
if (!isset($_SESSION['idEditarTcc']) || $_SESSION['idEditarTcc'] != $_SESSION['idUsuario']) {
    unset($_SESSION['idEditarTcc']);
    header("Location: index.php");
} else {
    if (!empty($idUsuario)) {
        $sqlCurso = "SELECT UCurso.idCurso, C.nomeCurso
                FROM tbUsuario_tbCurso AS UCurso
                JOIN tbCurso AS C ON UCurso.idCurso = C.idCurso
                WHERE UCurso.idUsuario = $idUsuario";

        $resultCursos = mysqli_query($conexao, $sqlCurso);

        $sqlOds = "SELECT * from tbOds";
        $resultOds = mysqli_query($conexao, $sqlOds);

        // Verifica se o ID do TCC a ser editado foi fornecido na URL
        $idTccParaEditar = $_GET['id_tcc'] ?? null;


        if (!empty($idTccParaEditar)) {
            // Busca os dados do TCC no banco de dados
            $sqlTcc = "SELECT * FROM tbTcc WHERE idTcc = $idTccParaEditar";
            $resultTcc = mysqli_query($conexao, $sqlTcc);

            // Verifica se o TCC foi encontrado
            if ($resultTcc && mysqli_num_rows($resultTcc) > 0) {
                $dadosTcc = mysqli_fetch_assoc($resultTcc);
                $capa = "https://placehold.co/150x180?text=Capa";

                $arquivoPartes = explode('_', $dadosTcc['arquivoTcc']);
                $arquivo = $arquivoPartes[1];
                if (!empty($dadosTcc['capaTcc'])) {
                    $caminhocapa = "database/tcc/capas/" . $dadosTcc['capaTcc'];

                    if (file_exists($caminhocapa)) {
                        $capa = $caminhocapa;
                    }
                }
                $sqlAutoresDoTcc = "SELECT U.idUsuario, U.nomeUsuario
                   FROM tbUsuario_tbTcc AS UTcc
                   JOIN tbUsuario AS U ON UTcc.idUsuario = U.idUsuario
                   WHERE UTcc.idTcc = $idTccParaEditar AND U.idUsuario != $idUsuario";


                $resultAutoresDoTcc = mysqli_query($conexao, $sqlAutoresDoTcc);

                // Lista de autores associados atualmente ao TCC
                $autoresAtuais = [];
                while ($rowAutoresDoTcc = mysqli_fetch_assoc($resultAutoresDoTcc)) {
                    $autoresAtuais[] = $rowAutoresDoTcc;
                }
            } else {
                header("Location: index.php");
                exit;
            }
        }
    } else {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar TCC</title>
    <link rel="stylesheet" type="text/css" href="css/tcc.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/busca.css">
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <div id="customSpinner">
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="error-text">
        </div>
        <h1>Editar TCC</h1>
        <br>
        <div class="tcc-container">
            <div class="left-column">
                <div id="foto-perfil">
                    <img id="imagem-preview" src="<?= $capa ?>" alt="Capa do TCC">
                    <label class="arquivoinput" for="capaTcc">Escolher uma capa</label>
                    <input type="file" name="capaTcc" id="capaTcc" style="display:none">
                </div>
                <div class="addAutores">
                    <h3>Adicionar autores - opcional</h3>
                    <p>Adicione até 5 outros autores pelo id de usuário</p>

                    <?php
                    // Iterar sobre os 5 inputs de autor
                    for ($i = 0; $i < 5; $i++) {
                        $placeholder = ($i < count($autoresAtuais)) ? $autoresAtuais[$i]['idUsuario'] : 'Id de usuário do Autor';
                        $value = ($i < count($autoresAtuais)) ? $autoresAtuais[$i]['idUsuario'] : '';
                    ?>

                        <input class="inputautor" type="text" name="autores[]" pattern="[0-9]+" title="Somente números são permitidos" placeholder="<?= $placeholder ?>" value="<?= $value ?>">
                    <?php } ?>
                </div>
                <div class="buttons sbt1">
                    <input class="submit" type="submit" value="Salvar Alterações"><br>
                    <button type="button" class="btnDeletar">Deletar TCC</button><br><br>
                    <a href="tcc-detalhes.php?idBuscTcc=<?= $idTccParaEditar ?>">Cancelar</a>
                </div>
            </div>


            <div class="right-column">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nomeTcc">Nome do TCC*:</label>
                        <input type="text" name="nomeTcc" id="nomeTcc" placeholder="Nome do trabalho" required value="<?php echo isset($dadosTcc['nomeTcc']) ? $dadosTcc['nomeTcc'] : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="anoTcc">Ano do TCC*:</label>
                        <select name="anoTcc" id="anoTcc" required>
                            <option value="">Selecione um ano</option>
                            <?php
                            $anoAtual = date("Y");
                            for ($ano = 2011; $ano <= $anoAtual; $ano++) {
                                $selected = ($ano == substr($dadosTcc['anoTcc'], 0, 4)) ? 'selected' : '';
                                echo "<option value='$ano' $selected>$ano</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group" id="linkArquivo">
                        <label for="linkArquivo">Link exterior:</label>
                        <input type="text" name="linkArquivo" id="linkArquivoInput" placeholder="https://www.exemplo.com" pattern="^https:\/\/[\w\d.-]+\.[a-z]{2,4}(\/\S*)?$" value="<?php echo isset($dadosTcc['linkTcc']) ? $dadosTcc['linkTcc'] : ''; ?>">
                        <small>Um link opcional, como Github, Youtube, etc.<br>
                            Formato: <strong>https://www.exemplo.com</strong></small>
                    </div>
                    <div class="form-group">
                        <label for="curso">Curso*:</label>
                        <select name="curso" required>
                            <option value="">Selecione um curso</option>
                            <?php
                            while ($rowCurso = mysqli_fetch_assoc($resultCursos)) {
                                $selected = ($rowCurso['idCurso'] == $dadosTcc['idCurso']) ? 'selected' : '';
                                echo "<option value='{$rowCurso['nomeCurso']}' $selected>{$rowCurso['nomeCurso']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group formresumo">
                        <label for="descricaoTcc">Resumo do TCC*:</label>
                        <textarea name="descricaoTcc" id="descricaoTcc" required rows="4" cols="50" autocomplete="off" maxlength="2000" placeholder="Fale sobre o trabalho"><?php echo isset($dadosTcc['descricaoTcc']) ? $dadosTcc['descricaoTcc'] : ''; ?></textarea>
                    </div>





                </div>
                <div class="form-row">
                    <div class="form-group" id="uploadArquivo">
                        <label class="arquivoinput" for="arquivoTcc">Arquivo PDF*</label>
                        <small>Monografia, documentação, etc.</small>
                        <input type="file" name="arquivoTcc" id="arquivoTcc" style="display:none;">
                        <div class="pdf">
                            <img src="assets/icons/pdf.png">
                            <p id="arquivoPreviewNome"> <?= $arquivo ?></p>
                        </div>
                    </div>
                </div>
                <h3 id="odshead" class="odst">ODS - Escolha até 3 - <a href="https://brasil.un.org/pt-br/sdgs" target="_blank"><img src="assets/icons/questionIcon.png" width="20px" height="20px"><span>O que são ODS?</span></a></h3>
                <div class="form-row ods-row">
                    <?php
                    $tccId = $idTccParaEditar;
                    $sqlOdsDoTcc = "SELECT O.idOds
                   FROM tbOds_tbTcc AS TOds
                   JOIN tbOds AS O ON TOds.idOds = O.idOds
                   WHERE TOds.idTcc = $tccId";

                    $resultOdsDoTcc = mysqli_query($conexao, $sqlOdsDoTcc);

                    // Obtendo as ODS associadas ao TCC
                    $odsSelecionadasDoTcc = [];
                    while ($rowOdsDoTcc = mysqli_fetch_assoc($resultOdsDoTcc)) {
                        $odsSelecionadasDoTcc[] = $rowOdsDoTcc['idOds'];
                    }

                    // Iterando sobre todas as ODS disponíveis
                    while ($rowOds = mysqli_fetch_assoc($resultOds)) :
                        $checked = (in_array($rowOds['idOds'], $odsSelecionadasDoTcc)) ? 'checked' : '';
                    ?>
                        <label class="custom-checkbox">
                            <input type="checkbox" name="ods[]" value="<?php echo $rowOds['idOds'] ?>" <?php echo $checked; ?>>
                            <img src="assets/carrossel/ods/ODS_<?php echo $rowOds['idOds'] ?>.png" alt="ods">
                        </label>
                    <?php endwhile; ?>
                </div>
                <div class="form-row">
                    <div class="buttons sbt2">
                        <input class="submit" type="submit" value="Salvar Alterações"><br>
                        <button class="btnDeletar">Deletar TCC</button><br><br>
                        <a href="tcc-detalhes.php?idBuscTcc=<?= $idTccParaEditar ?>">Cancelar</a>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <div id="overlay"></div>

    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script src="js/editartcc.js"></script>
<script>
    $(document).ready(function() {

        $('.btnDeletar').on('click', function() {
            // Exibir mensagem de confirmação usando SweetAlert
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você não poderá desfazer essa ação!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#4D3F8F',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                // Se confirmado, enviar solicitação AJAX para deletar
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'php/deletar_tcc.php', // Substitua pelo nome correto da sua página de deleção
                        type: 'POST',
                        dataType: 'json', // Espera um retorno em JSON
                        data: {
                            idTcc: <?php echo $_SESSION['idEditarTcc_idTcc']; ?>
                        },
                        success: function(response) {
                            if (response.success) {
                                // Se a exclusão foi bem-sucedida, exibir mensagem de sucesso
                                Swal.fire({
                                    title: 'TCC deletado com sucesso!',
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirecionar para a página inicial
                                    window.location.href = 'perfil.php';
                                });
                            } else {
                                // Se ocorreu um erro na exclusão, exibir mensagem de erro
                                Swal.fire({
                                    title: 'Erro ao deletar TCC!',
                                    text: 'Ocorreu um erro durante a exclusão do TCC. Por favor, tente novamente.',
                                    icon: 'error',
                                    showCancelButton: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            // Se ocorreu um erro na requisição AJAX, exibir mensagem de erro
                            Swal.fire({
                                title: 'Erro ao deletar TCC!',
                                text: 'Ocorreu um erro durante a exclusão do TCC. Por favor, tente novamente.',
                                icon: 'error',
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

    });
</script>

</html>