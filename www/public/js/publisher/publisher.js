let counterId = 1;
const prefixId = "block_";
let html;

function addBloc(col) {

    if (col > 12) {
        switch (col){

            case 39:
                html = '<section class="container" id="'+prefixId+counterId+'">' +
                    '<div class="row">' +
                        '<div class="col-lg-3 col-md-3 col-sm-12 col">' +
                            '<div class="jumbotron blocEdit">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>'
                        html += '<div class="col-lg-9 col-md-9 col-sm-12 col">' +
                            '<div class="jumbotron blocEdit">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>';
                    html +='</div>' +
                '</section>';
                counterId++;
                break;
            case 93:
                html = '<section class="container" id="'+prefixId+counterId+'">' +
                    '<div class="row">' +
                        '<div class="col-lg-9 col-md-9 col-sm-12 col">' +
                            '<div class="jumbotron blocEdit">' +
                            '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                        '   </div>' +
                        '</div>'
                        html += '<div class="col-lg-3 col-md-3 col-sm-12 col">' +
                            '<div class="jumbotron blocEdit">' +
                                '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                            '</div>' +
                        '</div>';
                    html += '</div>' +
                '</section>';
                counterId++;
                break;
        }

    } else {

        html = '<section class="container" id="'+prefixId+counterId+'">' +
            '<div class="row">';

        for (var i = 0; i < 12; i += col) {

            html += '<div class="col-lg-' + col + ' col-md-' + col + ' col-sm-12 col">' +
                '<div class="jumbotron blocEdit">' +
                    '<img src="../../../images/cross-add.svg" class="cross-add" alt="cross-add">' +
                '</div>' +
            '</div>';
        }

        html += '</div>' +
            '</section>';
        counterId++;
    }

    $('#createBloc').before(html);
}