function showModalDeleteClient(id){
    $("#buttonDeleteClient").attr("href", "/admin/suppression-client?id="+id);
    $("#modalDeleteClient").show();
}

function hideModalDeleteClient(){
    $("#modalDeleteClient").hide();
}