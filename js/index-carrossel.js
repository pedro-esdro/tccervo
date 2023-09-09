let count1 = 1;
document.getElementById("radio1").checked = true;

setInterval(function () {
  nextImage();
}, 5000);

function nextImage() {
  count1++;
  if (count1 > 2) {
    count1 = 1;
  }
  document.getElementById("radio" + count1).checked = true;
}
