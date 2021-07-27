var htmlPage = "";

$.ajax({
    type: 'POST',
    url: '/admin/read-frontpage',
    data: {jsonPage: $("#namePage").val()},
    success: function(data) {
        if (data) {
            read(data);
        }else{
            document.location.replace("/");
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

        htmlPage += '<section class="container">' +
            '<div class="row">';

        $.each($(this)[0]["columns"], function () {
            htmlPage += '<div class="col-lg-'+$(this)[0]["numberCol"]+' col-md-'+$(this)[0]["numberCol"]+' col-sm-12 col colBlock" style="'+$(this)[0]["css"]+'">';
                htmlPage += $(this)[0]["content"];
            htmlPage += '</div>';
        });

        htmlPage += '</div>' +
            '</section>';
    });
    $("#containerPage").html(htmlPage);

    setTimeout(function (){
        $("#containerLoader").fadeOut(700);
    }, 500);
}