var count = 2;

$(document).ready(function() {
   $("#typeNavbar").on("change", function (){

       const valueType = $("#typeNavbar").val();

       getType(valueType);

       $("#labelSelectType").show();
       $("#selectType").show();
   });

    $('#dropdown').change(function(){
       if ($(this).is(':checked')) {
           $("#containerSimpleTab").hide();
           $("#containerDropdownNavbar").show();
       }else {
           $("#containerSimpleTab").show();
           $("#containerDropdownNavbar").hide();
       }
    });

    $("#addTabDropdown").on("click", function (){
       addTabDropdown();
    });
    
    $("#containerDropdownNavbar").on('click', '.fa-minus-circle', function (){
        $(this).parent().parent().remove();
    });
});

function getType(valueType){
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
                    $("#labelSelectType").html('Sélectionner une page: ');
                    break;
                case 'category':
                    $("#labelSelectType").html('Sélectionner une catégorie: ');
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
}

function error(){
    if ($("#errorType").length === 0){
        $(".centered").first().before('<div class="alert alert--red errorMessageImage" id="errorType"><h4>Le type n\'est pas correct</h4></div>');
    }
}

function addTabDropdown(){
    var html = '<div class="pt-2">' +
        '            <label class="label pt-3" for="nameDropdown'+count+'">Nom de l\'onglet: </label>\n' +
        '            <input class="input" type="text" name="nameDropdown'+count+'" maxlength="50" minlength="2">\n' +
        '            <label class="label pt-3" for="typeDropdown'+count+'">Type: </label>\n' +
        '            <select class="input" name="typeDropdown'+count+'">\n' +
        '                <option value="" disabled selected>Sélectionner le type de la page</option>\n' +
        '                <option value="page">Page statique</option>\n' +
        '                <option value="category">Category</option>\n' +
        '            </select>\n' +
        '            <select class="input" name="selectTypeDropdown'+count+'">\n' +
        '                <option value="" disabled selected>Sélectionner le type de la page</option>\n' +
        '                <option value="page">Page statique</option>\n' +
        '                <option value="category">Category</option>\n' +
        '            </select>\n' +
        '            <span><i class="fas fa-minus-circle"></i></span>' +
        '      </div>';

    count++;
    $("#addTabDropdown").before(html);
}

function up(id,btnUp){

    $.ajax({
        type: 'POST',
        url: '/admin/up-navbar',
        data: {
            id: id
        },
        success: function(data) {
            upContainer(btnUp)
        },
        error: function (xhr, ajaxOptions, thrownError){
        }
    });


}

function down(id,btnDown){

    $.ajax({
        type: 'POST',
        url: '/admin/down-navbar',
        data: {
            id: id
        },
        success: function(data,res,code) {

           if (code.status === 200){
               downContainer(btnDown)
           }

            console.log(code);

        },
        error: function (xhr, ajaxOptions, thrownError){
        }
    });


}
function downContainer(btnDown){

    var div = $(btnDown).parent().parent().parent().parent().parent().parent().parent().parent();

    var h = div.css("height");
    var next = div.next();
    next.animate({ "top": "-="+h }, "slow" );
    div.animate({ "top": "+="+h }, "slow", function(){
        div.insertAfter( next );
    } );
}
function upContainer(btnUp) {
    var div = $(btnUp).parent().parent().parent().parent().parent().parent().parent().parent();
    var h = div.css("height");
    var prev = div.prev();
    prev.animate({ "top": "+="+h }, "slow" );
    div.animate({ "top": "-="+h }, "slow", function(){
        div.insertBefore( prev );
    } );
}