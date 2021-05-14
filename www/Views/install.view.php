<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <h4 id="titleInstall">Bienvenue dans l’installation de Click & Create !<br><br>
                    Vous n’avez qu’à remplir les informations demandées ci-dessous et vous serez prêt à utiliser Click &
                    Create.
                </h4>

                <?php
                if(isset($_SESSION['securityInstall'])){
                    echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['securityInstall'].'</h4></div>';
                    unset($_SESSION['securityInstall']);
                }
                ?>

                <form class="form" method="POST" action="/start-install">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="name_bdd">Nom de la base de données:</label>
                            <input class="input" type="text" id="name_bdd" name="name_bdd" value="<?php echo isset($_SESSION["dataInstall"][0])?$_SESSION["dataInstall"][0]:"" ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="user_bdd">Identidiant:</label>
                            <input class="input" type="text" id="user_bdd" name="user_bdd" value="<?php echo isset($_SESSION["dataInstall"][1])?$_SESSION["dataInstall"][1]:"" ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="pwd_bdd">Mot de passe:</label>
                            <input class="input" type="text" id="pwd_bdd" name="pwd_bdd" value="<?php echo isset($_SESSION["dataInstall"][2])?$_SESSION["dataInstall"][2]:"" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="address_bdd">Adresse de la base de données:</label>
                            <input class="input" type="text" id="address_bdd" name="address_bdd" value="<?php echo isset($_SESSION["dataInstall"][3])?$_SESSION["dataInstall"][3]:"localhost" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="port_bdd">Port:</label>
                            <input class="input" type="text" id="port_bdd" name="port_bdd" value="<?php echo isset($_SESSION["dataInstall"][4])?$_SESSION["dataInstall"][4]:"3306" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="prefix_bdd">Préfixe des tables:</label>
                            <input class="input" type="text" id="prefix_bdd" name="prefix_bdd" value="<?php echo isset($_SESSION["dataInstall"][5])?$_SESSION["dataInstall"][5]:"cc_" ?>">
                        </div>
                    </div>
                    <input type="submit" value="Installer" class="button button--blue" id="button_install">
                </form>
            </div>
        </div>
    </div>
</div


<?php
    unset($_SESSION['dataInstall']);
?>