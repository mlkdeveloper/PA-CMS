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
               console.log(data);
               if (data === 'erreur'){
                   $(".centered").first().before("<div class=\"alert alert--red errorMessageImage\"><h4>Une erreur s'est produite</h4></div>");
               }else {
                   console.log(data);
               }
           },
           error: function (xhr, ajaxOptions, thrownError){
               alert(xhr.responseText);
               alert(ajaxOptions);
               alert(thrownError);
               alert(xhr.status);
           }
       });

       $("#containerSelectTypeNavbar").show();
   });
});