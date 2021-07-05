$(document).ready(function() {
    $("#dropdownProducts").on("click", function () {
        startDropdown(this);
    });

    $("#dropdownSettings").on("click", function () {
        startDropdown(this);
    });
});


function startDropdown(dropDown){
    dropDown.classList.toggle("active");
    var dropdownContent = dropDown.nextElementSibling;
    if (dropdownContent.style.display === "flex") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "flex";
    }
}
