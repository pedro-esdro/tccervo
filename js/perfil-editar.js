const form = document.querySelector("form");
const submitbtn = form.querySelector(".inputsenha .submit");
const errortxt = form.querySelector(".error-text");

$(document).ready(function () {
  $("#inputsenha").hide(); // Inicialmente, oculte os campos de senha

  $("#foto").on("change", function () {
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
  // Use a delegação de eventos para os botões de adicionar cursos
  $(document).on("click", ".adicionar-curso", function () {
    var cursoId = $(this).data("curso-id");
    errortxt.textContent = "";
    errortxt.style.display = "none";
    $.post("./php/adicionar_curso.php", { cursoId: cursoId }, function (resp) {
      $("#cursos-atuais").load("perfil-editar.php #cursos-atuais");
      $("#cursos-disponiveis").load("perfil-editar.php #cursos-disponiveis");
    }).fail(function () {
      alert("Erro ao adicionar");
    });
  });

  $(document).on("click", ".remover-curso", function () {
    var cursoId = $(this).data("curso-id");

    // Verifique se há pelo menos um curso restante associado ao usuário
    if ($(".remover-curso").length === 1) {
      errortxt.textContent =
        "Erro: Você deve ter pelo menos 1 curso associado.";
      errortxt.style.display = "block";
      return;
    } else {
      $.post("./php/remover_curso.php", { cursoId: cursoId }, function (resp) {
        $("#cursos-disponiveis").load("perfil-editar.php #cursos-disponiveis");
        $("#cursos-atuais").load("perfil-editar.php #cursos-atuais");
      }).fail(function () {
        alert("Erro ao remover");
      });
    }
  });

  $("#botaosenha").click(function () {
    var senhaAtualInput = $("#senhaatual");
    var senhaNovaInput = $("#senhanova");
    var confirmarSenhaInput = $("#csenhanova");

    if (senhaAtualInput.attr("required")) {
      // Se os campos têm 'required', remova-os e limpe os campos
      senhaAtualInput.removeAttr("required");
      senhaNovaInput.removeAttr("required");
      confirmarSenhaInput.removeAttr("required");
      senhaAtualInput.val("");
      senhaNovaInput.val("");
      confirmarSenhaInput.val("");
    } else {
      // Caso contrário, adicione 'required'
      senhaAtualInput.attr("required", "required");
      senhaNovaInput.attr("required", "required");
      confirmarSenhaInput.attr("required", "required");
    }

    // Alternar a exibição dos campos de senha
    $("#inputsenha").toggle();
    $(this).toggleClass("ativo");
  });

  $("#linkedin").on("blur", function () {
    var linkInput = $(this).val();
    var linkRegex = /^https:\/\/www\.linkedin\.com\/in\/.+$/;
  
    if (linkInput == "") {
      errortxt.textContent = "";
      errortxt.style.display = "none";
    } else if (!linkRegex.test(linkInput)) {
      errortxt.textContent =
        "Erro: Insira um link válido começando por https://www.linkedin.com/in/";
      errortxt.style.display = "block";
      $(this).removeClass("valid");
    } else {
      errortxt.textContent = "";
      errortxt.style.display = "none";
      $(this).addClass("valid");
    }
  });
  
  $.getScript(
    "https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js",
    function () {
      var spinner = new Spinner({
        lines: 360, // Número de linhas no spinner
        length: 10, // Comprimento de cada linha
        width: 3, // Espessura de cada linha
        radius: 42, // Raio do spinner
        scale: 0.5, // Fator de escala
        color: "#4D3F8F", // Cor roxa
        speed: 1, // Velocidade de rotação
        trail: 60, // Afterglow em percentagem
        className: "spinner",
      }).spin();

      // Usar o evento submit no formulário em vez de onclick no botão
      form.onsubmit = (e) => {
        e.preventDefault();
        let senhaAtualInput = document.getElementById("senhaatual");
        let senhaNovaInput = document.getElementById("senhanova");
        let confirmarSenhaInput = document.getElementById("csenhanova");

        // Verifique se os campos de senha são obrigatórios e estão vazios
        if (
          senhaAtualInput.getAttribute("required") &&
          senhaAtualInput.value === "" &&
          senhaNovaInput.value === "" &&
          confirmarSenhaInput.value === ""
        ) {
          errortxt.textContent =
            'Erro: Insira todos os campos de senha obrigatórios (campos marcados com um "*").';
          errortxt.style.display = "block";
          return; // Impede o envio do formulário
        }

        let formData = new FormData(form);

        $.ajax({
          url: "./php/perfil-editar.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data) {
            $("#customSpinner").html(spinner.el).show();
            setTimeout(() => {
              $("#customSpinner").hide();

              if (data == "success") {
                window.location.assign("./perfil.php");
              } else {
                errortxt.textContent = data;
                errortxt.style.display = "block";
              }
            }, 1000);
          },
          error: function () {
            setTimeout(() => {
              $("#customSpinner").hide();
            }, 1000);
          },
        });
      };
    }
  );
});
