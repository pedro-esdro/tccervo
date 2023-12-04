const form = document.querySelector("form");
const submitbtn = document.querySelector("#buscar");

$('.custom-checkbox input[type="checkbox"]').click(function () {
  const maxCheckbox = 1;
  const checkedCheckbox = $('.custom-checkbox input[type="checkbox"]:checked');

  if (checkedCheckbox.length > maxCheckbox) {
    $('.custom-checkbox input[type="checkbox"]')
      .not(this)
      .prop("checked", false);
  }
});


// Importe a biblioteca spin.js no seu código
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
    className: 'spinner' // Classe CSS para o spinner
  }).spin();

  form.onsubmit = (e) => {
    e.preventDefault();

    $('#customSpinner').html(spinner.el).show();

    $.post(
      "php/filtro.php",
      $(form).serialize(),
      function (resp) {
        setTimeout(() => {
          $('#customSpinner').hide();

          $("#pesquisa").html(resp);
        }, 1000);
      }
    ).fail(function () {
      setTimeout(() => {
        $('#customSpinner').hide();

        Swal.fire({
          icon: 'error',
          showConfirmButton: false,
          timer: 1000
        });
      }, 1000);
    });
  };
});

