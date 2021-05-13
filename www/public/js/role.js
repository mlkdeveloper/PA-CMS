function showModalDeleteRole(id){
    $("#buttonDeleteRole").attr("href", "/admin/suppression-role?id="+id);
    $("#modalDeleteRole").show();
}

function hideModalDeleteRole(){
    $("#modalDeleteRole").hide();
}