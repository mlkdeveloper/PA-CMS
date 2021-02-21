<div class="container">
    <div class="align">
        <h1>Liste des catégories</h1>
        <button class="button button--blue">
            <a href="/admin/nouvelle-categorie">Ajouter une catégorie</a>
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
                        <th class="thAction">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($listCategory as $category):
                    ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><?= $category['status'] ?></td>
                        <td>
                            <div class="align">
                                <button class="button button--black">
                                    <i class="fas fa-pencil-alt"></i>
                                    <a href="/admin/modification-categorie?id=<?= $category['id'] ?>">Modifier</a>
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
<link rel="stylesheet" href="../../dist/category.css">