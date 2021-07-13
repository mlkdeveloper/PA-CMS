<section>
    <div class="container">
        <?php if(isset($errors)):?>
            <div class="alert alert--red">
                <?php foreach ($errors as $error):?>
                    <li><?=$error?></li>
                <?php endforeach;?>
            </div>
        <?php endif;?>

        <?php if(isset($message)):?>
            <div class="alert alert--green"><?= $message?></div>
        <?php endif;?>

        <?php
        if(isset($_SESSION['errors'])){
            echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['errors'].'</h4></div>';
            unset($_SESSION['errors']);
        }

        if(isset($_SESSION['success'])){
            echo '<div class="alert alert--green errorMessageImage"><h4>'.$_SESSION['success'].'</h4></div>';
            unset($_SESSION['success']);
        }
        ?>

        <h1>Mes informations personnelles </h1>
    </div>
</section>
<section>

    <form method="POST">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class=" align  jumbotron form">
                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <div class="form_align form_align--top">
                                    <label class="label">Nom</label>
                                    <input class="input" type="text" name="lastName" placeholder="Nom" required="required" value="<?php if (isset($user)) echo $user['lastname']; ?>">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Prénom</label>
                                    <input class="input" type="text" name="firstName" placeholder="Prénom" required="required" value="<?php if (isset($user)) echo $user['firstname']; ?>">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Email</label>
                                    <input class="input" type="email" name="email" placeholder="Email"  required="required" value="<?php if (isset($user)) echo $user['email']; ?>" >
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Adresse</label>
                                    <input class="input" type="text" name="address" placeholder="Adresse"  required="required" value="<?php if (isset($user)) echo $user['address']; ?>" >
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col">

                                <div class="form_align form_align--top">
                                    <label class="label">Code postal</label>
                                    <input class="input" type="text" name="zipCode" placeholder="Code postal"  required="required" value="<?php if (isset($user)) echo $user['zipcode']; ?>">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Téléphone</label>
                                    <input class="input" type="text" name="phoneNumber" placeholder="Téléphone"  required="required" value="<?php if (isset($user)) echo $user['phoneNumber']; ?>">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Ville</label>
                                    <input class="input" type="text" name="city" placeholder="Ville"  required="required" value="<?php if (isset($user)) echo $user['city']; ?>">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Pays</label>
                                    <input class="input" type="text" name="country" placeholder="Pays"  required="required" value="<?php if (isset($user)) echo $user['country']; ?>" >
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section>
            <div class="container" style="display: flex;justify-content: flex-end">
                <input class="button--blue button" type="submit" value="Mettre à jour">
            </div>
        </section>
    </form>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <div class="row">
                        <h4 class="center-margin mb-5 mt-5">Je change mon mot de passe</h4>
                    </div>

                    <form method="POST" action="/modification-mdp-profil">
                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="old_pwd">Ancien mot de passe:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="password" id="old_pwd" name="old_pwd" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_align--top center-margin">
                                <label for="new_pwd">Nouveau mot de passe:</label>
                                <input style="width: 250px; margin-bottom: 40px" class="input" type="password" id="new_pwd" name="pwd" required>
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
                                <input type="submit" value="Mettre à jour" class="button button--blue">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
