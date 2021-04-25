<section>
    <div class="container">
        <?php if(isset($errors)):?>
            <div class="alert alert--red">
                <?php foreach ($errors as $error):?>
                    <li><?=$error?></li>
                <?php endforeach;?>
            </div>
        <?php endif;?>

        <?php if(isset($success)):?>
            <div class="alert alert--green"><?= $success?></div>
        <?php endif;?>

        <h1>Créer un utilisateur</h1>
    </div>
</section>

<section>

    <form method="POST" action="">
        <div class="container">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Nom *</label>
                            <input class="input" type="text" name="lastname" placeholder="Nom" required="required">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Prénom *</label>
                            <input class="input" type="text" name="firstName" placeholder="Prénom" required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Email *</label>
                            <input class="input" type="email" name="email" placeholder="email" required="required">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Mot de passe *</label>
                            <input class="input" type="password" name="pwd" placeholder="Mot de passe" required="required">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Rôle *</label>
                            <select class="input" name="idRole" required>
                                <?php foreach ($roles as $role):?>
                                <option value="<?= $role["id"] ?>"><?= $role["name"] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-1">
                <input type="submit" class="button button--blue" value="Enregistrer">
            </div>
        </div>
    </form>
</section>
