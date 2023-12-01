const slides2 = document.querySelector(".slides2");
const slideWidth2 = 150; // Largura de cada slide (ajuste conforme suas imagens)

let currentSlide2 = 0;

function showSlide2() {
  slides2.style.transform = `translateX(-${currentSlide2 * slideWidth2}px)`;
}

function nextSlide2() {
  currentSlide2 = (currentSlide2 + 1) % 17; // 17 é o número total de slides (ajuste conforme suas imagens)
  showSlide2();
}

function prevSlide2() {
  currentSlide2 = (currentSlide2 - 1 + 17) % 17; // 17 é o número total de slides (ajuste conforme suas imagens)
  showSlide2();
}

document.getElementById("prev-button").addEventListener("click", prevSlide2);
document.getElementById("next-button").addEventListener("click", nextSlide2);

// Iniciar a transição automática a cada 10 segundos
setInterval(nextSlide2, 5000);
