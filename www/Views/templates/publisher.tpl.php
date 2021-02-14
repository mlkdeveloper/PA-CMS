<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <meta name="description" content="description de la page de back">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="../../src/js/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.tiny.cloud/1/hhyltwzrx7o3enydpiz3vfnppsdw0hg6iyjr8ruqxp8gfq9i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="../../public/js/publisher/publisher.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="../../dist/main.css">
    </head>

    <body id="bodyPublisher">
        <main>
            <aside>
                <nav class="sidenavPublisher">
                    <div class="row align" id="headerMenu">
                        <div class="col-lg-6 col-md-6 col-sm-12 col">
                            <a href="/admin/pages"><button class="button button--blue">Retour</button></a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col">
                            <img src="../.././images/hamburger.svg" alt="hamburger" id="hamburger">
                        </div>
                    </div>

                    <div id="menuObject">
                        <div class="row align">
                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <img src="../.././images/publisher/icon-image.svg" alt="icon-image">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <img src="../.././images/publisher/icon-list.svg" alt="icon-list">
                            </div>
                        </div>
                        <div class="row align">
                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <img src="../.././images/publisher/icon-text.svg" alt="icon-text" id="icon-text">
                            </div>
                        </div>
                    </div>
                </nav>
            </aside>

            <div class="container-body">
                <header>
                    <div class="headerNavbar">
                        <h1>La navbar</h1>
                    </div>
                </header>

                <div id="containerPublisher"></div>
                <?php include $this->view ?>

                <section class="container" id="createBloc">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col center-margin">
                            <div class="jumbotron containerJumbo" id="selectCol">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-12.svg" alt="col-12" onclick="addBlock(12)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-6.svg" alt="col-6" onclick="addBlock(6)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-4.svg" alt="col-4" onclick="addBlock(4)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-3.svg" alt="col-3" onclick="addBlock(3)">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-3-9.svg" alt="col-3-9" onclick="addBlock(39)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <img src="../../images/publisher/col-9-3.svg" alt="col-9-3" onclick="addBlock(93)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div id="modal">
                    <div id="modal-content"></div>
                </div>

            </div>
        </main>
    </body>
</html>