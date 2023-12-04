const cod = document.querySelectorAll('.cod-field');

cod[0].focus();

cod.forEach((field, index) =>{
    field.addEventListener('keydown', (e) =>{
        if(e.key >= 0 && e.key <= 9){
            cod[index].value = "";
            setTimeout(() =>{
                cod[index+1].focus();
            }, 4);
        }
        else if(e.key === 'Backspace'){
            setTimeout(() =>{
                cod[index-1].focus();
            }, 4);
        }
    })
})



const form = document.querySelector(".form form");
const submitbtn = form.querySelector(".submit .button");
const errortxt = form.querySelector(".error-text");


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
      url: "./php/verificar.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        setTimeout(() => {
          $('#customSpinner').hide();

          if (data == "success") {
            window.location.assign("./index.php");
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