window.addEventListener('scroll', function() {
    var scrollPosition = window.pageYOffset;
    var parallaxSections = document.getElementsByClassName('job-image');
    
    for (var i = 0; i < parallaxSections.length; i++) {
      var parallaxSection = parallaxSections[i];
      var speed = parallaxSection.getAttribute('data-speed');
      var yPos = -(scrollPosition * speed);
      
      parallaxSection.style.backgroundPosition = '50% ' + yPos + 'px';
    }
  });
  