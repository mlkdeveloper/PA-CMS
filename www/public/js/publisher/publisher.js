let counterIdBlock = 1;
let counterIdCol = 1;
const prefixIdBlock = "block_";
const prefixIdCol = "col_";
let html;

function addBlock(col) {

    if (col > 12) {
        switch (col){

            case 39:
                html = '<section class="container" id="'+prefixIdBlock+counterIdBlock+'">' +
                    '<div class="row">' +
                        '<div class="col-lg-3 col-md-3 col-sm-12 col" id="'+prefixIdCol+counterIdCol+'">' +
                            '<div class="jumbotron blocEdit">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>'
                        counterIdCol++;
                        html += '<div class="col-lg-9 col-md-9 col-sm-12 col" id="'+prefixIdCol+counterIdCol+'">' +
                            '<div class="jumbotron blocEdit">' +
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
                        '<div class="col-lg-9 col-md-9 col-sm-12 col" id="'+prefixIdCol+counterIdCol+'">' +
                            '<div class="jumbotron blocEdit">' +
                            '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                        '   </div>' +
                        '</div>'
                        counterIdCol++;
                        html += '<div class="col-lg-3 col-md-3 col-sm-12 col" id="'+prefixIdCol+counterIdCol+'">' +
                            '<div class="jumbotron blocEdit">' +
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

        for (var i = 0; i < 12; i += col) {

            html += '<div class="col-lg-' + col + ' col-md-' + col + ' col-sm-12 col" id="'+prefixIdCol+counterIdCol+'">' +
                '<div class="jumbotron blocEdit">' +
                    '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                '</div>' +
            '</div>';
            counterIdCol++;
        }

        html += '</div>' +
            '</section>';
        counterIdBlock++;
    }

    $('#createBloc').before(html);
}