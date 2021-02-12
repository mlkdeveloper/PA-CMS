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
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col center-margin">
                    <div class="jumbotron" id="selectCol">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col">
                                <img src="../../src/img/col-12.svg" alt="col-12">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col">
                                <img src="../../src/img/col-6.svg" alt="col-6">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col">
                                <img src="../../src/img/col-4.svg" alt="col-4">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col">
                                <img src="../../src/img/col-3.svg" alt="col-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col">
                                <img src="../../src/img/col-3-9.svg" alt="col-3-9">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col">
                                <img src="../../src/img/col-9-3.svg" alt="col-9-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../../public/js/dropdowns.js"></script>
</body>
</html>