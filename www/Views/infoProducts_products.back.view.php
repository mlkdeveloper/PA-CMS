<!-- <h1 class="centered">Avis du produit n° <?= $product ?></h1>
<h2 class="centered">Nom du produit : <?= $product_name ?></h2> -->

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>Nom de la variante</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?= $produit["name"] ?></td>
                            <td><?= $produit["price"] ?> &euro;</td>
                            <td><?= $produit["stock"] ?></td>
                            <td>
                                <a href="/admin/del-produit-term?id=<?= $produit["idGroup"] ?>" class="button button--alert">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../public/js/datatable.js"></script>