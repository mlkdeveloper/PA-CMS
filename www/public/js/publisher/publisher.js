let counterIdBlock = 1;
let counterIdCol = 1;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;




$(document).ready(function(){
    $("#icon-text").click( function (){

        let content= '<form method="post">' +
            '<textarea id="tiny" name="tiny"></textarea>' +
        '</form>';

        $("#modal-content").append(content);

        tinymce.init({
            selector: '#tiny'
        });

        $("#modal").css("display", "block");
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
    $(".activeCol").removeClass("activeCol");
    $("#"+col.id).children().addClass("activeCol");
    $("#menuObject").css("display", "block");
}



