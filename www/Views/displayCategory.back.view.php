<div class="container">

    <div>
        <h1>Liste des catégories</h1>
        <a href="#" class="button">Ajouter une catégorie</a>
    </div>
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
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($array as $value):
                    ?>
                    <tr>
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['id'] ?></td>

                    </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script src="../public/js/datatable.js"></script>