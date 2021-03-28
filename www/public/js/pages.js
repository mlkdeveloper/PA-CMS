let check = false;

$(document).ready(function(){
    $("#name").on("keyup paste change", function (){
        if (!check){
            $("#slug").val("/"+this.value.toLowerCase());
        }
    });

    $("#slug").on("keyup paste change", function (){
        check = true;
    });
});