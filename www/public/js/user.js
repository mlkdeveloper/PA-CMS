function showModalDeleteClient(id){
    $("#buttonDeleteClient").attr("href", "/admin/suppression-client?id="+id);
    $("#modalDeleteClient").show();
}

function hideModalDeleteClient(){
    $("#modalDeleteClient").hide();
}


function showModalDeleteUser(id){
    $("#buttonDeleteUser").attr("href", "/admin/suppression-utilisateur?id="+id);
    $("#modalDeleteUser").show();
}

function hideModalDeleteUser(){
    $("#modalDeleteUser").hide();
}



function showModalPwd(id){
    $("#modalPwd").show();
}

function hideModalPwd(){
    $("#modalPwd").hide();
}
