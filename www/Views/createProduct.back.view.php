<section>
    <div class="container">
        <h1>Ajouter un produit</h1>
    </div>
</section>


<section>
    <div class="container">
        <div class="row" id="status" style="display: none"></div>
        <div class="row jumbotron">
            <div class="col-md-6 col-lg-6 col-sm-6 col">
                <div class="form_align--top">
                    <label class="label">Nom *</label>
                    <input class="input" type="text" id="product_name" placeholder="Chapeau" required="required">
                </div>

                <div class="form_align--top mt-1">
                    <label class="label">Description</label>
                    <textarea class="input" type="text" id="description" placeholder="..."></textarea>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-sm-6 col">
                <div class="form_align--top">
                    <label class="label">Catégorie *</label>
                    <select class="input" id="category">
                        <?php foreach ($categories as $category):?>
                            <option value="<?= $category["id"]?>"><?= $category["name"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mt-3">
                    <input id="variant" type="checkbox" value="1" checked onclick="isVariant()">
                    <label>Ce produit comporte plusieurs variantes, ex. différentes tailles ou couleurs. *</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id='attr_container'>
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
                                        <input class="checked" name="attributs" id="attr-<?= $attribute['id'] ?>" type="checkbox" value="<?= $attribute['id'] ?>" onclick="getSelectedAttributes(<?= $attribute['id']?>)">
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

    <div class="container" id='var_container'>
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

    <div class="container" id='without_attr' style="display: none">
        <div class="row">
            <div class="col col-md-12 col-sm-12 col-lg-12">
                <div class="jumbotron">

                    <div class="">
                        <h3>Stock et Prix</h3>
                        <hr>
                    </div>

                    <div class="row">
                        <input placeholder="stock" class="input col col-md-4 col-sm-4 col-lg-4" type="number" id="stock" min="1">
                        <input placeholder="prix" class="input col col-md-4 col-sm-4 col-lg-4" type="number" id="price" min="0.01">
                        <input class="input col col-md-4 col-sm-4 col-lg-4" type="file" id="file">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <button id="valider" class="button button--blue" onclick="buildArray('createProduct', '')" >Valider</button>
    </div>


    <div class="centered"><div class="spinner" id="loader"></div></div>
    <div id="comb" class="container">
    </div>

</section>

<script src="../public/js/product.js"></script>
