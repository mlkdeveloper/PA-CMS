<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <form class="form" method="POST" action="/update-settings">

                        <h4 class="center-margin mb-5 mt-5">Configuration SMTP</h4>

                        <div class="col-lg-12 col-md-12 col-sm-12 col">
                            <div class="form_align--top container-input">
                                <label for="smtp_mail">Adresse mail:</label>
                                <input class="input" type="email" id="smtp_mail" name="smtp_mail" required value="<?php echo isset($_SESSION["dataInstall"][6])?$_SESSION["dataInstall"][6]:"" ?>">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col">
                            <div class="form_align container-input">
                                <label for="smtp_password">Mot de passe du mail:</label>
                                <input class="input" type="text" id="smtp_password" name="smtp_password" required value="<?php echo isset($_SESSION["dataInstall"][7])?$_SESSION["dataInstall"][7]:"" ?>">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col">
                            <div class="form_align container-input">
                                <label for="smtp_host">Host:</label>
                                <input class="input" type="text" id="smtp_host" name="smtp_host" required placeholder="smtp.gmail.com" value="<?php echo isset($_SESSION["dataInstall"][8])?$_SESSION["dataInstall"][8]:"" ?>">
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
                                <input class="input" type="text" id="smtp_port" name="smtp_port" required placeholder="587" value="<?php echo isset($_SESSION["dataInstall"][10])?$_SESSION["dataInstall"][10]:"" ?>">
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
                                <textarea name="public_key" class="input" required><?php echo isset($_SESSION["dataInstall"][12])?$_SESSION["dataInstall"][12]:"" ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col">
                            <div class="form_align container-input">
                                <label for="private_key">Clé privée:</label>
                                <textarea name="private_key" class="input" required><?php echo isset($_SESSION["dataInstall"][13])?$_SESSION["dataInstall"][13]:"" ?></textarea>
                            </div>
                        </div>

                            <div class="center-margin">
                                <input type="submit" value="Mettre à jour" class="button button--blue" id="button_install">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>