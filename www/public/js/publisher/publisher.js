let counterIdBlock;
let counterIdCol;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;
let idCol;
let contentCol;
let htmlPage;

$.ajax({
    type: 'POST',
    url: '../.././Controllers/Publisher.php',
    data: {idPage: ""},
    success: function(data) {
        if (data) {
            read(data);
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
            block_unsupported_drop: true,
            file_picker_types: 'image',
            image_description: false,
            images_file_types: 'jpg,png,gif',
            plugins: [
                'lists',
                'table',
                'image',
                'imagetools'
            ],
            toolbar: [
                'undo redo | styleselect | forecolor backcolor bold italic underline fontselect fontsizeselect | alignleft aligncenter alignright alignjustify ' +
                '| outdent indent',
                'numlist bullist | table image',
            ],
            automatic_uploads: true,

            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '../.././Controllers/Publisher.php');

                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            },
        });
    }



    $("#buttonBack").on("click", function () {
        $(".button--success").attr("onclick", "backPages()");
        $("#alertMessage").html("N'oubliez pas de sauvegarder vos modifications !");
        $(".modal").show();
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
        $(".button--success").attr("onclick", "deleteSection()");
        $("#alertMessage").html("Êtes-vous sûr de vouloir supprimer la section ?");
        $(".modal").show();
    });

    if ($("#containerPublisher").html()){
        counterIdBlock = parseInt(($("#containerPublisher").children().last().attr("id")).split("_")[1])+1;
        counterIdCol = parseInt(($("#containerPublisher").children().children().children().last().attr("id")).split("_")[1])+1;

    }else {
        counterIdBlock = 1;
        counterIdCol = 1;
    }

    $("#containerPublisher").bind("DOMSubtreeModified", function() {
        $("#buttonSave").show();
    });

    setTimeout(function (){
        $("#containerLoader").fadeOut(700);
    }, 500);
});



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

function selectCol(col){
    idCol = col.id;
    contentCol = $("#"+idCol).html();
    $(".activeCol").removeClass("activeCol");
    $(".activeRow").removeClass("activeRow");
    if ($("#"+col.id).children().attr('class') !== "jumbotron containerJumbo"){
        $("#"+col.id).addClass("activeCol");
        $("#"+col.id).parent().addClass("activeRow");
    }else {
        $("#"+col.id).children().addClass("activeCol");
        $("#"+col.id).parent().addClass("activeRow");
    }
    $("#menuObject").show();
}

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
    $(".modal").hide();
    $("#formTiny").hide();
}

function closeModal(){
    $(".modal").hide();
    $("#textBack").hide();
    $("#formTiny").hide();

}

function modalTiny(){
    $("#formTiny").show();
    $("#alertMessage").html("");
    if ($("#"+idCol).children().hasClass("jumbotron") === true){
        tinyMCE.activeEditor.setContent("");
    }else{
        tinyMCE.activeEditor.setContent(contentCol);
    }
    $(".button--success").attr("onclick", "getTiny()");
    $(".modal").show();
}

function savePage(){

    $(".activeCol").removeClass("activeCol");
    $(".activeRow").removeClass("activeRow");
    $("#menuObject").hide();

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

function backPages(){
    $(".modal").hide();
    document.location.replace("/admin/pages");
}

function deleteSection(){
    let section = $(".activeRow").parent().attr('id')
    $("#"+section).remove();
    $("#menuObject").hide();
    $(".modal").hide();
}

function moveUp(){
    let prevSection = $(".activeRow").parent().prev()[0];
    if (prevSection){
        prevSection.before($(".activeRow").parent()[0]);
    }
}

function moveDown(){
    let nextSection = $(".activeRow").parent().next()[0];
    if (nextSection){
        nextSection.after($(".activeRow").parent()[0]);
    }
}

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
}

function modalImages(){
    $.ajax({
        type: 'POST',
        url: '../.././Controllers/Publisher.php',
        data: {listImages: ""},
        success: function(data) {
            if (data) {
                $("#listImages").html("");
                data.split("|").forEach(function (image){
                    if (image !== ""){
                        $("#listImages").append("<img style='width: 100px; height: 100px' src='../publisher/images/"+image+"' alt='image'>");
                    }
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

    $(".modal").show();
}

