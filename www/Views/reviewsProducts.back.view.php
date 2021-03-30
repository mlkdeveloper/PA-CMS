<h1 class="centered">Liste des produits</h1>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>N° produit</th>
                        <th>Image</th>
                        <th>Commentaire</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datas as $product): ?>
                        <tr>
                            <td><?= $product["id_product"] ?></td>
                            <td><?= $product["commentary"] ?></td>
                            <td><?= $product["nb_check_commentary"] . "/". $product["nb_commentary"] ?></td>
                                <td><?= $product["mark"] ?></td>
                            <td>
                                <a href="/admin/check-review?id=<?= $product["id"] ?>" class="button button--success">
                                    <i class="bi bi-check"></i>
                                </a>
                                <a href="/admin/del-review?id=<?= $product["id"] ?>" class="button button--alert">
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