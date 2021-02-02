var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "flex") {
            dropdownContent.style.display = "none";
            $("nav ul a i").css({
                    transform: "rotate(0deg)"
            })
        } else {
            dropdownContent.style.display = "flex";
            $("nav ul a i").css({
                transform: "rotate(180deg)"
            })
        }
    });
}
