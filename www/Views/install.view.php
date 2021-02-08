<?php
if(isset($_SESSION['securityInstall'])){
    echo '<h1>'.$_SESSION['securityInstall'].'</h1>';
    print_r( $_SESSION['dataInstall']);
    unset($_SESSION['securityInstall']);
}
?>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <h4>Bienvenue dans l’installation de Click & Create !
                    Vous n’avez qu’à remplir les informations demandées ci-dessous et vous serez prêt à utiliser Click &
                    Create.
                </h4>

                <form class="form" method="POST" action="/start-install">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="name_bdd">Nom de la base de données:</label>
                            <input class="input" type="text" id="name_bdd" name="name_bdd">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="user_bdd">Identidiant:</label>
                            <input class="input" type="text" id="user_bdd" name="user_bdd">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="pwd_bdd">Mot de passe:</label>
                            <input class="input" type="text" id="pwd_bdd" name="pwd_bdd">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="address_bdd">Adresse de la base de données:</label>
                            <input class="input" type="text" id="address_bdd" name="address_bdd" value="localhost">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="port_bdd">Port:</label>
                            <input class="input" type="text" id="port_bdd" name="port_bdd" value="3306">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="prefixe_bdd">Préfixe des tables:</label>
                            <input class="input" type="text" id="prefixe_bdd" name="prefixe_bdd" value="cc_">
                        </div>
                    </div>
                    <input type="submit" value="Installer" class="button button--blue" id="button_install">
                </form>
            </div>
        </div>
    </div>
</div
