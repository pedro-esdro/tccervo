const form = document.querySelector("form");
const submitbtn = form.querySelector(".buttons .submit");
const errortxt = form.querySelector(".error-text");

$(document).ready(function () {
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
        $("#imagem-preview").attr(
          "src",
          "https://placehold.co/150x180?text=Capa"
        );
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
        // Limpar o texto de visualização
        $("#arquivoPreviewNome").text("");
      }
    }
  });

  $("#linkArquivo input").on("blur", function () {
    var linkInput = $(this).val();
    var linkRegex = /^(https:\/\/|http:\/\/)([\w\d.-]+\.[a-z]{2,4})(\/\S*)?$/;

    if (linkInput == "") {
      errortxt.textContent = "";
      errortxt.style.display = "none";
    } else if (!linkRegex.test(linkInput)) {
      errortxt.textContent =
        "Erro: Insira um link válido começando por https:// ou http://";
      errortxt.style.display = "block";
      $(this).removeClass("valid");
    } else {
      errortxt.textContent = "";
      errortxt.style.display = "none";
      $(this).addClass("valid"); // Adiciona a classe "valid" quando o link é válido
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

$.getScript('https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js', function () {
  var spinner = new Spinner({
    lines: 360, // Número de linhas no spinner
    length: 10, // Comprimento de cada linha
    width: 3, // Espessura de cada linha
    radius: 42, // Raio do spinner
    scale: 0.5, // Fator de escala
    color: '#4D3F8F', // Cor roxa
    speed: 1, // Velocidade de rotação
    trail: 60, // Afterglow em percentagem
    className: 'spinner'
  }).spin();

  // Usar o evento submit no formulário em vez de onclick no botão
  form.onsubmit = (e) => {
    e.preventDefault();

    $('#customSpinner').html(spinner.el).show();

    let formData = new FormData(form);

    $.ajax({
      url: "./php/postar-tcc.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        setTimeout(() => {
          $('#customSpinner').hide();

          if (data == "success") {
            window.location.assign("./tcc-detalhes.php");
          } else {
            errortxt.textContent = data;
            errortxt.style.display = "block";
          }
        }, 1000);
      },
      error: function () {
        setTimeout(() => {
          $('#customSpinner').hide();
        }, 1000);
      }
    });
  };
});