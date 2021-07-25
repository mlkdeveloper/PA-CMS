<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <meta name="description" content="editeur du site">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="../../public/js/jquery-3.5.1.min.js"></script>
        <script src="../../public/tinymce/tinymce.min.js"></script>
        <script src="../../public/js/publisher/publisher.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="../../dist/main.css">
        <link rel="stylesheet" href="../../dist/publisher.css">
    </head>

    <body id="bodyPublisher">
        <div id="containerLoader">
            <div id="loadingPage">
                <div class="spinner"></div>
            </div>
        </div>

        <main>
            <aside>
                <img src="../.././images/hamburger.svg" alt="hamburger" id="btnShowMenu">

                <nav id="sidenavPublisher">
                    <div class="row align" id="headerMenu">
                        <div class="col-lg-6 col-md-6 col-sm-12 col">
                            <button class="button button--blue" id="buttonBack">Retour</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col">
                            <img src="../.././images/hamburger.svg" alt="hamburger" id="btnHideMenu">
                        </div>
                    </div>

                    <div id="menuObject">
                        <div class="row align objectMenuHide">
                            <div class="col-lg-12 col-md-12 col-sm-12 col" id="icon-edit">
                                <img src="../.././images/publisher/icon-edit.svg" alt="icon-edit">
                                <span>Editer</span>
                            </div>
                        </div>
                        <div class="row align">
                            <div class="col-lg-12 col-md-12 col-sm-12 col" id="icon-image">
                                <img src="../.././images/publisher/icon-image.svg" alt="icon-image">
                                <span>Gestionnaire<br>d'images</span>
                            </div>
                        </div>
                        <div class="row align objectMenuHide">
                            <div class="col-lg-12 col-md-12 col-sm-12 col" id="icon-arrow-up">
                                <img src="../../images/publisher/icon-arrow-down.svg" alt="icon-arrow-up">
                            </div>
                        </div>
                        <div class="row align objectMenuHide">
                            <div class="col-lg-12 col-md-12 col-sm-12 col" id="icon-arrow-down">
                                <img src="../../images/publisher/icon-arrow-up.svg" alt="icon-arrow-down">
                            </div>
                        </div>
                        <div class="row align objectMenuHide">
                            <button class="button button--blue" id="paramBloc">Paramètres du bloc</button>
                        </div>

                        <div id="containerDeleteSection" class="objectMenuHide">
                            <img src="../.././images/publisher/icon-trash.svg" alt="icon-trash">
                            <span>Supprimer la section</span>
                        </div>
                    </div>
                </nav>
            </aside>

            <div class="container-body" id="bodyContainer">
                <header>
                    <div class="headerNavbar">
                        <h3>Barre de navigation</h3>
                    </div>
                </header>

                <div id="containerPublisher"></div>

                <section class="container" id="createBloc">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col center-margin">
                            <div class="jumbotron containerJumbo" id="selectCol">
                                <h3>Sélectionnez le modèle de la section</h3>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-12 col">
                                        <img src="../../images/publisher/col-12.svg" alt="col-12" onclick="addBlock(12)">
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 col">
                                        <img src="../../images/publisher/col-6.svg" alt="col-6" onclick="addBlock(6)">
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 col">
                                        <img src="../../images/publisher/col-4.svg" alt="col-4" onclick="addBlock(4)">
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 col">
                                        <img src="../../images/publisher/col-3.svg" alt="col-3" onclick="addBlock(3)">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col">
                                        <img src="../../images/publisher/col-3-9.svg" alt="col-3-9" onclick="addBlock(39)">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col">
                                        <img src="../../images/publisher/col-9-3.svg" alt="col-9-3" onclick="addBlock(93)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div id="containerSave">
                    <div class="spinner" id="loader"></div>

                    <div id="alertSave">
                        <p>Enregistrement réussi !</p>
                    </div>

                    <button id="buttonSave" class="button button--success">Enregistrer</button>
                </div>

                <div class="modal" id="modalTiny">
                    <div class="modal-content">
                        <form method="post" class="center-margin" id="formTiny">
                            <textarea id="tiny" name="tiny"></textarea>
                        </form>

                        <h4 id="alertMessage"></h4>

                        <div class="buttonModal">
                            <button onclick="closeModal()" class="button button--alert">Annuler</button>
                            <button class="button button--success" id="buttonModalTiny">Valider</button>
                        </div>
                    </div>
                </div>

                <div class="modal" id="modalImages">
                    <div class="modal-content" id="contentModalImage">
                        <div class="buttonModalImage">
                            <div>
                                <button class="button button--success" onclick="addImage()">Ajouter</button>
                                <button class="button button--blue" onclick="inputUpload()">Transférer</button>
                                <button class="button button--warning" onclick="confirmDeleteImage()">Supprimer</button>
                                <button class="button button--alert" onclick="closeModalImages()" >Fermer</button>
                            </div>
                        </div>
                        <div id="selectImage">
                            <div id="listImages"></div>
                        </div>
                        <div id="confirmDeleteImage">
                            <h4>Etes-vous sûr de vouloir supprimer cette image du serveur ?</h4>
                            <div class="buttonModal">
                                <button onclick='closeModalConfirmImages()' class='button button--alert'>Non</button>
                                <button class='button button--success' onclick='deleteImage()' id='successModalImages'>Oui</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" id="modalparamBloc">
                    <div class="modal-content">
                        <div id="containerParamBloc">
                            <div id="paramImage">

                                <h3>Modification de l'image</h3>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col">
                                        <label class="label" for="widthImage">Largeur en %</label>
                                        <br>
                                        <input type="number" class="input" id="widthImage" max="100" min="0">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col">
                                        <label class="label" for="heightImage">Hauteur en %</label>
                                        <br>
                                        <input type="number" class="input" id="heightImage" max="100" min="0">
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div>
                                <h3>Paramètres du bloc</h3>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                                        <label class="label" for="checkBackgroud">Couleur de fond</label>
                                        <input type="checkbox" id="checkBackgroud">
                                        <br>
                                        <input type="color" id="backgroundBloc">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <label class="label" for="paddingLeft">Padding de gauche en px</label>
                                        <br>
                                        <input type="number" class="input" id="paddingLeft" min="0">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <label class="label" for="paddingRight">Padding de droite en px</label>
                                        <br>
                                        <input type="number" class="input" id="paddingRight" min="0">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <label class="label" for="paddingTop">Padding du haut en px</label>
                                        <br>
                                        <input type="number" class="input" id="paddingTop" min="0">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col">
                                        <label class="label" for="paddingBottom">Padding du bas en px</label>
                                        <br>
                                        <input type="number" class="input" id="paddingBottom" min="0">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                                        <label class="label" for="radius">Arrondissement des angles en px</label>
                                        <br>
                                        <input type="number" class="input" id="radius" min="0">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                                        <label class="label" for="shadow">Ombre</label>
                                        <input type="checkbox" id="shadow"">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="buttonModal">
                            <button onclick="closeModalParamBloc()" class="button button--alert">Fermer</button>
                            <button onclick="saveParamBloc()" class="button button--success">Valider</button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </body>
</html>