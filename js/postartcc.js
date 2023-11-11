const form = document.querySelector("form");
const submitbtn = form.querySelector(".buttons .submit");
const errortxt = form.querySelector(".error-text");

$(document).ready(function () {
  $(".ods-dropdown-label").click(function () {
    $("#odsDropdown").toggle();
  });
  $("#uploadArquivo").hide();
  $("#linkArquivo input").prop("required", true);

  // Monitora a mudança no campo de seleção "tipoArquivo"
  $("#tipoArquivo").change(function () {
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
  $("#capaTcc").on("change", function () {
    var fileInput = $(this)[0];

    if (fileInput.files && fileInput.files[0]) {
      var file = fileInput.files[0];

      if (file.type.match("image.*")) {
        var reader = new FileReader();

        // Quando o arquivo é lido, atualize o src da tag de imagem com a imagem carregada
        reader.onload = function (e) {
          $("#imagem-preview").attr("src", e.target.result);
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
        $(this).val("");
        // Limpar a prévia da imagem
        $("#imagem-preview").attr("src", "http://via.placeholder.com/150x180");
      }
    }
  });
  $("#linkArquivo input").on("blur", function () {
    var linkInput = $(this).val();
    var linkRegex = /^(https?:\/\/)?([\w\d.-]+\.[a-z]{2,4})(\/\S*)?$/;

    if (!linkRegex.test(linkInput)) {
      errortxt.textContent =
        "Erro: Insira um link válido (ex: https://www.exemplo.com)";
      errortxt.style.display = "block";
    } else {
      errortxt.textContent = "";
      errortxt.style.display = "none";
    }
  });
  $("#arquivoTcc").on("change", function () {
    var arquivoInput = $(this)[0];
    var arquivoName = arquivoInput.files[0].name;
    var extensoesPermitidas = /\.(pdf|zip|rar)$/i;
    var nomePreview = $("#arquivoPreviewNome");

    if (!extensoesPermitidas.test(arquivoName)) {
      // A extensão do arquivo não é permitida, exiba uma mensagem de erro
      errortxt.textContent =
        "Erro: Insira um arquivo válido (Somente PDF, ZIP e RAR são permitidos.)";
      errortxt.style.display = "block";
      $(this).val(""); // Limpa o campo de entrada de arquivo
      nomePreview.text("");
    } else {
      errortxt.textContent = "";
      errortxt.style.display = "none";
      nomePreview.text(arquivoName);
    }
  });
  $('.custom-checkbox input[type="checkbox"]').click(function () {
    const maxCheckboxes = 3;
    const checkedCheckboxes = $(
      '.custom-checkbox input[type="checkbox"]:checked'
    );
    $("#odshead").removeClass("aviso");

    if (checkedCheckboxes.length > maxCheckboxes) {
      $(this).prop("checked", false); // Impede a seleção se o limite for atingido
      $("#odshead").addClass("aviso");
      setTimeout(function () {
        $("#odshead").removeClass("aviso");
      }, 2000);
    }
  });
});


form.onsubmit = (e) => {
  e.preventDefault();
};

submitbtn.onclick = () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./php/postar-tcc.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        if (data == "success") {
          window.location.assign("./perfil.php");
        } else {
          errortxt.textContent = data;
          errortxt.style.display = "block";
        }
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};
