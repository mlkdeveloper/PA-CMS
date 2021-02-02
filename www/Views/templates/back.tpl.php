<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="description" content="description de la page de back">
    <link rel="stylesheet" href="../../dist/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
</head>
<body>

<nav class="sidenav">
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Commandes</a></li>
        <li><a href="#">Produits</a></li>
        <li><a href="#">Pages</a></li>
        <li><a href="#">Clients</a></li>
        <li><a href="#">Avis</a></li>
    </ul>
    <ul>
        <hr>
        <li><a href="#">Paramètres du site</a></li>
        <li><a href="#">Paramètres du CMS</a></li>
    </ul>
</nav>

<div class="container-body">

    <header>
        <div class="headerBack">
            <h1>Header</h1>
            <button class="button button--blue">Deconnexion</button>
        </div>

    </header>
<!-- afficher la vue -->
<?php include $this->view ?>

</div>
</body>
</html>