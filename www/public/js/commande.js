function showModalCancelCommand(id){
    $("#buttonCancelCommand").attr("href", "/admin/annuler-commande?id="+id);
    $("#modalCancelCommand").show();
}
function hideModalCancelCommand(){
    $("#modalCancelCommand").hide();
}


