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

form.onsubmit = (e) => {
    e.preventDefault();
};

submitbtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/verificar.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                if (data == "success") {
                    window.location.assign("./index.php");
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
