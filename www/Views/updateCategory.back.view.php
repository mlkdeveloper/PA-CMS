<section>
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
        <h1><?= $category->getName(); ?></h1>
    </div>
</section>
<section>
    <form method="POST" enctype="multipart/form-data">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col">
                        <div class="jumbotron">
                            <div class="form_align--top">
                                <label class="label">Titre *</label>
                                <input class="input" type="text" name="name" placeholder="Casquettes" required="required" value="<?= $category->getName(); ?>">
                            </div>

                            <div class="form_align--top">
                                <label class="label">Description </label>
                                <textarea class="input input--textarea" type="text" name="description" placeholder="Nos casquettes..."><?= $category->getDescription();?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12 col">
                        <div class="jumbotron">
                            <div class="form_align--top">
                                <label class="label">Statut *</label>
                                <select class="input" name="status">
                                    <option value="0" <?= $category->getStatus() == 0 ? "selected" : "" ?> >Actif</option>
                                    <option value="1"  <?= $category->getStatus() == 1 ? "selected" : "" ?>>Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="jumbotron mt-2">
                            <div class="align">
                                <h2>Image *</h2>
                                <i class="fas fa-plus" onclick="triggerCategoryAdd()"></i>
                                <input id="categoryUpload" type="file" accept="image/*" name="categoryImage" onchange="displayImageCategory(this)">
                            </div>

                          <div class="imageBlock">
                             <img src="<?= "../images/category/" . $category->getPicPath()??'../images/cross-add.svg'?>" id="categoryImage">
                          </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="jumbotron">
                            <table id="table" class="row-border hover">
                                <thead>
                                <tr>
                                    <th>N° Produit</th>
                                    <th>Nom</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
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

<script src="../public/js/datatable.js"></script>
<script src="../public/js/category.js"></script>
<link rel="stylesheet" href="../../dist/category.css">

