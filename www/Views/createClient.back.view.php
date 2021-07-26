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

        <h1>Créer un client</h1>
    </div>
</section>
<section>

    <form method="POST">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="align  jumbotron form">
                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <div class="form_align form_align--top">
                                    <label class="label">Nom *</label>
                                    <input class="input" type="text" name="lastName" placeholder="Nom" required="required" value="">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Email *</label>
                                    <input class="input" type="email" name="email" placeholder="Email"  required="required" value="" >
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Adresse *</label>
                                    <input class="input" type="text" name="address" placeholder="Adresse"  required="required" value="" >
                                </div>
                                <div class="form_align form_align--top">
                                    <label class="label">Code postal *</label>
                                    <input class="input" type="text" name="zipCode" placeholder="Code postal"  required="required" value="">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col">
                                <div class="form_align form_align--top">
                                    <label class="label">Prénom *</label>
                                    <input class="input" type="text" name="firstName" placeholder="Prénom" required="required" value="">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Téléphone *</label>
                                    <input class="input" type="text" name="phoneNumber" placeholder="Téléphone"  required="required" value="">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Ville *</label>
                                    <input class="input" type="text" name="city" placeholder="Ville"  required="required" value="">
                                </div>

                                <div class="form_align form_align--top">
                                    <label class="label">Pays *</label>
                                    <input class="input" type="text" name="country" placeholder="Pays"  required="required" value="" >
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section>
            <div class="container " style="display: flex;justify-content: flex-end">
                <input class="button--blue button" type="submit" value="Enregistrer">
            </div>

            <div class="container">
                <a class="button button--blue" href="/admin/liste-client" > Retour </a>
            </div>

        </section>
    </form>
</section>



<script src="../public/js/datatable.js"></script>