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
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="<?= $file_stylesheet??"" ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">



</head>
<body>
    <main>

        <div class="" style="background-color:#ffffff;display: flex; justify-content: space-between;border-bottom: 1px solid #2D9CDB; padding: 1rem; align-items: center">
            <img src="../../images/logo/logo.png" alt="Logo" width="50">
            <a href="/panier"><p>Panier <i class="fa fa-shopping-cart"></i></p></a>
        </div>

        <!-- afficher la vue -->
        <?php include $this->view ?>

    </main>



</body>

</html>