<section>
    <div class="container">
        <h1>Ajouter un produit</h1>
    </div>
</section>


<section>
    <div class="container">
        <div class="row jumbotron">
            <div class="col-md-6 col-lg-6 col-sm-6 col">
                <div class="form_align--top">
                    <label class="label">Nom *</label>
                    <input class="input" type="text" name="name" placeholder="Chapeau" required="required">
                </div>

                <div class="form_align--top mt-1">
                    <label class="label">Description</label>
                    <textarea class="input" type="text" name="description" placeholder="..."></textarea>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-sm-6 col">
                <div class="form_align--top">
                    <label class="label">Catégorie *</label>
                    <select class="input" name="category">
                        <option value="0">Chapeau</option>
                        <option value="1">Pantalon</option>
                    </select>
                </div>

                <div class="mt-3">
                    <input id="variant" type="checkbox" checked onclick="isVariant()">
                    <label>Ce produit comporte plusieurs variantes, ex. différentes tailles ou couleurs. *</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-md-12 col-sm-12 col-lg-12">
                <div class="jumbotron">

                    <div class="">
                        <h3>Les attributs</h3>
                        <hr>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6 col">
                            <div id="blockAttributes" class="attributes">
                                <?php  foreach ($attributes as $attribute): ?>
                                <div class="mb-1">
                                    <input class="checked" id="attr-<?= $attribute['id'] ?>" type="checkbox" value="<?= $attribute['id'] ?>" name="attribute" onclick="getSelectedAttributes(<?= $attribute['id']?>)">
                                    <label id="lab-<?= $attribute['id'] ?>"><?= $attribute['name'] ?></label>
                                </div>
                                <?php endforeach;?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col col-md-12 col-sm-12 col-lg-12">
                <div class="jumbotron">

                    <div class="">
                        <h3>Valeurs</h3>
                        <hr>
                    </div>
                    <div id="selectedAttributes"></div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <button class="button button--blue">Valider</button>
    </div>
</section>

<script src="../public/js/product.js"></script>
