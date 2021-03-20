let counterIdBlock;
let counterIdCol;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;
let idCol;
let contentCol;
let htmlPage = "";

//Lecture du fichier JSON de la page
$.ajax({
    type: 'POST',
    url: '../.././Controllers/Publisher.php',
    data: {idPage: ""},
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

    $("#containerDeleteSection").on("click", function () {
        $("#buttonModalTiny").attr("onclick", "deleteSection()");
        $("#alertMessage").html("Êtes-vous sûr de vouloir supprimer la section ?");
        $("#modalTiny").show();
    });

    $("#containerPublisher").bind("DOMSubtreeModified", function() {
        $("#buttonSave").show();
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
    // if ($("#"+col.id).children().attr('class') !== "jumbotron containerJumbo"){
        $("#"+col.id).addClass("activeCol");
        $("#"+col.id).parent().addClass("activeRow");
    // }else {
    //     $("#"+col.id).children().addClass("activeCol");
    //     $("#"+col.id).parent().addClass("activeRow");
    // }
    $(".objectMenuHide").show();
}

//Ajout de contenu de Tiny dans la colonne
function getTiny(){
    let checkCol = ($(".activeCol").children()[0]);

    let textTiny = tinyMCE.get('tiny').getContent();
    if (textTiny !==""){
        $("#"+idCol).html('<div>'+textTiny+'</div>');
    }else if (checkCol.className !== "cross-add"){
        $("#"+idCol).html('<div class="jumbotron containerJumbo">' +
                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
            '</div>');
    }
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
    if ($("#"+idCol).children().hasClass("jumbotron") === true){
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

    let dataHtml =
        {
            "structure": [

            ]
        }

    $( "#containerPublisher section" ).each(function(index) {
        let contentCol;
        let block = {
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

            let column = {
                "idColumn": $( this ).attr('id'),
                "numberCol": $( this ).attr('class').split(" ")[0].split("-")[2],
                "content": contentCol
            }

            dataHtml["structure"][index]["columns"].push(column);
        });

    });

    dataHtml = JSON.stringify(dataHtml);

    $.ajax({
        type: 'POST',
        url: '../.././Controllers/Publisher.php',
        data: {dataHtml: dataHtml},
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
    let prevSection = $(".activeRow").parent().prev()[0];
    if (prevSection){
        prevSection.before($(".activeRow").parent()[0]);
    }
}

//Déplacement vers le bas de la section
function moveDown(){
    let nextSection = $(".activeRow").parent().next()[0];
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
            htmlPage += '<div class="col-lg-'+$(this)[0]["numberCol"]+' col-md-'+$(this)[0]["numberCol"]+' col-sm-12 col colBlock" id="'+$(this)[0]["idColumn"]+'" onclick="selectCol(this)">';

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
        url: '../.././Controllers/Publisher.php',
        data: {listImages: ""},
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

//Apparition du modal de confirmation de suppression d'une image
function confirmDeleteImage(){
    $("#buttonModalImage").hide();
    $(".imageTiny").each(function (){
        if ($(".activeImage").length !== 0) {
            if (($(this).attr('src')).split("publisher")[1] === ($(".activeImage").attr("src")).split("publisher")[1]) {
                if($("#errorImageExist").length === 0){
                    $("#errorSelectionImage").remove();
                    if ($(".errorMessageImage").length === 0) {
                        $(".buttonModalImage div").append("<div class='alert alert--red errorMessageImage'>Cette image ne peut pas être supprimée<br> car elle est utilisée sur la page</div>");
                        removeErrorMessage();
                    }
                }
            } else {
                detectionErrorsDeleteImage();
            }
        }else{
            if($(".errorMessageImage").length === 0){
                $("#errorImageExist").remove();
                if ($(".errorMessageImage").length === 0) {
                    $(".buttonModalImage div").append("<div class='alert alert--red errorMessageImage'>Aucune image sélectionnée</div>");
                    removeErrorMessage();
                }
            }
        }
    });

    if ($(".imageTiny").length === 0){
        if ($(".activeImage").length === 0){
            if($(".errorMessageImage").length === 0){
                $("#errorImageExist").remove();
                if ($(".errorMessageImage").length === 0) {
                    $(".buttonModalImage div").append("<div class='alert alert--red errorMessageImage'>Aucune image sélectionnée</div>");
                    removeErrorMessage();
                }
            }
        }else{
            detectionErrorsDeleteImage();
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
        url: '../.././Controllers/Publisher.php',
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

function inputUpload(){
    if($("#inputUpload").length === 0){
        $("#listImages").before("<input type='file' accept='image/*' name='listImages' id='inputUpload' onchange='uploadImage()'>");
    }
    $("#inputUpload").click();
}

function uploadImage(){

    var fd = new FormData();
    var files = $('#inputUpload')[0].files;

    if(files.length > 0 ){
        fd.append('file',files[0]);

        $.ajax({
            url: '../.././Controllers/Publisher.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#listImages").prepend("<img src='"+response+"' alt='image' onclick='selectImage(this)'>")
                }else{
                    alert("Une erreur c'est produite pendant le téléchargement de l'image");
                }
            },
        });
    }else{
        alert("Aucune image sélectionnée");
    }
}

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
        $(".activeCol").html("<img src='" + link + "' alt='image' class='imageTiny' style='width: 100%; height: 100%; object-fit: cover'>");
        closeModalImages();
    }
}

function removeErrorMessage(){
    setTimeout(function (){
        $(".errorMessageImage").remove();
    }, 5000);
}