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
<div class="container">
    <h1><?= print_r($values) ?></h1>
    <h1><?= $values["slug"] ?></h1>

</div>

<section>
    <div class="container">
        <h1 class="centered">Créer une page</h1>
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
                                <input class="input" type="text" name="name" placeholder="Ma page" required="required">
                            </div>

                            <div class="form_align--top mt-2">
                                <label class="label" for="slug">Slug *</label>
                                <input class="input" type="text" name="slug" required="required">
                            </div>

                            <input class="button--blue button mt-2" type="submit" value="Enregistrer">
                        </div>
                    </div>

                </div>
        </section>
    </form>
</section>
