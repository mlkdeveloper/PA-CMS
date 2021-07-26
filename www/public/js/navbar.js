var count = 2;

$(document).ready(function() {
   $("#typeNavbar").on("change", function (){

       const valueType = $("#typeNavbar").val();

       getType(valueType, false, '');

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
    $("#containerDropdownNavbar").on("change", '.typeDropdown', function (){
        let valueType = $(this).val();
        let nameType = $(this).attr('name');
        getType(valueType, true, nameType);
    });
});

function getType(valueType, dropdown, nameType){ //Affichage de la liste des pages ou des catégories en fonction de la demande
    $.ajax({
        type: 'POST',
        url: '/admin/get-data-navbar',
        data: {
            type: valueType
        },
        success: function(data) {
            data = JSON.parse(data);


            if (dropdown === false){
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
            }else {
                let numberType = nameType.split('typeDropdown')[1];
                $("#selectTypeDropdown"+numberType).html('');

                data.forEach(function(obj) {
                    $("#selectTypeDropdown"+numberType).append('<option value="'+obj.id+'">'+obj.name+'</option>')
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

function error(){ //Affichage des erreurs
    if ($("#errorType").length === 0){
        $(".centered").first().before('<div class="alert alert--red errorMessageImage" id="errorType"><h4>Le type n\'est pas correct</h4></div>');
    }
}

function addTabDropdown(){ //Ajout d'un sous-onglet
    var html = '<div class="pt-2">' +
        '            <label class="label pt-3" for="nameDropdown'+count+'">Nom de l\'onglet: </label>' +
        '            <input class="input" type="text" name="nameDropdown'+count+'" maxlength="50" minlength="2">' +
        '            <label class="label pt-3" for="typeDropdown'+count+'">Type: </label>' +
        '            <select class="input typeDropdown" name="typeDropdown'+count+'">' +
        '                <option value="" disabled selected>Sélectionner le type de la page</option>' +
        '                <option value="page">Page statique</option>' +
        '                <option value="category">Category</option>' +
        '            </select>' +
        '            <select class="input" name="selectTypeDropdown'+count+'" id="selectTypeDropdown'+count+'"></select>' +
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
        success: function(data, res, code) {
            if (code.status === 201){
                upContainer(btnUp)
            }
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
    next.animate({ "top": "-="+h }, "fast" );
    div.animate({ "top": "+="+h }, "fast", function(){
        div.insertAfter( next );
    } );
}

function upContainer(btnUp) {
    var div = $(btnUp).parent().parent().parent().parent().parent().parent().parent().parent();
    var h = div.css("height");
    var prev = div.prev();
    prev.animate({ "top": "+="+h }, "fast" );
    div.animate({ "top": "-="+h }, "fast", function(){
        div.insertBefore( prev );
    } );
}

function showModalDeleteTab(id, status){
    $("#buttonDeleteTab").attr("href", "/admin/onglet-barre-navigation?id="+id+"&status="+status);
    $("#modalDeleteTab").show();
}

function hideModalDeleteTab(){
    $("#modalDeleteTab").hide();
}