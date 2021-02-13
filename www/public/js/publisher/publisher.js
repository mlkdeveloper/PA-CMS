function addBloc(col){
    console.log(col);
    if (col > 12){

    }else{
        var html = '<section class="container">' +
            '<div class="row">';
                for (var i = 0; i < 12; i+=col){
                    html += '<div class="col-lg-'+col+' col-md-'+col+' col-sm-12 col center-margin">' +
                        '<div class="jumbotron blocEdit">' +
                            '<h1>Test</h1>' +
                        '</div>' +
                    '</div>';
                }
            html += '</div>' +
        '</section>';

        $('#createBloc').before(html);
    }
}