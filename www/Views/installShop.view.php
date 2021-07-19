<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <h2>Informations nécessaires du magasin</h2>
                <hr>

                <?php
                if(isset($_SESSION['securityInstall'])){
                    echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['securityInstall'].'</h4></div>';
                    unset($_SESSION['securityInstall']);
                }
                ?>

                <form class="form" method="POST" action="/start-install">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="name_shop">Nom du magasin :</label>
                            <input class="input" type="text" id="name_shop" name="name_shop" required value="<?php echo isset($_SESSION["dataInstall"][0])?$_SESSION["dataInstall"][0]:"" ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="address_shop">Adresse du magasin :</label>
                            <input class="input" type="text" id="address_shop" name="address_shop" required value="<?php echo isset($_SESSION["dataInstall"][1])?$_SESSION["dataInstall"][1]:"" ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="phone_shop">Téléphone :</label>
                            <input class="input" type="text" id="phone_shop" name="phone_shop" value="<?php echo isset($_SESSION["dataInstall"][2])?$_SESSION["dataInstall"][2]:"" ?>">
                        </div>
                    </div>

                    <input type="submit" value="Continuer" class="button button--blue" id="button_install">
                </form>
            </div>
        </div>
    </div>
</div>


<?php
unset($_SESSION['dataInstall']);
?>