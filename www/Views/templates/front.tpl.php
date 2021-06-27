<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
    <title><?= $title ?></title>
	<meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/main.css">
    <script src="../../src/js/jquery-3.5.1.min.js"></script>
</head>
<body>
    <main>

        <div class="" style="display: flex; justify-content: space-between;background-color: #2D9CDB; padding: 1rem; align-items: center">
            <img src="" alt="Logo">
            <a href="#"><p>Panier <i class="fa fa-shopping-cart"></i></p></a>
        </div>

        <!-- afficher la vue -->
        <?php include $this->view ?>

    </main>



</body>

</html>