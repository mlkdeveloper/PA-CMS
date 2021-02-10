<div class="container">

    <div class="align">
        <h1>Liste des catégories</h1>
        <button class="button button--blue">
            <a href="/admin/newCategory">Ajouter une catégorie</a>
        </button>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="jumbotron">
                <table id="table" class="row-border hover">
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
                        <td><?= $value['name'] ?></td>
                        <td >
                            <div class="align">
                                <button class="button button--black">
                                    <i class="fas fa-pencil-alt"></i>
                                    <a href="#">Modifier</a>
                                </button>
                                <i class="fas fa-trash"></i>
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