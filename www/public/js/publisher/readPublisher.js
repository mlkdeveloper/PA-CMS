let htmlPage = "";

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