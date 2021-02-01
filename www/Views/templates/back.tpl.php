<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Template de back</title>
	<meta name="description" content="description de la page de back">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header>
        <div class="headerBack">
            <p></p>
            <h1>Header</h1>
            <button class="button button--blue">Deconnexion</button>
        </div>

    </header>
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
	<!-- afficher la vue -->
	<?php include $this->view ?>

</body>
</html>