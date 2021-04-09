let check = false;

$(document).ready(function(){
    $("#name").on("keyup paste change", function (){
        if (!check){
            $("#slug").val("/"+this.value.toLowerCase().replaceAll(" ", "_"));
        }
    });

    $("#slug").on("keyup paste change", function (){
        check = true;
    });
});

function showModalDeletePage(id, name){
    $("#buttonDeletPage").attr("href", "/admin/delete-page?idPage="+id+"&name="+name)
    $("#modalDeletePage").show();
}

function hideModalDeletePage(){
    $("#modalDeletePage").hide();
}

