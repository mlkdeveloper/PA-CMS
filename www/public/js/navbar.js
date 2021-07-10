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
    if ($("#errorType").length === 0){
        $(".centered").first().before('<div class="alert alert--red errorMessageImage" id="errorType"><h4>Le type n\'est pas correct</h4></div>');
    }
}