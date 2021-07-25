<section>
    <div class="container">

        <?php if(isset($errors)):?>
            <div class="alert alert--red">
                <?php foreach ($errors as $error):?>
                    <li><?=$error?></li>
                <?php endforeach;?>
            </div>
        <?php endif;?>

        <?php if(isset($success)):?>
            <div class="alert alert--green"><?= $success?></div>
        <?php endif;?>

        <div class="row">
            <div class="col-md-12 col">
                <div id="msgShoppingCart"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col col-sm-6 col-lg-6">
                <div style="" id="displayImage">
                    <img width="100%" src="../images/cc.png" />
                </div>
            </div>
            <div class="col-md-6 col col-sm-6 col-lg-4">
                <h1><?= $product['productName'] ?></h1>
                <h2 id="price"></h2>
                <p>Taxes incluses.</p>


                <?php foreach ($getVariant as $key => $variant): ?>

                    <div class="form_align--top">
                    <label class="label"> <?= $key ?></label>
                    <select class="input variant" onchange="getPrice(<?= $product['idProduct'] ?>)">
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
                <p class="mt-2"><?= $product['productDescription'] ?></p>
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
       <?php if (isset($_SESSION['user']) && $userBuyed) : ?>
        <form method="POST">
        <div class="row">

            <div class="col-md-7 col-sm-12 col">
                <div class="form_align--top">
                    <label class="label">Laissez un commentaire ... </label>
                    <textarea class="input input--textarea" type="text" name="commentary" placeholder="Votre avis..." required></textarea>
                </div>
            </div>
            <div class="col-md-5 col-sm-2 col">
                <div class="form_align--top">
                    <label class="label">Note *</label>
                    <select class="input" name="mark" required>
                        <option value="1">1 étoile</option>
                        <option value="2">2 étoiles</option>
                        <option value="3">3 étoiles</option>
                        <option value="4">4 étoiles</option>
                        <option value="5">5 étoiles</option>

                    </select>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col">
                <input class="button--blue button" type="submit" value="Enregistrer">
            </div>

        </div>
        </form>
        <?php endif; ?>

    </div>

</section>

<script src="../public/js/productFront.js"></script>
<script src="../public/js/datatable.js"></script>
