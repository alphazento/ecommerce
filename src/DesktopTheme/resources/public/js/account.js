$(function() {

    // Account Information Hide Show Email Password fields
    var cef_t = "Change Email";
    var cpf_t = "Change Password";
    var cepf_t = "Change Email and Password";

    var cef = $('#change-email-fields').html();
    var cpf = $('#change-password-fields').html();

    $('input#change-email[type="checkbox"]').click(function(){
       if($(this).prop("checked") == true){
           $('#emailpassfields').show();
           $('#dynamic-fields').append(cef);
           if($('input#change-pass[type="checkbox"]').prop("checked") == true){
             $('#dynamic-title').html(cepf_t);
           }else{
             $('#dynamic-title').html(cef_t);
           }
       }
       else if($(this).prop("checked") == false){
           $('#dynamic-fields .change-email-fields').remove();
           if($('input#change-pass[type="checkbox"]').prop("checked") == true){
             $('#dynamic-title').html(cpf_t);
           }else{
             $('#dynamic-title').html('');
             $('#emailpassfields').hide();
           }
       }
    });

    $('input#change-pass[type="checkbox"]').click(function(){
       if($(this).prop("checked") == true){
         $('#emailpassfields').show();
         $('#dynamic-fields').append(cpf);
         if($('input#change-email[type="checkbox"]').prop("checked") == true){
           $('#dynamic-title').html(cepf_t);
         }else{
           $('#dynamic-title').html(cpf_t);
         }
       }
       else if($(this).prop("checked") == false){
           $('#dynamic-fields .change-password-fields').remove();
           if($('input#change-email[type="checkbox"]').prop("checked") == true){
             $('#dynamic-title').html(cef_t);
           }else{
             $('#dynamic-title').html('');
             $('#emailpassfields').hide();
           }
       }
    });
});
