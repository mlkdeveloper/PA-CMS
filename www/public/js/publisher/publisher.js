let counterIdBlock;
let counterIdCol;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;
let idCol;
let contentCol;


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

$(document).ready(function(){
    $("#buttonBack").on("click", function () {
        console.log($(".button--success"));
        $(".button--success").attr("onclick", "backPages()");
        $("#textBack").show();
        $(".modal").show();
    });

    $("#menuObject .col").on( "click", function() {
        modalTiny();
    });

    $("#containerPublisher").bind("DOMSubtreeModified", function() {
        $("#buttonSave").show();
    });

    $("#buttonSave").on("click", function () {
       savePage();
    });

    if ($("#containerPublisher").html()){
        counterIdBlock = parseInt(($("#containerPublisher").children().last().attr("id")).split("_")[1])+1;
        counterIdCol = parseInt(($("#containerPublisher").children().children().children().last().attr("id")).split("_")[1])+1;

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
    if ($("#"+col.id).children().attr('class') !== "jumbotron containerJumbo"){
        $("#"+col.id).addClass("activeCol");
    }else {
        $("#"+col.id).children().addClass("activeCol");
    }
    $("#menuObject").show();
}

function getTiny(){
    let textTiny = tinyMCE.get('tiny').getContent();
    if (textTiny !==""){
        $("#"+idCol).html('<div>'+textTiny+'</div>');
    }
    $(".modal").hide();
}

function closeModal(){
    $(".modal").hide();
    $("#textBack").hide();
    $("#formTiny").hide();

}

function modalTiny(){
    $("#formTiny").show();
    if ($("#"+idCol).children().hasClass("jumbotron") === true){
        tinyMCE.activeEditor.setContent("");
    }else{
        tinyMCE.activeEditor.setContent(contentCol);
    }
    $(".button--success").attr("onclick", "getTiny()");
    $(".modal").show();
}

function savePage(){

    $("#buttonSave").hide();
    $("#loader").show();

    $(".activeCol").removeClass("activeCol");

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
    document.location.replace("/admin/pages");
}


