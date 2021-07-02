<div class="container">
    <div class="align">
        <h1>Liste des commandes</h1>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Utilisateur</th>
                        <th>Nb Article</th>
                        <th>Montant Total</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($array as $order): ?>
                        <tr>
                            <td><?= $order['id_order'] ?></td>
                            <td><?= $order['firstname'] ?> <?= $order['lastname'] ?></td>
                            <td><?= $order['nbArticle'] ?></td>
                            <td><?= $order['montant'] ?> €</td>

                            <td>
                                <div>
                                    <button class="button button--black">
                                        <i class="fas fa-search" ></i>
                                        <a href="/admin/detail-commande?id=<?= $order['id_order'] ?>">Voir plus</a>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/user.js" type="text/javascript"></script>

