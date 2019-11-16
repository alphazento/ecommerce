/* Common Scripts */

// This script adds class to elements on viewport - animations
(function($){
  function onScrollInit( items, trigger ) {
      items.each( function() {
      var osElement = $(this),
          osAnimationClass = osElement.attr('data-os-animation'),
          osAnimationDelay = osElement.attr('data-os-animation-delay');

          osElement.css({
              '-webkit-animation-delay':  osAnimationDelay,
              '-moz-animation-delay':     osAnimationDelay,
              'animation-delay':          osAnimationDelay
          });

          var osTrigger = ( trigger ) ? trigger : osElement;

          osTrigger.waypoint(function() {
              osElement.addClass('animated').addClass(osAnimationClass);
              },{
                  triggerOnce: true,
                  offset: '90%'
          });
      });
  }

  onScrollInit( $('.os-animation') );
  onScrollInit( $('.staggered-animation'), $('.staggered-animation-container') );

})(jQuery);


// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);

  $(document).ready(function(){
    $('.shortcut-tabs .dropdown-toggle').on('click', function() {
      location.href = $(this).attr('href');
    });
  });

  /* Search show input on click */
  $(document).ready(function(){
    $('.header-search').click(function(){
      $(this).toggleClass('active');
    });
  });

  $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      var width = $(window).width();
      if( width > 720 ){
        if (scroll >= 168) {
            $("body").addClass("sticky-header");
        }else{
          $("body").removeClass("sticky-header");
        }
      }else{
        if (scroll >= 33) {
            $("body").addClass("sticky-header");
        }else{
          $("body").removeClass("sticky-header");
        }
      }
  }); //missing );

  $(document).ready(function(){
    $("#back-to-top").click(function () {

      $('body, html').animate({
        scrollTop : 0
      }, 800);

      return false;
    });

    $("#mobile-menu-btn").click(function(){
      $('body').toggleClass('mobile-menu-active');
    });

    $('.btn-close').click(function(){
      $(this).closest('.level0').toggleClass('mob-active');
    })
  });

  /* MobAccordion Module */
  $(document).ready(function(){
    var mobaccordion__head = $('.mobaccordion__head');
    mobaccordion__head.click(function(){
      var $this = $(this);
      $this.closest('.mobaccordion').toggleClass('mobaccordion--opened');
    })
  });
})();
