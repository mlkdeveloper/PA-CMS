function showModalCancelCommand(id){
    $("#buttonCancelCommand").attr("href", "/admin/annuler-commande?id="+id);
    $("#modalCancelCommand").show();
}
function showModalValidCommand(id){
    $("#buttonValidCommand").attr("href", "/admin/valider-commande?id="+id);
    $("#modalValidCommand").show();
}
function hideModalValidCommand(){
    $("#modalValidCommand").hide();
}
function hideModalCancelCommand(){
    $("#modalCancelCommand").hide();
}


function showModalDoneCommand(id){
    $("#buttonDoneCommand").attr("href", "/admin/terminer-commande?id="+id);
    $("#modalDoneCommand").show();
}
function hideModalDoneCommand(){
    $("#modalDoneCommand").hide();
}