let check = false;

$(document).ready(function(){
    $("#name").on("keyup paste change", function (){ //Création automatique du slug
        if (!check){
            $("#slug").val("/"+this.value.toLowerCase().replaceAll(" ", "_"));
        }
    });

    $("#slug").on("keyup paste change", function (){ //Désactivation de la création automatique du slug
        check = true;
    });

    $("#publicationSwitch").on("click", function (){ //Publication de la page
        var idPage;
        var valuePublication;

        if ($("#publicationSwitch").is(":checked"))
        {
            idPage = $("#publicationSwitch").attr("name");
            valuePublication = 1;
        }else{
            idPage = $("#publicationSwitch").attr("name");
            valuePublication = 0;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/update-publication',
            data: {
                idPage: idPage,
                valuePublication: valuePublication
            },
            success: function(data) {
            },
            error: function (xhr, ajaxOptions, thrownError){
                alert(xhr.responseText);
                alert(ajaxOptions);
                alert(thrownError);
                alert(xhr.status);
            }
        });
    });
});

//Modal de suppression de la page

function showModalDeletePage(id, name, slug){
    $("#buttonDeletPage").attr("href", "/admin/delete-page?idPage="+id+"&name="+name+"&slug="+slug);
    $("#modalDeletePage").show();
}

function hideModalDeletePage(){
    $("#modalDeletePage").hide();
}

