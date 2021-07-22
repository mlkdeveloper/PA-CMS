$(document).ready(function() {
    $("#hamburger").on("click", function () {
        navbar();
    });
});

function navbar(){
    if ($("#main-nav").css("left") !== "0px"){
        $('#main-nav').animate({
            left: 0
        });
    }else{
        $('#main-nav').animate({
            left: "-100%"
        });
    }
}