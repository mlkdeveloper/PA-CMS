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
        <h1>Créer une page</h1>
    </div>
</section>
<section>
    <form method="POST">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class=" jumbotron">
                            <div class="form_align--top">
                                <label class="label" for="title">Titre *</label>
                                <input class="input" type="text" name="title" placeholder="Ma page" required="required">
                            </div>

                            <div class="form_align--top">
                                <label class="label" for="slug">Slug *</label>
                                <input class="input" type="text" name="slug" required="required">
                            </div>

                            <input class="button--blue button" type="submit" value="Enregistrer">
                        </div>
                    </div>

            </div>
        </section>
    </form>
</section>
