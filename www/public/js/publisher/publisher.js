let counterIdBlock;
let counterIdCol;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;
let idCol;
let contentCol;

$(document).ready(function(){
    if( /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("main").children().remove();
        $("main").append("<h2 id='errorMobile'>L'éditeur n'est pas disponible sur mobile et tablette</h2>")
    }

    setTimeout(function (){
        $("#containerLoader").fadeOut(700);
    }, 500);

    $("#buttonBack").on("click", function () {
        $(".button--success").attr("onclick", "backPages()");
        $("#alertMessage").html("N'oubliez pas de sauvegarder vos modifications !");
        $(".modal").show();
    });

    $("#menuObject #icon-edit").on( "click", function() {
        modalTiny();
    });

    $("#containerPublisher").bind("DOMSubtreeModified", function() {
        $("#buttonSave").show();
    });

    $("#buttonSave").on("click", function () {
       savePage();
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


    tinymce.init({
        selector: '#tiny',
        height: '450px',
        width: '1000px',
        language: 'fr_FR',
        statusbar: false,
        block_unsupported_drop: true,
        plugins: [
            'lists',
            'table'
        ],
        toolbar: [
            'undo redo | styleselect | forecolor backcolor bold italic underline fontselect fontsizeselect | alignleft aligncenter alignright alignjustify ' +
            '| outdent indent',
            'numlist bullist | table',
        ]
    });
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
    let textTiny = tinyMCE.get('tiny').getContent();
    if (textTiny !==""){
        $("#"+idCol).html('<div>'+textTiny+'</div>');
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


