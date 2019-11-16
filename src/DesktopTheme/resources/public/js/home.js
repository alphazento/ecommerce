(function($){

  $(document).ready(function() {
      $(".description__control").click(function() {
        $(this).closest('.description').find('.description__full').show();

        $(this).toggleClass('active');
      });
  });

})(jQuery);
