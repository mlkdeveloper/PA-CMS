<?php
$aut = new \App\Controller\Auth();
session_start();
if (!$aut->isConnected()){
    //header('location:/connexion');
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

        <link rel="stylesheet" href="<?= $file_stylesheet??"" ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

        <link rel="stylesheet" href="../../dist/main.css">
        <link rel="stylesheet" href="../../public/css/back.css">
        <link rel="stylesheet" href="../../public/css/navbarFront.css">


        <?php  if(isset($stylesheet) && !empty($stylesheet))
            echo "<link rel='stylesheet' href='../../public/css/$stylesheet.css'>";
        ?>
    </head>

    <body>

    <div id="containerLoader">
        <div id="loadingPage">
            <div class="spinner"></div>
        </div>
    </div>


        <nav class="sidenav" id="sidenav">
            <ul>
                <a href="/admin/dashboard"><li>Dashboard</li></a>
                <a href="#"><li>Commandes</li></a>
                <li id="dropdownProducts" class="dropdownMenu">Produits<i class="fa fa-caret-down"></i></li>
                <ul class="dropdown-container">
                    <a href="#"><li>Categories</li></a>
                    <a href="#"><li>Promotions</li></a>
                </ul>
                    <a href="#"><li>Pages</li></a>
                    <a href="/admin/liste-client"><li>Clients</li></a>
                    <a href="#"><li>Avis</li></a>
                </ul>
            </ul>
            <ul>
                <hr>
                <li class="dropdownMenu" id="dropdownSettings">Paramètres du site<i class="fa fa-caret-down"></i></li>
                <ul class="dropdown-container">
                    <a href="/admin/liste-magasin"><li>Magasins</li></a>
                    <a href="#"><li>Navigation</li></a>
                    <a href="#"><li>Paramètres</li></a>
                </ul>
                <a href="#"><li>Paramètres du CMS</li></a>
            </ul>
        </nav>


        <div class="container-body">
            <header>
                <div class="headerBack">
                    <span id="hamburger">
                        <i class="fas fa-bars"></i>
                    </span>
                    <h1>Header</h1>
                    <button onclick="location.href='/deconnexion';" class="button button--blue">Déconnexion</button>
                </div>
            </header>

            <main>
                <!-- afficher la vue -->
                <?php include $this->view ?>

            </main>
        </div>
        <script src="../../public/js/back.js"></script>
    </body>
</html>