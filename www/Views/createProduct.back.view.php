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
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-md-12 col-sm-12 col-lg-12">
                <div class="jumbotron">

                    <div class="align">
                        <h3>Les attributs</h3>
                        <i onclick="displayAttribute()" class="fas fa-plus"></i>
                    </div>

                    <div id="blockAttribute">

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6 col">
                                <div class="form_align--top">
                                    <label class="label">Attribut *</label>
                                    <select class="input" id="attribute" onchange="getValueAttribute()">
                                        <?php foreach ($attributes as $attribute): ?>
                                            <option value="<?= $attribute['id'] ?>"><?= $attribute['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col">
                                <div class="form_align--top">
                                    <label class="label">Valeurs</label>
                                    <div id="value"></div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</section>

<script src="../public/js/product.js"></script>