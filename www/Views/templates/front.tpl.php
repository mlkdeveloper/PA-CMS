<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Template de front</title>
	<meta name="description" content="description de la page de front">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <div class="sidenav">
        <a href="#about">Dashboard</a>
        <a href="#services">Commandes</a>
        <a class="dropdown-btn">Produit
            <i class="fa fa-caret-down"></i>
        </a>
        <div class="dropdown-container">
            <a href="#">Categories</a>
            <a href="#">Promotions</a>
            <a href="#">Link 3</a>
        </div>
        <a href="#contact">Contact</a>
    </div>
</header>

	<!-- afficher la vue -->
	<?php include $this->view ?>



</body>
<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
</html>