<div class="container">
    <div class="jumbotron">
        <h1 class="centered">Détails sur la commande</h1>

        <div class="row">
            <div class="profil-picture col-md-3">
                <img src="../public/img/profil-icone.jpg"/>
            </div>
            <div class="col-md-4 jumbotron">
                <p>Adresse : </p>
                <p>Adresse : </p>
                <p>Adresse : </p>
                <p>Adresse : </p>
            </div>
            <div class="col-md-4 jumbotron">
                <p>Adresse : </p>
                <p>Adresse : </p>
                <p>Adresse : </p>
                <p>Adresse : </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table id="table" class="display">
                    <thead>
                    <tr>
                        <th>N° produit</th>
                        <th>Image</th>
                        <th>Commentaire</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--                    <?php /*foreach ($datas as $review): */ ?>
                        <tr>
                            <td><? /*= $review["id"] */ ?></td>
                            <td><? /*= $review["commentary"] */ ?></td>
                            <td><? /*= $review["commentary"] */ ?></td>
                            <td><? /*= $review["status"] */ ?></td>
                            <td>
                                <a href="/admin/check-review?id=<? /*= $review["id"] */ ?>" class="button button--success">
                                    <i class="bi bi-check"></i>
                                </a>
                                <a class="button button--alert">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    --><?php /*endforeach; */ ?>

                    <tr>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>
                            <a href="/admin/info-order" class="button button--warning">
                                <i class="bi bi-info"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="centered">
            <a class="button button--blue" href="/admin/orders">Retour</a>
        </div>
    </div>
</div>

<script src="../public/js/datatable.js"></script>