<section>
    <div class="container">
        <h1>Créer une catégorie</h1>
    </div>
</section>

<?php

    if (isset($errors)){

        print_r($errors);
    }
?>

<section>
    <form method="POST" enctype="multipart/form-data">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col">
                        <div class=" jumbotron">
                            <div class="form_align--top">
                                <label class="label">Titre</label>
                                <input class="input" type="text" name="name" placeholder="Casquettes" required="required">
                            </div>

                            <div class="form_align--top">
                                <label class="label">Description</label>
                                <textarea class="input input--textarea" type="text" name="description" placeholder="Nos casquettes..."></textarea>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12 col">
                        <div class="jumbotron">
                            <div class="form_align--top">
                                <label class="label">Statut</label>
                                <select class="input" name="status">
                                    <option value="0">Actif</option>
                                    <option value="1">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="jumbotron" style="margin-top:5%;">
                            <div class="align">
                                <h2>Image</h2>
                                <i class="fas fa-plus" onclick="triggerCategoryAdd()"></i>
                                <input style="display: none;" id="categoryUpload" type="file" accept="image/*" name="othersPictures" class="input" onchange="displayImageCategory(this)">
                            </div>

                          <div style="display: flex; justify-content: center">
                             <img src="../images/cross-add.svg" id="categoryImage" style="width: 50%;">
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
            <div class="container" style="display: flex;justify-content: flex-end">
                <input class="button--blue button" type="submit" value="Enregistrer">
            </div>
        </section>
    </form>
</section>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/category.js"></script>

