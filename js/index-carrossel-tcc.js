const slides3 = document.querySelector('.slides3');
const slideWidth3 = 190; // Largura de cada slide (ajuste conforme suas imagens)

let currentSlide3 = 0;

function showSlide3() {
  slides3.style.transform = `translateX(-${currentSlide3 * slideWidth3}px)`;
}

function nextSlide3() {
  currentSlide3 = (currentSlide3 + 1) % 10; // 17 é o número total de slides (ajuste conforme suas imagens)
  showSlide3();
}

function prevSlide3() {
  currentSlide3 = (currentSlide3 - 1 + 10) % 10; // 17 é o número total de slides (ajuste conforme suas imagens)
  showSlide3();
}

document.getElementById('prev-button2').addEventListener('click', prevSlide3);
document.getElementById('next-button2').addEventListener('click', nextSlide3);

// Iniciar a transição automática a cada 10 segundos
setInterval(nextSlide3, 10000);
