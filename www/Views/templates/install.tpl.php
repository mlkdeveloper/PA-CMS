<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/main.css">
    <link rel="stylesheet" href="../../dist/install.css">
</head>
<body>

    <main>
        <!-- afficher la vue -->
        <?php include $this->view ?>

    </main>

</body>

</html>