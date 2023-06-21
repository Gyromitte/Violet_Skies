let slideIn = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("slide");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIn++;
  if (slideIn > slides.length) {slideIn = 1}
  slides[slideIn-1].style.display = "flex";
  setTimeout(showSlides, 4000); // Change image every 2 seconds
}