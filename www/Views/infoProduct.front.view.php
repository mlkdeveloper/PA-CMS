<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col col-sm-6 col-lg-6">
                <div style="">
                    <img style="width: 100%" src="https://media2.chapellerie-traclet.com/40969-large_default/chapeau-borsalino-noir.jpg">
                </div>
            </div>
            <div class="col-md-6 col col-sm-6 col-lg-4">
                <h1><?= $product['name'] ?></h1>
                <h2 id="price"></h2>
                <p>Taxes incluses.</p>


                <?php foreach ($getVariant as $key => $variant): ?>

                    <div class="form_align--top">
                    <label class="label"> <?= $key ?></label>
                    <select class="input">
                        <option value="" selected disabled hidden>Choisissez</option>
                        <?php foreach ($variant as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $value?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php endforeach; ?>

                <div class="form_align--top">
                    <label class="label">Quantité : </label>
                    <input type="number" class="input" value="1" min="1">
                </div>



                <button class="button button--blue mt-1">AJOUTER AU PANIER</button>

                <p class="mt-2"><?= $product['description'] ?></p>
            </div>
        </div>
    </div>
</section>