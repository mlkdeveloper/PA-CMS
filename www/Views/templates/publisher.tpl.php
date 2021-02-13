<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <meta name="description" content="description de la page de back">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="../../src/js/jquery-3.5.1.min.js"></script>
        <script src="../../public/js/publisher/publisher.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="../../dist/main.css">
    </head>

    <body id="bodyPublisher">
        <aside>
            <nav class="sidenavPublisher">

            </nav>
        </aside>

        <div class="container-body">
            <header>
                <div class="headerNavbar">
                    <h1>La navbar</h1>
                </div>
            </header>

            <main>

                <?php include $this->view ?>

                <section class="container" id="createBloc">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col center-margin">
                            <div class="jumbotron blocEdit" id="selectCol">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-12.svg" alt="col-12" onclick="addBloc(12)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-6.svg" alt="col-6" onclick="addBloc(6)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-4.svg" alt="col-4" onclick="addBloc(4)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-3.svg" alt="col-3" onclick="addBloc(3)">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-3-9.svg" alt="col-3-9" onclick="addBloc(39)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-9-3.svg" alt="col-9-3" onclick="addBloc(93)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>