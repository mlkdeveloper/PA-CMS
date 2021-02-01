<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Template de back</title>
	<meta name="description" content="description de la page de back">
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
</html>