<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <h3 id="titleInstall">Bienvenue dans l’installation de Click & Create !<br><br>
                    Vous n’avez qu’à remplir les informations demandées ci-dessous et vous serez prêt à utiliser Click &
                    Create.
                </h3>

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
                            <input class="input" type="text" id="name_bdd" name="name_bdd" required value="<?php echo isset($_SESSION["dataInstall"][0])?$_SESSION["dataInstall"][0]:"clickCreate" ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="user_bdd">Identifiant:</label>
                            <input class="input" type="text" id="user_bdd" name="user_bdd" required value="<?php echo isset($_SESSION["dataInstall"][1])?$_SESSION["dataInstall"][1]:"clickcreate" ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="pwd_bdd">Mot de passe:</label>
                            <input class="input" type="text" id="pwd_bdd" name="pwd_bdd" value="<?php echo isset($_SESSION["dataInstall"][2])?$_SESSION["dataInstall"][2]:"5T8rZ!iIHJV7" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="address_bdd">Adresse de la base de données:</label>
                            <input class="input" type="text" id="address_bdd" name="address_bdd" required value="<?php echo isset($_SESSION["dataInstall"][3])?$_SESSION["dataInstall"][3]:"localhost" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="port_bdd">Port:</label>
                            <input class="input" type="text" id="port_bdd" name="port_bdd" required value="<?php echo isset($_SESSION["dataInstall"][4])?$_SESSION["dataInstall"][4]:"3306" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="prefix_bdd">Préfixe des tables:</label>
                            <input class="input" type="text" id="prefix_bdd" name="prefix_bdd" required value="<?php echo isset($_SESSION["dataInstall"][5])?$_SESSION["dataInstall"][5]:"cc_" ?>">
                        </div>
                    </div>

                    <h4 class="center-margin mb-5 mt-5">Configuration SMTP</h4>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="smtp_mail">Adresse mail:</label>
                            <input class="input" type="email" id="smtp_mail" name="smtp_mail" required value="<?php echo isset($_SESSION["dataInstall"][6])?$_SESSION["dataInstall"][6]:"click.create.collect@gmail.com" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="smtp_password">Mot de passe du mail:</label>
                            <input class="input" type="text" id="smtp_password" name="smtp_password" required value="<?php echo isset($_SESSION["dataInstall"][7])?$_SESSION["dataInstall"][7]:"tbagshqkxrsxknuq" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="smtp_host">Host:</label>
                            <input class="input" type="text" id="smtp_host" name="smtp_host" required placeholder="smtp.gmail.com" value="<?php echo isset($_SESSION["dataInstall"][8])?$_SESSION["dataInstall"][8]:"smtp.gmail.com" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="smtp_auth">Authentification SMTP </label>
                            <select class="input" id="smtp_auth" name="smtp_auth" value="<?php echo isset($_SESSION["dataInstall"][9])?$_SESSION["dataInstall"][9]:"" ?>">
                                <option value="true">Oui</option>
                                <option value="false">Non</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="smtp_port">Port SMTP:</label>
                            <input class="input" type="text" id="smtp_port" name="smtp_port" required placeholder="587" value="<?php echo isset($_SESSION["dataInstall"][10])?$_SESSION["dataInstall"][10]:"587" ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="smtp_encrypt">Type de chiffrement:</label>
                            <select class="input" id="smtp_encrypt" name="smtp_encrypt">
                                <option value="tls">TLS</option>
                                <option value="none">Aucun</option>
                            </select>
                        </div>
                    </div>

                    <h4 class="center-margin mb-5 mt-5">Configuration Stripe</h4>

                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="public_key">Clé publique:</label>
                            <textarea name="public_key" class="input" required><?php echo isset($_SESSION["dataInstall"][12])?$_SESSION["dataInstall"][12]:"pk_test_51JC0puGueu1Z1r2S3oq9aEovJmlKpYwQ8isyViEyKtwQrLXIEZBdOVeXiihXPpi4EtJHkTd53Whc5F6J7TNxLEQz00XaTk67k0" ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="form_align container-input">
                            <label for="private_key">Clé privée:</label>
                            <textarea name="private_key" class="input" required><?php echo isset($_SESSION["dataInstall"][13])?$_SESSION["dataInstall"][13]:"sk_test_51JC0puGueu1Z1r2SmxqKTcVKd7GHDBvZV0fPSbBI8GczQXd4y4bPAv5HgfMLJSy38vW6uyHwmN7bMrKUrIEw9sF400YiBrLMKe" ?></textarea>
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