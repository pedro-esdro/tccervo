<?php
session_start();
include_once 'php/db.php'; // Inclua seu arquivo de conexão com o banco de dados
include_once 'php/mail.php'; // Inclua seu arquivo de envio de e-mail (caso necessário)

// Verifique se o usuário está logado (você já deve ter feito isso em algum lugar do código)

if (isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario']; // ID do usuário na sessão

    // Consulta para buscar o idCurso do usuário com base no idUsuario da sessão
    $sqlSelectCurso = mysqli_query($conexao, "SELECT idCurso FROM tbUsuario WHERE idUsuario = '$idUsuario'");

    if ($sqlSelectCurso && mysqli_num_rows($sqlSelectCurso) > 0) {
        $row = mysqli_fetch_assoc($sqlSelectCurso);
        $idCurso = $row['idCurso']; // ID do curso do usuário

        // Dados do formulário
        $nome = $_POST['nome'];
        $dataTCC = $_POST['dataTCC'];
        $nomeOds = $_POST['ods'];
        $ods = array(
            "Erradicação da Pobreza" => 1,
            "Fome Zero e Agricultura Sustentável" => 2,
            "Saúde e Bem-Estar" => 3,
            "Educação de Qualidade" => 4,
            "Igualdade de Gênero" => 5,
            "Água Potável e Saneamento" => 6,
            "Energia Acessível e Limpa" => 7,
            "Trabalho Decente e Crescimento Econômico" => 8,
            "Indústria, Inovação e Infraestrutura" => 9,
            "Redução das Desigualdades" => 10,
            "Cidades e Comunidades Sustentáveis" => 11,
            "Consumo e Produção Responsáveis" => 12,
            "Ação Contra a Mudança Global do Clima" => 13,
            "Vida na Água" => 14,
            "Vida Terrestre" => 15,
            "Paz, Justiça e Instituições Eficazes" => 16,
            "Parcerias e Meios de Implementação" => 17
        );
        $idOds = $ods[$nomeOds];

        // Caminho para salvar a capa e o arquivo
        $caminhoCapa = "database/tcc/capas"; // Substitua pelo caminho real
        $caminhoArquivo = "database/tcc/arquivos"; // Substitua pelo caminho real

        // Carrega a capa e o arquivo
        $capaTcc = $_FILES['foto'];
        $arquivoTcc = $_FILES['arquivo'];

        // Gere nomes únicos para os arquivos
        $nomeUnicoCapa = uniqid() . "_" . $capaTcc['name'];
        $nomeUnicoArquivo = uniqid() . "_" . $arquivoTcc['name'];

        // Caminhos finais para salvar os arquivos
        $caminhoFinalCapa = $caminhoCapa . $nomeUnicoCapa;
        $caminhoFinalArquivo = $caminhoArquivo . $nomeUnicoArquivo;

        // Movendo a capa e o arquivo para os caminhos finais
        move_uploaded_file($capaTcc['tmp_name'], $caminhoFinalCapa);
        move_uploaded_file($arquivoTcc['tmp_name'], $caminhoFinalArquivo);

        // Insira o código aqui para inserir os dados na tabela tbTcc
        // Certifique-se de adicionar o código para tratar o envio do TCC no local apropriado

        // Exemplo de inserção na tabela tbTcc
        $sqlInsertTcc = mysqli_query($conexao, "INSERT INTO tbTcc (nomeTcc, descricaoTcc, capaTcc, anoTcc, arquivoTcc, idUsuario, idCurso, idOds) 
        VALUES ('$nome', 'Descrição do TCC', '$nomeUnicoCapa', '$dataTCC', '$nomeUnicoArquivo', '$idUsuario', '$idCurso', '$idOds')");

        if ($sqlInsertTcc) {
            // TCC inserido com sucesso no banco de dados
            // Redirecionar o usuário para uma página de sucesso
            header('Location: index.php');
            exit();
        } else {
            echo "Erro ao inserir o TCC no banco de dados.";
        }
    } else {
        // O usuário não foi encontrado ou não possui um idCurso válido
        echo "Erro ao buscar o idCurso do usuário.";
    }
} else {
    // O usuário não está logado
    echo "Usuário não está logado.";
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu TCC</title>
    <script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets\favicon\favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/navfooter.css">
    <link rel="stylesheet" href="css/perfil.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <?php include 'html-components/navbar.php'; ?>
    <main>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="perfil-edit">
                <div class="edit-filho">
                    <div class="error-text">
                    </div>
                </div>
                <div class="edit-filho">
                    <div id="foto-perfil">
                        <img id="imagem-preview" src="http://via.placeholder.com/150x180" alt="foto de perfil"><br>
                        <label class="fotoinput" for="foto">Escolha uma capa</label>
                        <input type="file" name="foto" id="foto" style="display:none">
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <label for="nome">Nome do TCC*: </label>
                            <input placeholder="Nome do TCC" type="text" name="nome" id="nome" value="" pattern="[a-zA-z'-'\s]*" required autocomplete="off">
                        </div>
                        <div class="input">
                            <label for="sobre">Descrição:</label>
                            <textarea id="sobre" name="sobre" rows="4" cols="50" autocomplete="off" maxlength="255" placeholder="Descreva o TCC"></textarea>
                        </div>
                        <div class="input">
                            <label for="dataTCC">Data do TCC*:</label>
                            <input type="date" id="dataTCC" name="dataTCC" required>
                        </div>
                        <div class="input">
                            <label for="ods">ODS</label>
                            <select name="ods" required>
                                <option value="">Selecione uma ODS</option>
                                <option value="1">ODS 1 - Erradicação da Pobreza</option>
                                <option value="2">ODS 2 - Fome Zero e Agricultura Sustentável</option>
                                <option value="3">ODS 3 - Saúde e Bem-Estar</option>
                                <option value="4">ODS 4 - Educação de Qualidade</option>
                                <option value="5">ODS 5 - Igualdade de Gênero</option>
                                <option value="6">ODS 6 - Água Potável e Saneamento</option>
                                <option value="7">ODS 7 - Energia Acessível e Limpa</option>
                                <option value="8">ODS 8 - Trabalho Decente e Crescimento Econômico</option>
                                <option value="9">ODS 9 - Indústria, Inovação e Infraestrutura</option>
                                <option value="10">ODS 10 - Redução das Desigualdades</option>
                                <option value="11">ODS 11 - Cidades e Comunidades Sustentáveis</option>
                                <option value="12">ODS 12 - Consumo e Produção Responsáveis</option>
                                <option value="13">ODS 13 - Ação Contra a Mudança Global do Clima</option>
                                <option value="14">ODS 14 - Vida na Água</option>
                                <option value="15">ODS 15 - Vida Terrestre</option>
                                <option value="16">ODS 16 - Paz, Justiça e Instituições Eficazes</option>
                                <option value="17">ODS 17 - Parcerias e Meios de Implementação</option>
                            </select>

                        </div>
                        <div class="input">
                            <label class="fotoinput" for="arquivo">Inserir arquivo</label>
                            <input type="file" name="arquivo" id="arquivo" style="display:none" required>
                        </div>
                        <div class="input">
                            <input type="submit" value="Postar TCC">
                        </div>
                    </div>

                </div>

            </div>
            <hr>
        </form>
    </main>
    <?php include 'html-components/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Adicione um ouvinte de evento para o campo de data usando jQuery
    $(document).ready(function() {
        $("#dataTCC").on("change", function() {
            // Verifique se o campo de data não está vazio
            if ($(this).val()) {
                // Adicione uma classe ao campo para aplicar um estilo de borda
                $(this).addClass("data-filled");
            } else {
                // Remova a classe se o campo estiver vazio
                $(this).removeClass("data-filled");
            }
        });
    });
</script>

</html>