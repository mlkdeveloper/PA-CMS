<h1 class="centered">Liste des produits</h1>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>N° produit</th>
                        <th>Commentaire</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datas as $product): ?>
                        <tr>
                            <td><?= $product["name"] ?></td>
                            <td><?= (($product[0]["nb_commentary_check"]) ?? "0"). " commentaire(s) vérifié(s) / ". $product["nb_commentary"] . " commentaires totaux" ?></td>
                            <td><?= round($product["mark"], 1) . "/5"; ?></td>
                            <td>
                                <a href="/admin/info-reviews?id=<?= $product["id_product"] ?>"  class="button button--black">
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