<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
    <title><?= $title ?></title>
	<meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../src/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="../../dist/pageFronts.css">
</head>
<body>

    <header>
        <nav id="navbarFront">
            <div>
                <ul>
                    <li><img src="../../images/logo/logo.png" alt="Logo" width="50"></li>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Catégories</a></li>
                    <li><a href="#">À Propos de Moi</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <ul>
                    <li><a href="/panier">Panier <i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>


    <main>



	<!-- afficher la vue -->
	<?php include $this->view ?>

    </main>



</body>

</html>