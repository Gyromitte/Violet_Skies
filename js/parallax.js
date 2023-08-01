window.addEventListener('scroll', function() {
  var scrollPosition = window.pageYOffset;
  var parallaxSections = document.getElementsByClassName('job-image');
  var pageHeight = document.documentElement.scrollHeight;
  
  for (var i = 0; i < parallaxSections.length; i++) {
    var parallaxSection = parallaxSections[i];
    var speed = parallaxSection.getAttribute('data-speed');
    var yPos = -(scrollPosition * speed);
    
    if (yPos < -pageHeight) {
      yPos = 0; // Restablecer el valor a cero
    }
    
    //Mostrar el valor de yPos en la consola
    //console.log("Valor de yPos: ", yPos);

    parallaxSection.style.backgroundPosition = '50% ' + yPos + 'px';
  }
});

  