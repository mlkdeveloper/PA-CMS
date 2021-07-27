var counterIdBlock;
var counterIdCol;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
var html;
var idCol;
var contentCol;
var htmlPage = "";
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const namePage = urlParams.get('name')

//Lecture du fichier JSON de la page
$.ajax({
    type: 'POST',
    url: '/admin/read-publisher',
    data: {namePage: namePage},
    success: function(data) {
        if (data) {
            read(data);
        }else{
            counterIdBlock = 1;
            counterIdCol = 1;

            setTimeout(function (){
                $("#containerLoader").fadeOut(700);
            }, 500);
        }
    },
    error: function (xhr, ajaxOptions, thrownError){
        alert(xhr.responseText);
        alert(ajaxOptions);
        alert(thrownError);
        alert(xhr.status);
    }
});

$(document).ready(function(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("main").children().remove();
        $("main").append("<h2 id='errorMobile'>L'éditeur n'est pas disponible sur mobile et tablette</h2>")
    }else{
        tinymce.init({
            selector: '#tiny',
            height: '450px',
            width: '1000px',
            language: 'fr_FR',
            statusbar: false,
            plugins: [
                'lists',
                'table',
            ],
            toolbar: [
                'undo redo | styleselect | forecolor backcolor bold italic underline fontselect fontsizeselect | alignleft aligncenter alignright alignjustify ' +
                '| outdent indent',
                'numlist bullist | table',
            ],
        });
    }



    $("#buttonBack").on("click", function () {
        $("#buttonModalTiny").attr("onclick", "backPages()");
        $("#alertMessage").html("N'oubliez pas de sauvegarder vos modifications !");
        $("#modalTiny").show();
    });

    $("#menuObject #icon-edit").on( "click", function() {
        modalTiny();
    });

    $("#menuObject #icon-image").on( "click", function() {
        modalImages();
    });

    $("#buttonSave").on("click", function () {
       savePage();
    });

    $("#icon-arrow-up").on("click", function () {
        moveUp();
    });

    $("#icon-arrow-down").on("click", function () {
        moveDown();
    });

    $("#btnHideMenu").on("click", function () {
        hideMenu();
    });

    $("#btnShowMenu").on("click", function () {
        showMenu();
    });

    $("#paramBloc").on("click", function () {
        paramBloc();
    });

    $("#containerDeleteSection").on("click", function () {
        $("#buttonModalTiny").attr("onclick", "deleteSection()");
        $("#alertMessage").html("Êtes-vous sûr de vouloir supprimer la section ?");
        $("#modalTiny").show();
    });

    $("#containerPublisher").bind("DOMSubtreeModified", function() {
        $("#buttonSave").show();
    });

    $("#checkBackgroud").on("click", function (){
        if ($("#checkBackgroud").is(":checked")){
            $("#backgroundBloc").show();
        }else {
            $("#backgroundBloc").hide();
        }
    });
});


//Ajout d'un bloc
function addBlock(colNumber) {
    if (colNumber > 12) {
        switch (colNumber){

            case 39:
                html = '<section class="container" id="'+prefixIdBlock+counterIdBlock+'">' +
                    '<div class="row">' +
                        '<div class="col-lg-3 col-md-3 col-sm-12 col colBlock" id="'+prefixIdCol+counterIdCol+'" onclick="selectCol(this)">' +
                            '<div class="jumbotron containerJumbo">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>'
                        counterIdCol++;
                        html += '<div class="col-lg-9 col-md-9 col-sm-12 col colBlock" id="'+prefixIdCol+counterIdCol+'" onclick="selectCol(this)">' +
                            '<div class="jumbotron containerJumbo">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>';
                        counterIdCol++;
                    html +='</div>' +
                '</section>';
                counterIdBlock++;
                break;
            case 93:
                html = '<section class="container" id="'+prefixIdBlock+counterIdBlock+'">' +
                    '<div class="row">' +
                        '<div class="col-lg-9 col-md-9 col-sm-12 col colBlock" id="'+prefixIdCol+counterIdCol+'" onclick="selectCol(this)">' +
                            '<div class="jumbotron containerJumbo">' +
                            '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                        '   </div>' +
                        '</div>'
                        counterIdCol++;
                        html += '<div class="col-lg-3 col-md-3 col-sm-12 col colBlock" id="'+prefixIdCol+counterIdCol+'" onclick="selectCol(this)">' +
                            '<div class="jumbotron containerJumbo">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>';
                        counterIdCol++;
                    html += '</div>' +
                '</section>';
                counterIdBlock++;
                break;
        }

    } else {

        html = '<section class="container" id="'+prefixIdBlock+counterIdBlock+'">' +
            '<div class="row">';

        for (var i = 0; i < 12; i += colNumber) {

            html += '<div class="col-lg-' + colNumber + ' col-md-' + colNumber + ' col-sm-12 col colBlock" id="'+prefixIdCol+counterIdCol+'" onclick="selectCol(this)">' +
                '<div class="jumbotron containerJumbo">' +
                    '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                '</div>' +
            '</div>';
            counterIdCol++;
        }

        html += '</div>' +
            '</section>';
        counterIdBlock++;
    }

    $("#containerPublisher").append(html);
}

//Sélection de la colonne
function selectCol(col){
    idCol = col.id;
    contentCol = $("#"+idCol).html();
    $(".activeCol").removeClass("activeCol");
    $(".activeRow").removeClass("activeRow");

    $("#"+col.id).addClass("activeCol");
    $("#"+col.id).parent().addClass("activeRow");

    $(".objectMenuHide").show();
}

//Ajout de contenu de Tiny dans la colonne
function getTiny(){
    var checkCol = ($(".activeCol").children()[0]);

    var textTiny = tinyMCE.get('tiny').getContent();
    if (textTiny !==""){
        $("#"+idCol).html('<div>'+textTiny+'</div>');
    }else if (checkCol.className !== "cross-add"){
        $("#"+idCol).html('<div class="jumbotron containerJumbo">' +
                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
            '</div>');
    }
    $(".activeCol").removeClass("activeCol");
    $(".activeRow").removeClass("activeRow");
    $("#modalTiny").hide();
    $("#formTiny").hide();
}

//Fermeture du modal
function closeModal(){
    $("#modalTiny").hide();
    $("#textBack").hide();
    $("#formTiny").hide();
}

//Fermeture du modal du gestionnaire des images
function closeModalImages(){
    $("#modalImages").hide();
    $(".titleUploadImage").remove();
}

//Apparition du modal Tiny
function modalTiny(){
    $("#formTiny").show();
    $("#alertMessage").html("");
    if ($("#"+idCol).children().hasClass("jumbotron") === true) {
        tinyMCE.activeEditor.setContent("");
    }else if ($("#"+idCol).children().hasClass("imageUploaded") === true){
        tinyMCE.activeEditor.setContent("");
    }else{
        tinyMCE.activeEditor.setContent(contentCol);
    }
    $("#buttonModalTiny").attr("onclick", "getTiny()");
    $("#modalTiny").show();
}

//Sauvegarde de la page
function savePage(){

    $(".activeCol").removeClass("activeCol");
    $(".activeRow").removeClass("activeRow");
    $(".objectMenuHide").hide();

    $("#buttonSave").hide();
    $("#loader").show();

    var dataHtml =
        {
            "structure": [

            ]
        }

    $( "#containerPublisher section" ).each(function(index) {
        var contentCol;
        var css;
        var block = {
            "idBlock": $(this).attr('id'),
            "columns": [
            ]
        }

        dataHtml["structure"].push(block);

        $( this ).children().children().each(function() {
            if($( this ).children().attr('class') === "jumbotron containerJumbo" ){
                contentCol = "";
            }else{
                contentCol = $( this ).html();
            }

            if ( $( this ).attr('style') !== undefined){
                css = $( this ).attr('style');
            }else {
                css = "";
            }

            var column = {
                "idColumn": $( this ).attr('id'),
                "numberCol": $( this ).attr('class').split(" ")[0].split("-")[2],
                "content": contentCol,
                "css": css
            }

            dataHtml["structure"][index]["columns"].push(column);
        });

    });

    dataHtml = JSON.stringify(dataHtml);

    $.ajax({
        type: 'POST',
        url: '/admin/save-publisher',
        data: {
            dataHtml: dataHtml,
            namePage: namePage
        },
        success: function(msg) {
            setTimeout(function(){
                $("#loader").hide();
                $("#alertSave").show();
                $("#alertSave").css("animation", "fadeInAlert 1s");
            }, 1500);
            setTimeout(function(){
                $("#alertSave").hide();
            }, 5000);
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}

//Retour aux pages
function backPages(){
    $("#modalTiny").hide();
    document.location.replace("/admin/pages");
}

//Suppresion de la section
function deleteSection(){
    let section = $(".activeRow").parent().attr('id')
    $("#"+section).remove();
    $(".objectMenuHide").hide();
    $("#modalTiny").hide();
}

//Déplacement vers le haut de la section
function moveUp(){
    var prevSection = $(".activeRow").parent().prev()[0];
    if (prevSection){
        prevSection.before($(".activeRow").parent()[0]);
    }
}

//Déplacement vers le bas de la section
function moveDown(){
    var nextSection = $(".activeRow").parent().next()[0];
    if (nextSection){
        nextSection.after($(".activeRow").parent()[0]);
    }
}

//Lecture du fichier json et affichage de la page
function read(data){

    data = JSON.parse(data);

    $.each(data["structure"], function() {

        htmlPage += '<section class="container" id="'+$(this)[0]["idBlock"]+'">' +
            '<div class="row">';

        $.each($(this)[0]["columns"], function () {
            htmlPage += '<div class="col-lg-'+$(this)[0]["numberCol"]+' col-md-'+$(this)[0]["numberCol"]+' col-sm-12 col colBlock" id="'+$(this)[0]["idColumn"]+'" style="'+$(this)[0]["css"]+'" onclick="selectCol(this)">';

            if ($(this)[0]["content"] ){
                htmlPage += $(this)[0]["content"];
            }else {
                htmlPage += '<div class="jumbotron containerJumbo">' +
                    '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                    '</div>';
            }
            htmlPage += '</div>';
        });

        htmlPage += '</div>' +
            '</section>';
    });
    $("#containerPublisher").html(htmlPage);

    if ($("#containerPublisher").html()){
        counterIdBlock = parseInt(($("#containerPublisher").children().last().attr("id")).split("_")[1])+1;
        counterIdCol = parseInt(($("#containerPublisher").children().children().children().last().attr("id")).split("_")[1])+1;
    }else {
        counterIdBlock = 1;
        counterIdCol = 1;
    }

    setTimeout(function (){
        $("#containerLoader").fadeOut(700);
    }, 500);
}

//Apparition du modal images
function modalImages(){

    $("#errorSelectionImage").remove();
    $("#errorImageExist").remove();

    $("#modalImages").show();


    $.ajax({
        type: 'POST',
        url: '/admin/images-publisher',
        data: '',
        success: function(data) {
            if (data) {
                $("#listImages").html("");
                if (data === "undefined"){
                    if($(".titleUploadImage").length === 0) {
                        $("#listImages").before("<h3 class='titleUploadImage'>Aucune images sur le serveur</h3>");
                    }
                    $(".buttonModalImage div").css("background-color", "transparent");
                }else {
                    if($(".titleUploadImage").length === 0) {
                        $("#listImages").before("<h3 class='titleUploadImage'>Sélectionnez une image</h3>");
                    }
                    data.split("|").forEach(function (image){
                        if (image !== ""){
                            $("#listImages").append("<img src='../publisher/images/"+image+"' alt='image' onclick='selectImage(this)'>");
                        }
                    });
                }
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

//Sélection d'une image du gestionnaire d'images
function selectImage(image){
    $(".activeImage").removeClass("activeImage");
    image.classList.add("activeImage");
}

function checkTemplateImage(){
    console.log(namePage);

    $.ajax({
        type: 'POST',
        url: '/admin/check-image-publisher',
        data: {
            checkDeleteImage: $(".activeImage").attr("src"),
            namePageDeleteImage: namePage
        },
        success: function(data) {
            if (data !== "false"){
                if ($(".errorMessageImage").length === 0) {
                    $("#selectImage h3").append("<div class='alert alert--red errorMessageImage'>Cette image ne peut pas être supprimée<br> car elle est utilisée sur la page: "+data+"</div>");
                    removeErrorMessage();
                }
            }else{
                detectionErrorsDeleteImage();
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

//Apparition du modal de confirmation de suppression d'une image
function confirmDeleteImage(){
    $("#buttonModalImage").hide();
    $(".imageUploaded").each(function (){
        if ($(".activeImage").length !== 0) {
            if (($(this).attr('src')).split("publisher")[1] === ($(".activeImage").attr("src")).split("publisher")[1]) {
                if($("#errorImageExist").length === 0){
                    $("#errorSelectionImage").remove();
                    if ($(".errorMessageImage").length === 0) {
                        $("#selectImage h3").append("<div class='alert alert--red errorMessageImage'>Cette image ne peut pas être supprimée<br> car elle est utilisée sur cette page</div>");
                        removeErrorMessage();
                        return false;
                    }
                }
            } else {
                checkTemplateImage();
            }
        }else{
            if($(".errorMessageImage").length === 0){
                $("#errorImageExist").remove();
                if ($(".errorMessageImage").length === 0) {
                    $("#selectImage h3").append("<div class='alert alert--red errorMessageImage'>Aucune image sélectionnée</div>");
                    removeErrorMessage();
                    return false;
                }
            }
        }
    });

    if ($(".imageUploaded").length === 0){
        if ($(".activeImage").length === 0){
            if($(".errorMessageImage").length === 0){
                $("#errorImageExist").remove();
                if ($(".errorMessageImage").length === 0) {
                    $("#selectImage h3").append("<div class='alert alert--red errorMessageImage'>Aucune image sélectionnée</div>");
                    removeErrorMessage();
                }
            }
        }else{
            checkTemplateImage();
        }
    }
}

//Gestion des erreurs pour lers images
function detectionErrorsDeleteImage(){
    $("#errorSelectionImage").remove();
    $("#errorImageExist").remove();
    $(".buttonModalImage").hide();
    $("#selectImage").hide();
    $("#confirmDeleteImage").show();
}

//Fermeture du modal de confirmation de suppression d'une image
function closeModalConfirmImages(){
    $("#confirmDeleteImage").hide();
    $(".buttonModalImage").show();
    $("#selectImage").show();
}

//Suppression de l'image
function deleteImage(){

    $.ajax({
        type: 'POST',
        url: '/admin/delete-image-publisher',
        data: {srcImage: $(".activeImage").attr("src")},
        success: function(data) {
            $(".activeImage").remove();
            $("#confirmDeleteImage").hide();
            $(".buttonModalImage").show();
            $("#selectImage").show();
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}

//Clique sur l'input d'upload des images
function inputUpload(){
    if($("#inputUpload").length === 0){
        $("#listImages").before("<input type='file' accept='image/*' name='listImages' id='inputUpload' onchange='uploadImage()'>");
    }
    $("#inputUpload").click();
}

//Upload sur le serveur de l'image
function uploadImage(){

    var fd = new FormData();
    var files = $('#inputUpload')[0].files;

    if(files.length > 0 ){
        fd.append('file',files[0]);

        $.ajax({
            url: '/admin/upload-image-publisher',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                var message = JSON.parse(response);

                if(message.error === undefined){
                    $("#listImages").prepend("<img src='."+message.success+"' alt='image' onclick='selectImage(this)'>")
                }else{
                    if ($(".errorMessageImage").length === 0) {
                        $("#selectImage h3").append("<div class='alert alert--red errorMessageImage'>"+message.error+"</div>");
                        removeErrorMessage()
                    }
                }
            },
        });
    }else{
        alert("Aucune image sélectionnée");
    }
}

//Ajout de l'image dans la gallerie
function addImage() {
    if ($(".activeCol").length === 0) {
        if ($(".errorMessageImage").length === 0) {
            $(".buttonModalImage div").append("<div class='alert alert--red errorMessageImage'>Aucun bloc sélectionné</div>");
            removeErrorMessage()
        }
    }else if ($(".activeImage").length === 0){
        if ($(".errorMessageImage").length === 0) {
            $(".buttonModalImage div").append("<div class='alert alert--red errorMessageImage'>Aucun image sélectionnée</div>");
            removeErrorMessage()
        }
    }else{
        let link = $(".activeImage").attr("src");
        $(".activeCol").html("<img src='" + link + "' alt='image' class='imageUploaded' style='width: 100%; height: 100%;'>");
        closeModalImages();
    }
}

//Suppresion des messages d'erreur
function removeErrorMessage(){
    setTimeout(function (){
        $(".errorMessageImage").remove();
    }, 5000);
}

//Disparition du menu
function hideMenu(){
    $('#sidenavPublisher').animate({
            width: 'toggle'
        },
        {
            start: function() {
                $(".container-body").css("width", "100%");
            },
            step: function(now) {
                if (now < 100){
                    $('#sidenavPublisher > div').hide();
                }
            },
            complete: function(){
                setTimeout(function (){
                    $("#btnShowMenu").show();
                }, 200);
            }
        }
    );
}

//Apparition du menu
function showMenu(){
    $('#sidenavPublisher').animate({
            width: 'toggle'
        },
        {
            start: function() {
                $("#btnShowMenu").hide();
                $(".container-body").css("width", "calc(100% - 220px)");
            },
            step: function(now) {
                if (now > 90){
                    $('#sidenavPublisher > div').show();
                }
            },
        }
    );
}

function paramBloc(){
    if ($(".activeCol").children().attr("class") === "jumbotron containerJumbo"){
        if ($("#noParamaBloc").length === 0) {
            $("#modalparamBloc > div").prepend("<h3 id='noParamaBloc'>Aucun paramètres pour ce type de bloc</h3>");
        }
        $("#containerParamBloc").hide();
    }else {
        $("#noParamaBloc").remove();
        $("#containerParamBloc").show();
        if ($(".activeCol").find("img").length > 0 && $(".activeCol").find("img").attr("class") === "imageUploaded") {

            var widthPx = $('.activeCol').children().width();
            var parentWidthPx = $('.activeCol').width();
            var width = 100*widthPx/parentWidthPx;

            var heightPx = $('.activeCol').children().height();
            var parentHeightPX = $('.activeCol').height();
            var height = 100*heightPx/parentHeightPX;

            $("#widthImage").val(Math.trunc(width));
            $("#heightImage").val(Math.trunc(height));
            $("#paramImage").show();
        } else {
            $("#paramImage").hide();
        }

        if ($(".activeCol").css("background-color") === "rgba(0, 0, 0, 0)"){
            $("#checkBackgroud").prop("checked", false);
        }else {
            var rgb = $(".activeCol").css("background-color");
            $("#checkBackgroud").prop("checked", true);
            $("#backgroundBloc").val(hexa(rgb));
        }

        if (!$("#checkBackgroud").is(":checked")) {
            $("#backgroundBloc").hide();
        }else {
            $("#backgroundBloc").show();
        }

        $("#paddingLeft").val($(".activeCol").css("padding-left").split("px")[0]);
        $("#paddingRight").val($(".activeCol").css("padding-right").split("px")[0]);
        $("#paddingTop").val($(".activeCol").css("padding-top").split("px")[0]);
        $("#paddingBottom").val($(".activeCol").css("padding-bottom").split("px")[0]);


        $("#radius").val($(".activeCol").css("border-radius").split("px")[0]);

        if ($(".activeCol").css("box-shadow") !== "none"){
            $("#shadow").prop("checked", true);
        }else{
            $("#shadow").prop("checked", false);
        }
    }

    $("#modalparamBloc").show();
}

function hexa(rgb){
    rgb = rgb.match(/^rgb\(([0-9]+)[,]\s([0-9]+)[,]\s([0-9]+)\)$/);
    return "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
}

function closeModalParamBloc(){
    $("#modalparamBloc").hide();
}

function saveParamBloc(){
    if ($("#paramImage").is(":visible") === true){
        var width = $("#widthImage").val();
        var height = $("#heightImage").val();
        if (width > 100 || width < 0 || height > 100 || height < 0){
            if ($(".errorMessageImage").length === 0) {
                $("#paramImage").prepend("<div class='alert alert--red errorMessageImage'>Les valeurs de l'image doivent être comprises entre 0 et 100</div>");
                removeErrorMessage();
            }
        }else{
            $(".activeCol").find("img").css({"width": width+"%", "height": height+"%"});
        }
    }

    if ($("#checkBackgroud").is(":checked")){
        var color = $("#backgroundBloc").val();
        $(".activeCol").css("background-color", color);
    }else {
        $(".activeCol").css("background-color", "transparent");
    }

    var paddingLeft = $("#paddingLeft").val();
    var paddingRight = $("#paddingRight").val();
    var paddingTop = $("#paddingTop").val();
    var paddingBottom = $("#paddingBottom").val();

    var radius = $("#radius").val();

    if (paddingLeft < 0
        || paddingRight < 0
        || paddingTop < 0
        || paddingBottom < 0
        || radius < 0)
    {
        $("#paramImage").prepend("<div class='alert alert--red errorMessageImage'>Les valeurs des padding doivent être supérieures ou égal à 0</div>");
        removeErrorMessage();
    }else {
        $(".activeCol").css("padding-left", paddingLeft+"px");
        $(".activeCol").css("padding-right", paddingRight+"px");
        $(".activeCol").css("padding-top", paddingTop+"px");
        $(".activeCol").css("padding-bottom", paddingBottom+"px");

        $(".activeCol").css("border-radius", radius+"px");
    }

    if ($("#shadow").is(":checked")){
        $(".activeCol").css("box-shadow", "0 0 10px rgb(0 0 0 / 8%");
    }else {
        $(".activeCol").css("box-shadow", "none")
    }

    if ($(".errorMessageImage").length === 0){
        $("#modalparamBloc").hide();
        $("#buttonSave").show();
    }
}