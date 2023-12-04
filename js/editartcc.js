const form = document.querySelector("form");
const submitbtn = form.querySelector(".buttons .submit");
const errortxt = form.querySelector(".error-text");

$(document).ready(function () {
  function testeLink(link) {
    var linkInput = $(link).val();
    var linkRegex = /^(https:\/\/|http:\/\/)([\w\d.-]+\.[a-z]{2,4})(\/\S*)?$/;

    if (linkInput == "") {
      errortxt.textContent = "";
      errortxt.style.display = "none";
      $(link).removeClass("valid");
    } else if (!linkRegex.test(linkInput)) {
      errortxt.textContent =
        "Erro: Insira um link válido começando por https:// ou http://";
      errortxt.style.display = "block";
      $(link).removeClass("valid");
    } else {
      errortxt.textContent = "";
      errortxt.style.display = "none";
      $(link).addClass("valid"); // Adiciona a classe "valid" quando o link é válido
    }
  }
  testeLink("#linkArquivo input");

  $(".ods-dropdown-label").click(function () {
    $("#odsDropdown").toggle();
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
      }
    }
  });
  $("#arquivoTcc").on("change", function () {
    var fileInput = $(this)[0];

    if (fileInput.files && fileInput.files[0]) {
      var file = fileInput.files[0];

      if (file.type === "application/pdf") {
        // O arquivo é um PDF, você pode fazer o que quiser aqui
        $("#arquivoPreviewNome").text(file.name);
        errortxt.textContent = "";
        errortxt.style.display = "none";
      } else {
        // O arquivo não é um PDF, mostre uma mensagem de erro
        errortxt.textContent = "Erro: Insira um arquivo PDF!";
        errortxt.style.display = "block";
        // Limpar o campo de entrada de arquivo
        $(this).val("");
      }
    }
  });
  $("#linkArquivo input").on("change", function () {
    testeLink("#linkArquivo input");
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
    errortxt.textContent = "";
    errortxt.style.display = "none";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/editar-tcc.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status == 200) {
          let data = xhr.response;
          if (data == "success") {
            window.location.assign("./tcc-detalhes.php");
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
