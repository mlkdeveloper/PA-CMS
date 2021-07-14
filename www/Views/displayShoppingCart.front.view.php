<section>
    <div class="container">

        <div class="align">
            <h1>Panier</h1>
            <?php if(!empty($_SESSION['panier'])): ?>
            <button class="button button--blue">Procéder au paiement</button>
            <?php endif; ?>
        </div>

        <?php if(empty($_SESSION['panier'])): ?>
        <div>
            <p>Votre panier est vide.</p>
            <a href="/">Retourner vers la boutique</a>
        </div>
        <?php endif; ?>


        <?php if(!empty($_SESSION['panier'])): ?>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="jumbotron">
                    <table id="table" class="row-border hover">
                        <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($products as $product)  :?>
                            <tr>

                                <td>
                                    <?= $product[0]['name'] . "<br>" ?>
                                    <?php foreach (array_map("current", $product) as $value)  :?>
                                        <?= $value . " "  ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>€ <?= $product[0]['price'] ?></td>
                                <td><?= $_SESSION['panier'][$product[0]['id']] ?></td>
                                <td><?= $_SESSION['panier'][$product[0]['id']] *  $product[0]['price']  ?></td>
                                <td><a href="/supprimer-panier?id=<?= $product[0]['id'] ?>">Supprimer</a></td>

                            </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div style="display: flex; justify-content: flex-end">
                    <h3> Total : <?= $_SESSION['panierTotal']?></h3>
                </div>
            </div>

            <?php endif; ?>

    </div>
</section>





<script src="../public/js/datatable.js"></script>
