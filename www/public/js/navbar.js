$(document).ready(function() {
   $("#typeNavbar").on("change", function (){

       const valueType = $("#typeNavbar").val();

       $.ajax({
           type: 'POST',
           url: '/admin/get-data-navbar',
           data: {
               type: valueType
           },
           success: function(data) {
               data = JSON.parse(data);

               switch (valueType){
                   case 'page':
                       $("#labelSelectType").html('Sélectionner une page :');
                   break;
                   case 'category':
                       $("#labelSelectType").html('Sélectionner une catégorie :');
                       break;
                   default:
                       error();
               }

               if (data === 'error'){
                   error();
               }else {
                   $("#selectType").html('');

                   data.forEach(function(obj) {
                       $("#selectType").append('<option value="'+obj.id+'">'+obj.name+'</option>')
                   });
               }
           },
           error: function (xhr, ajaxOptions, thrownError){
               alert(xhr.responseText);
               alert(ajaxOptions);
               alert(thrownError);
               alert(xhr.status);
           }
       });

       $("#labelSelectType").show();
       $("#selectType").show();
   });
});


function error(){
    $(".centered").first().before('<div class="alert alert--red errorMessageImage"><h4>Une erreur s\'est produite</h4></div>');
}