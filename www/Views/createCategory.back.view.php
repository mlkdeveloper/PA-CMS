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

if (isset($successNewCategory)){

    echo "<div class='container'>";
    echo "<div class='alert alert--green'>";
    echo $successNewCategory;
    echo "</div>";
    echo "</div>";
}

?>


<section>
    <div class="container">
        <h1>Créer une catégorie</h1>
    </div>
</section>
<section>
    <form method="POST">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col">
                        <div class="jumbotron">
                            <div class="form_align--top">
                                <label class="label">Titre *</label>
                                <input class="input" type="text" name="name" placeholder="Casquettes" required="required">
                            </div>

                            <div class="form_align--top">
                                <label class="label">Description </label>
                                <textarea class="input input--textarea" type="text" name="description" placeholder="Nos casquettes..."></textarea>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12 col">
                        <div class="jumbotron">
                            <div class="form_align--top">
                                <label class="label">Statut *</label>
                                <select class="input" name="status">
                                    <option value="1">Actif</option>
                                    <option value="0">Inactif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section>
            <div class="container positionBtnSave">
                <input class="button--blue button" type="submit" value="Enregistrer">
            </div>
        </section>
    </form>
</section>


<link rel="stylesheet" href="../../dist/category.css">

