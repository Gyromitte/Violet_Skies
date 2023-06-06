const carouselContainer = document.querySelector('.carousel-container');
const carouselSlide = document.querySelector('.carousel-slide');
const prevBtn = document.querySelector('.carousel-prev');
const nextBtn = document.querySelector('.carousel-next');
const slideWidth = carouselContainer.clientWidth;

let slideIndex = 0;
let slideInterval;

// Función para desplazarse al siguiente slide
function goToNextSlide() {
  if (slideIndex === carouselSlide.children.length - 1) {
    slideIndex = 0;
  } else {
    slideIndex++;
  }
  carouselContainer.style.transform = `translateX(-${slideIndex * slideWidth}px)`;
}

// Función para desplazarse al slide anterior
function goToPrevSlide() {
  if (slideIndex === 0) {
    slideIndex = carouselSlide.children.length - 1;
  } else {
    slideIndex--;
  }
  carouselContainer.style.transform = `translateX(-${slideIndex * slideWidth}px)`;
}

// Agregar eventos a los botones de navegación
nextBtn.addEventListener('click', goToNextSlide);
prevBtn.addEventListener('click', goToPrevSlide);

// Función para iniciar el desplazamiento automático
function startSlideShow() {
  slideInterval = setInterval(goToNextSlide, 3000); // Cambiar slide cada 3 segundos
}

// Función para detener el desplazamiento automático
function stopSlideShow() {
  clearInterval(slideInterval);
}

// Iniciar el desplazamiento automático al cargar la página
startSlideShow();

// Detener el desplazamiento automático al pasar el mouse sobre el carrusel
carouselContainer.addEventListener('mouseover', stopSlideShow);

// Reanudar el desplazamiento automático al quitar el mouse del carrusel
carouselContainer.addEventListener('mouseout', startSlideShow);

  