<section>
    <div class="container">

        <div class="row">
            <div class="col-md-12 col">
                <div id="msgShoppingCart"></div>
            </div>
        </div>

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
                    <select class="input variant" onchange="getPrice(<?= $product['id'] ?>)">
                        <option value="" selected disabled hidden>Choisissez</option>
                        <?php foreach ($variant as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $value?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php endforeach; ?>

                <div class="form_align--top">
                    <label class="label">Quantité : </label>
                    <input id="quantity" type="number" class="input" value="1" min="1">
                </div>

                <div id="msg"></div>
                <button id="add" class="button button--blue mt-1">AJOUTER AU PANIER</button>
                <p class="mt-2"><?= $product['description'] ?></p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <p>Avis sur le produit...</p>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="jumbotron">
                    <table id="table" class="row-border hover">
                        <thead>
                        <tr>
                            <th>Date de publication</th>
                            <th>Nom</th>
                            <th>Commentaires</th>
                            <th>Note</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($reviews as $review)  :?>
                            <tr>
                                <td><?= \App\Core\Helpers::dateFr($review['createdAt'])?></td>
                                <td><?= $review['lastname'] ?></td>
                                <td><?= $review['commentary'] ?></td>
                                <td>
                                    <?php for ($i = 0 ; $i < $review['mark']; $i++): ?>
                                    <i class="fa fa-star"></i>
                                    <?php endfor; ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<script src="../public/js/productFront.js"></script>
<script src="../public/js/datatable.js"></script>
