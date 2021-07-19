<?php

if (isset($errors)){

    echo "<div class='container'>";
    echo "<div class='alert alert--red'>";

    foreach($errors as $error){
        echo $error . "<br>";
    }

    echo "</div>";
    echo "</div>";
}
?>
<section>
    <div class="container">
        <a href="/admin/pages"><button class="button button--blue">Retour</button></a>
        <h1 class="centered">Modification de la page</h1>
    </div>
</section>
<section>
    <form method="POST">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col center-margin">
                        <div class=" jumbotron">
                            <div class="form_align--top">
                                <label class="label" for="name">Titre *</label>
                                <input class="input" type="text" name="name" placeholder="Ma page" required="required" value="<?= $values->getName()?>">
                            </div>

                            <div class="form_align--top mt-2">
                                <label class="label" for="slug">Slug *</label>
                                <input class="input" type="text" name="slug" required="required" value="<?= $values->getSlug()?>">
                            </div>

                            <input class="button--blue button mt-2" type="submit" value="Enregistrer">
                        </div>
                    </div>

                </div>
        </section>
    </form>
</section>
