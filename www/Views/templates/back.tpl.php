<?php
$aut = new \App\Controller\Auth();
session_start();
if (!$aut->isConnected()){
    header('location:/connexion');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="description" content="description de la page de back">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../src/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../../dist/main.css">

    <?php  if(isset($stylesheet) && !empty($stylesheet))
        echo "<link rel='stylesheet' href='../../public/css/$stylesheet.css'>";
    ?>

</head>
<body>

<nav class="sidenav">
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Commandes</a></li>
        <a class="dropdown-btn">Produit<i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-container">
            <li><a href="#">Categories</a>
            <li><a href="#">Promotions</a>
            <li><a href="#">Link 3</a>
        </ul>
        <li><a href="#">Pages</a></li>
        <li><a href="#">Clients</a></li>
        <li><a href="#">Avis</a></li>
    </ul>
    <ul>
        <hr>
        <a class="dropdown-btn">Paramètres du site<i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-container">
            <li><a href="/admin/liste-magasin">Magasin</a>
            <li><a href="#">Theme</a>
            <li><a href="#">Navigation</a>
        </ul>
        <li><a href="#">Paramètres du CMS</a></li>
    </ul>
</nav>

<div class="container-body">
    <header>
        <div class="headerBack">
            <h1>Header</h1>
            <button onclick="location.href='/deconnexion';" class="button button--blue">Déconnexion</button>
        </div>
    </header>

    <main>
        <!-- afficher la vue -->
        <?php include $this->view ?>

    </main>
</div>
<script src="../../public/js/dropdowns.js"></script>
</body>
</html>