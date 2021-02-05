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
                        <th>N° catégorie</th>
                        <th>Nom</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($array as $value):
                    ?>
                    <tr>
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['name'] ?></td>
                        <td><?= $value['status'] == 1 ? "Actif" : "Inactif"; ?></td>
                        <td><a href="#" class="button button--success">Edit</a></td>
                    </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script src="../public/js/datatable.js"></script>