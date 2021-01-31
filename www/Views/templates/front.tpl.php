<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Template de front</title>
	<meta name="description" content="description de la page de front">
    <link rel="stylesheet" href="../../dist/main.css">
</head>
<body>
<header>
    <div class="sidenav">
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#clients">Clients</a>
        <a href="#contact">Contact</a>
    </div>
</header>

	<!-- afficher la vue -->
	<?php include $this->view ?>



</body>
</html>