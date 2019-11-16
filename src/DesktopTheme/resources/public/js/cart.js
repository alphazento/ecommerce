(function($){

  $(document).ready(function() {
      $("#block-discount-heading").click(function() {
        $('#block-discount-area').toggle();
      });
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });


  /* Hide/Show New Address Form Fields */
  $(document).ready(function() {
    var newaddressbtn = $('#add-new-address-btn');
    var newaddressdiv = $('#address-form-fields');
    var appendaddress = $('#append-address');
    var cancelnewaddress = $('#cancel-new-address');
    $( newaddressbtn ).click(function(){
      $(this).hide();
      newaddressdiv.show();
    });

    cancelnewaddress.click(function(){
      newaddressdiv.hide();
      newaddressbtn.show();
    });
  });

  $(document).ready(function() {
    /* Hide Show Credit Card Method */
    $('input[name="payment-method"]').click(function(){
      if( $(this).val() == 'option1' ){
        $('.credi-card-form').show();
      }else{
        $('.credi-card-form').hide();
      }
    });
  });
})(jQuery);
