<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <?php
                    if(isset($_SESSION['errorSettings'])){
                        echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['errorSettings'].'</h4></div>';
                        unset($_SESSION['errorSettings']);
                    }

                    if(isset($_SESSION['successSettings'])){
                        echo '<div class="alert alert--green errorMessageImage"><h4>'.$_SESSION['successSettings'].'</h4></div>';
                        unset($_SESSION['successSettings']);
                    }
                    ?>
                    <form method="POST" action="/admin/update-settings">

                        <div class="row">
                            <h4 class="center-margin mb-5 mt-5">Configuration SMTP</h4>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="smtp_mail">Adresse mail:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="email" id="smtp_mail" name="smtp_mail" required
                                       value="<?php echo isset($_SESSION["dataSettings"][0]) ? $_SESSION["dataSettings"][0] : SMTPMAIL ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="smtp_password">Mot de passe du mail:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="text" id="smtp_password" name="smtp_password" required
                                       value="<?php echo isset($_SESSION["dataSettings"][1]) ? $_SESSION["dataSettings"][1] : SMTPPWD ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="smtp_host">Host:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="text" id="smtp_host" name="smtp_host" required
                                       placeholder="smtp.gmail.com"
                                       value="<?php echo isset($_SESSION["dataSettings"][2]) ? $_SESSION["dataSettings"][2] : SMTPHOST ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="smtp_auth">Authentification SMTP </label>
                                <select style="width: 250px; margin-bottom: 40px" class="input" id="smtp_auth" name="smtp_auth">
                                    <option value="true">Oui</option>
                                    <option value="false">Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="smtp_port">Port SMTP:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="text" id="smtp_port" name="smtp_port" required
                                       placeholder="587"
                                       value="<?php echo isset($_SESSION["dataSettings"][4]) ? $_SESSION["dataSettings"][4] : SMTPPORT ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="smtp_encrypt">Type de chiffrement:</label>
                                <select style="width: 250px; margin-bottom: 40px" class="input" id="smtp_encrypt" name="smtp_encrypt">
                                    <option value="tls">TLS</option>
                                    <option value="none">Aucun</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <h4 class="center-margin mb-5 mt-5">Configuration Stripe</h4>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="public_key">Clé publique:</label>
                                <textarea style="width: 250px; margin-bottom: 40px" name="public_key" class="input"
                                          required><?php echo isset($_SESSION["dataSettings"][6]) ? $_SESSION["dataSettings"][6] : PUBLICKEYSTRIPE ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="private_key">Clé privée:</label>
                                <textarea style="width: 250px; margin-bottom: 40px" name="private_key" class="input"
                                          required><?php echo isset($_SESSION["dataSettings"][7]) ? $_SESSION["dataSettings"][7] : PRIVATEKEYSTRIPE ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="center-margin">
                                <input type="submit" value="Mettre à jour" class="button button--blue"
                                       id="button_install">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <div class="row">
                        <h4 class="center-margin mb-5 mt-5">Informations de l'administrateur</h4>
                    </div>

                    <form method="POST" action="/admin/update-admin-email">

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="admin_mail">Adresse mail:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="email" id="admin_mail" name="admin_mail" required value="<?php echo $email ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="center-margin">
                                <input style="margin-bottom: 40px" type="submit" value="Mettre à jour" class="button button--blue"
                                       id="button_install">
                            </div>
                        </div>
                    </form>

                    <form method="POST" action="/admin/update-admin-password">
                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="old_pwd">Ancien mot de passe:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="password" id="old_pwd" name="old_pwd" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="new_pwd">Nouveau mot de passe:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="password" id="new_pwd" name="new_pwd" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="new_pwd_confirm">Confirmation du mot de passe:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="password" id="new_pwd_confirm" name="new_pwd_confirm" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="center-margin">
                                <input type="submit" value="Mettre à jour" class="button button--blue"
                                       id="button_install">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
unset($_SESSION['dataSettings']);
?>