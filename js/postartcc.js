$(document).ready(function() {
    $(".ods-dropdown-label").click(function() {
        $("#odsDropdown").toggle();
    });
    $("#uploadArquivo").hide();
    $("#linkArquivo input").prop("required", true);

    // Monitora a mudança no campo de seleção "tipoArquivo"
    $("#tipoArquivo").change(function() {
        var tipoSelecionado = $(this).val();
        if (tipoSelecionado === "link") {
            // Mostra o campo de inserção de link e oculta o campo de upload
            $("#linkArquivo").show();
            $("#uploadArquivo").hide();
            // Torna o campo de link obrigatório e remove o requisito do campo de upload
            $("#linkArquivo input").prop("required", true);
            $("#uploadArquivo input").prop("required", false);
            // Apaga o valor do campo de upload
            $("#uploadArquivo input").val("");
        } else {
            // Mostra o campo de upload e oculta o campo de inserção de link
            $("#linkArquivo").hide();
            $("#uploadArquivo").show();
            // Torna o campo de upload obrigatório e remove o requisito do campo de link
            $("#uploadArquivo input").prop("required", true);
            $("#linkArquivo input").prop("required", false);
            // Apaga o valor do campo de link
            $("#linkArquivo input").val("");
        }
    });
    $('#foto').on('change', function() {
        var fileInput = $(this)[0];

        if (fileInput.files && fileInput.files[0]) {
            var file = fileInput.files[0];

            if (file.type.match('image.*')) {
                var reader = new FileReader();

                // Quando o arquivo é lido, atualize o src da tag de imagem com a imagem carregada
                reader.onload = function(e) {
                    $('#imagem-preview').attr('src', e.target.result);
                };

                // Leia o arquivo como uma URL de dados
                reader.readAsDataURL(file);
                errortxt.textContent = "";
                errortxt.style.display = "none";
            } else {
                // Se não for uma imagem, você pode mostrar uma mensagem de erro ou realizar outra ação
                errortxt.textContent = "Erro: Insira um formato de imagem adequado!";
                errortxt.style.display = "block";
                // Limpar o campo de entrada de arquivo
                $(this).val('');
                // Limpar a prévia da imagem
                $('#imagem-preview').attr('src', 'http://via.placeholder.com/150x180');
            }
        }
    });
});