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

        <?php if(isset($_SESSION['successChangePwd'])):?>
            <div class="alert alert--green"><?= $_SESSION['successChangePwd']?></div>
            <?php unset($_SESSION['successChangePwd']); ?>
        <?php endif;?>

        <?php if(isset($_SESSION['errorChangePwd'])):?>
            <div class="alert alert--red"><?= $_SESSION['errorChangePwd']?></div>
            <?php unset($_SESSION['errorChangePwd']); ?>
        <?php endif;?>

        <div class="align">
            <h1>Modifier un utilisateur</h1>
            <button onclick="showModalPwd(<?= $users['id'] ?>)" class="button button--alert">Changer le mot de passe</button>
        </div>
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
                            <input class="input" type="text" name="lastname" value="<?= $users["lastname"] ?>" required="required">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Prénom *</label>
                            <input class="input" type="text" name="firstName" value="<?= $users["firstname"] ?>" required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Email *</label>
                            <input class="input" type="email" name="email" value="<?= $users["email"] ?>" required="required">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col">
                        <div class="form_align--top">
                            <label class="label">Rôle *</label>
                            <select class="input" name="idRole" required>
                                <?php foreach ($roles as $role):?>
                                    <option value="<?= $role["id"] ?>" <?= $users["name"] == $role["name"] ? "selected" : "" ?>><?= $role["name"] ?></option>
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


    <div class="modal" id="modalPwd">
        <div class="modal-content">
            <div style="display: flex;justify-content: flex-end">
                <i class="fas fa-times button button--alert" onclick="hideModalPwd()"></i>
            </div>
            <h3>Voulez-vous vraiment changer le mot de passe ?</h3>
            <a href="/admin/utilisateur-changement-mdp?id=<?= $_GET['id'] ?>"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalPwd()">Non</button>

        </div>
    </div>
</section>
<script src="../public/js/user.js" type="text/javascript"></script>