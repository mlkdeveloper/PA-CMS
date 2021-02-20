let counterIdBlock;
let counterIdCol;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;
let idCol;
let contentCol;


tinymce.init({
    selector: '#tiny',
    height: '350px',
    width: '1000px'
});

$(document).ready(function(){
    $("#icon-text").on( "click", function() {
        modalTiny();
    });

    $("#containerPublisher").bind("DOMSubtreeModified", function() {
        $("#buttonSave").css("display", "block");
    });

    $("#buttonSave").on("click", function () {
       savePage();
    });

    if ($("#containerPublisher").html()){
        counterIdBlock = ($("#containerPublisher").children().last().attr("id")).split("_")[1];
        counterIdCol = ($("#containerPublisher").children().children().children().last().attr("id")).split("_")[1];

    }else {
        counterIdBlock = 1;
        counterIdCol = 1;
    }
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
    $("#"+col.id).children().addClass("activeCol");
    $("#menuObject").css("display", "block");
}

function getTiny(){
    let textTiny = tinyMCE.get('tiny').getContent();
    if (textTiny !==""){
        $("#"+idCol).html('<div>'+textTiny+'</div>');
    }
    $(".modal").css("display", "none");
}

function closeModal(){
    $(".modal").css("display", "none");
}

function modalTiny(){
    $("#formTiny").css("display", "block");
    if ($("#"+idCol).children().hasClass("jumbotron") === true){
        tinyMCE.activeEditor.setContent("");
    }else{
        tinyMCE.activeEditor.setContent(contentCol);
    }
    $(".button--alert").css("onclick", "closeModal()");
    $(".button--success").css("onclick", "getTiny()");
    $(".modal").css("display", "block");
}

function savePage(){

    let dataHtml =
        {
            "structure": [

            ]
        }

    $( "#containerPublisher section" ).each(function(index) {

        let block = {
            "idBlock": $(this).attr('id'),
            "columns": [
            ]
        }

        dataHtml["structure"].push(block);

        $( this ).children().children().each(function() {

            let column = {
                "idColumn": $( this ).attr('id'),
                "numberCol": $( this ).attr('class').split(" ")[0].split("_")[1],
                "content": $( this ).html()
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
            alert("ok");
        },
        error: function (xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            alert(ajaxOptions);
            alert(thrownError);
            alert(xhr.status);
        }
    });
}


