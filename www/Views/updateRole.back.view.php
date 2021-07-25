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



        <h1><?= $values["name"] ?></h1>



    </div>
</section>

<section>

    <form method="POST" action="">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col">
                    <div class="jumbotron">
                        <div class="form_align--top">
                            <label class="label">Nom *</label>
                            <input class="input" type="text" name="name" placeholder="Admin" required="required" value="<?= $values["name"] ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-12 col">
                    <div class="jumbotron">
                        <div class="form_align--top">
                            <label class="label">Conditions *</label>
                        </div>
                        <div class="mb-1 mt-1">
                            <input type="checkbox" id="role" name="roles" value="1" <?=$values["roles"] ? "checked" :"" ?> >
                            <label for="role">Gestion des rôles</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="user" name="users" value="1" <?=$values["users"] ? "checked" :"" ?> >
                            <label for="user">Gestion des utilisateurs</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="customer" name="customers" value="1" <?=$values["customers"] ? "checked" :"" ?> >
                            <label for="customer">Gestion des clients</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="product" name="products" value="1" <?=$values["products"] ? "checked" :"" ?> >
                            <label for="product">Gestion des produits</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="category" name="categories" value="1" <?=$values["categories"] ? "checked" :"" ?> >
                            <label for="category">Gestion des catégories </label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="order" name="orders" value="1" <?=$values["orders"] ? "checked" :"" ?> >
                            <label for="order">Gestion des commandes</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="opinion" name="opinions" value="1" <?=$values["opinions"] ? "checked" :"" ?> >
                            <label for="opinion">Gestion des avis</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="page" name="pages" value="1" <?=$values["pages"] ? "checked" :"" ?> >
                            <label for="page">Gestion des pages</label>
                        </div>


                        <div class="mb-1">
                            <input type="checkbox" id="settingsCms" name="settingsCms" value="1" <?=$values["settingsCms"] ? "checked" :"" ?> >
                            <label for="page">Paramètres du CMS</label>
                        </div>

                        <div class="mb-1">
                            <input type="checkbox" id="settingsSite" name="settingsSite" value="1" <?=$values["settingsSite"] ? "checked" :"" ?> >
                            <label for="page">Paramètres du site</label>
                        </div>

                    </div>
                </div>
            </div>

            <div class="">
                <input type="submit" class="button button--blue" value="Enregistrer">
            </div>
        </div>
    </form>
