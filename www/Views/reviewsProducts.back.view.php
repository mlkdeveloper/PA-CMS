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
                            <td><?= $product["nb_check_commentary"] . " commentaire(s) vérifié(s) / ". $product["nb_commentary"] . " commentaires totaux" ?></td>
                            <td><?= $product["mark"] ?></td>
                            <td>
                                <a href="#" class="button button--black">
                                    Informations
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