<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="description" content="description de la page de back">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../../src/js/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../../dist/main.css">
</head>
<body id="bodyPublisher">

<nav class="sidenavPublisher">

</nav>

<div class="container-body">
    <header>
        <div class="headerNavbar">
            <h1>La navbar</h1>
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