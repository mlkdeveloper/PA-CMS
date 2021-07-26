<div class="container">
    <div class="align">
        <h1>Liste des commandes</h1>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Client</th>
                        <th>Nombre d'articles</th>
                        <th>Total en €</th>
                        <th>Statut</th>
                        <th style="width: 150px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($array as $order): ?>
                        <tr>
                            <td><?= $order['id_order'] ?></td>
                            <td><?= $order['firstname'] ?> <?= $order['lastname'] ?></td>
                            <td><?= $order['nbArticle'] ?></td>
                            <td><?= $order['montant'] ?> €</td>
                            <td><?php
                                if ($order['idStatus'] == -1){
                                    echo "Annulé";
                                }else if($order['idStatus'] == 0){
                                    echo "En attente";
                                }else if($order['idStatus'] == 1){
                                     echo "Validé";
                                }else if($order['idStatus'] == 2){
                                    echo "Terminé";
                                }
                                ?>
                            </td>
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

