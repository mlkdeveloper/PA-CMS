function addBloc(col) {
    var html = '<section class="container">' +
        '<div class="row">';

    if (col > 12) {
        switch (col){
            case 39:
                html += '<div class="col-lg-3 col-md-3 col-sm-12 col">' +
                        '<div class="jumbotron blocEdit">' +
                            '<h1>Test</h1>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-lg-9 col-md-9 col-sm-12 col">' +
                        '<div class="jumbotron blocEdit">' +
                            '<h1>Test</h1>' +
                        '</div>' +
                    '</div>';
                break;
            case 93:
                html += '<div class="col-lg-9 col-md-9 col-sm-12 col">' +
                        '<div class="jumbotron blocEdit">' +
                            '<h1>Test</h1>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-lg-3 col-md-3 col-sm-12 col">' +
                        '<div class="jumbotron blocEdit">' +
                            '<h1>Test</h1>' +
                        '</div>' +
                    '</div>';
                break;
        }
    } else {

        for (var i = 0; i < 12; i += col) {
            html += '<div class="col-lg-' + col + ' col-md-' + col + ' col-sm-12 col">' +
                    '<div class="jumbotron blocEdit">' +
                        '<h1>Test</h1>' +
                    '</div>' +
                '</div>';
        }

    }

    html += '</div>' +
        '</section>';

    $('#createBloc').before(html);
}