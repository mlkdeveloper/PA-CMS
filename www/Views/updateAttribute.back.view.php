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

        <h1>Modification de l'attribut <?= $attribute['name'] ?></h1>
    </div>
</section>




<section>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-10 col-sm-10 col">
                <div class="jumbotron">
                    <form method="POST" action="">
                        <div class="form_align--top">
                            <label class="label">Nom *</label>
                            <input class="input" type="text" name="name" placeholder="Couleur" required="required" value="<?= $attribute['name'] ?>">
                        </div>

                        <div class="form_align--top mt-1">
                            <label class="label">Description</label>
                            <textarea class="input" type="text" name="description" placeholder="..."><?= $attribute['description']?></textarea>
                        </div>
                        <div class="mt-1">
                            <input type="submit" class="button button--blue" value="Enregistrer">
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

