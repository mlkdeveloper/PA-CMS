
<?php if(isset($errors)):?>

    <?php foreach ($errors as $error):?>
        <li><?=$error?></li>
    <?php endforeach;?>

<?php endif;?>




<section>
    <div class="container">
        <h1>Créer un client</h1>
    </div>
</section>
<section>
<!--   <?php //App\Core\FormBuilder::render($formCreateClient); ?> -->
    <form method="POST" enctype="multipart/form-data">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class=" align  jumbotron form">
                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <div class="form_align form_align--top">
                                    <label class="label">Nom</label>
                                    <input class="input" type="text" name="lastName" placeholder="Nom" required="required">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Email</label>
                                    <input class="input" type="text" name="email" placeholder="Email"  required="required">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Adresse</label>
                                    <input class="input" type="text" name="address" placeholder="Adresse"  required="required">
                                </div>
                                <div class="form_align form_align--top">
                                    <label class="label">Code postal</label>
                                    <input class="input" type="text" name="zipCode" placeholder="Code postal"  required="required">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <div class="form_align form_align--top">
                                    <label class="label">Prénom</label>
                                    <input class="input" type="text" name="firstName" placeholder="Prénom" required="required">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Téléphone</label>
                                    <input class="input" type="text" name="phoneNumber" placeholder="Téléphone"  required="required">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Ville</label>
                                    <input class="input" type="text" name="city" placeholder="Ville"  required="required">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Pays</label>
                                    <input class="input" type="text" name="country" placeholder="Pays"  required="required">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section>
            <div class="container" style="display: flex;justify-content: flex-end">
                <input class="button--blue button" type="submit" value="Enregistrer">
            </div>
        </section>
    </form>
</section>



<script src="../public/js/datatable.js"></script>
<script src="../public/js/category.js"></script>