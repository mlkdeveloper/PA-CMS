<h1 class="centered">Avis</h1>

<div class="container">
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>N° produit</th>
                        <th>Nom du produit</th>
                        <th>Commentaire</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datas as $review): ?>
                    <tr>
                        <td><?= $review["id_products"] ?></td>
                        <td><?= $review["name"] ?></td>
                        <td><?= $review["commentary"] ?></td>
                        <td><?= $review["email"] ?></td>


                        <?php
                            if($review["rs"] == 1){
                                echo "<td class='alert--green'>Vérifié</td>";
                            }else if($review["rs"] == 0){
                                echo "<td class='alert--warning'>Non Vérifié</td>";
                            }else{
                                echo "<td class='alert--red'>Non respect des lois</td>";
                            }
                        ?>
                        <td>
                            <a href="/admin/check-review?id=<?= $review["id_review"] ?>" class="button button--success">
                                <i class="fas fa-check"></i>
                            </a>
                            <a href="/admin/del-review?id=<?= $review["id_review"] ?>" class="button button--alert">
                                <i class="fas fa-trash"></i>
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