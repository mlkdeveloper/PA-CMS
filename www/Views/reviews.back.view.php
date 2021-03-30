<h1 class="centered">Avis</h1>

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
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datas as $review): ?>
                    <tr>
                        <td><?= $review["id"] ?></td>
                        <td><?= $review["commentary"] ?></td>
                        <td><?= $review["commentary"] ?></td>
                        <td><?= $review["email"] ?></td>
                        <td><?= $review["rs"] ?></td>
                        <td>
                            <a href="/admin/check-review?id=<?= $review["id"] ?>" class="button button--success">
                                <i class="bi bi-check"></i>
                            </a>
                            <a href="/admin/del-review?id=<?= $review["id"] ?>" class="button button--alert">
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