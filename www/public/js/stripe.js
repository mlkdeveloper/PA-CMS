function showModalConnexionStripe(){
    $("#buttonConnexionStripe").attr("href", "/connexion?reason=stripe");
    $("#modalConnexionStripe").show();
}
function hideModalConnexionStripe(){
    $("#modalConnexionStripe").hide();
}