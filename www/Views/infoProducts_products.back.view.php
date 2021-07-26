<div class="container">
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>Nom de la variante</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Image de la variante</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datas as $key => $produits): ?>
                            <tr>
                                <td>
                                    <?php foreach ($produits as $produit): ?>
                                        <?= $produit["nameAttr"] ?>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= $produit["price"] ?> &euro;</td>
                                <td><?= $produit["stock"] ?></td>
                                <td><?= !empty($produit["picture"]) ? "<img style='width: 100px;' src='../images/products/".$produit["picture"]. "' />" : "Pas d'image pour cette variante" ?></td>
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