<div class="container">


    <?php if(isset($_SESSION['successDeleteCategory'])):?>
        <div class="alert alert--green"><?= $_SESSION['successDeleteCategory']?></div>
        <?php unset($_SESSION['successDeleteCategory']); ?>
    <?php endif;?>

    <?php if(isset($_SESSION['errorDeleteCategory'])):?>
        <div class="alert alert--red"><?= $_SESSION['errorDeleteCategory']?></div>
        <?php unset($_SESSION['errorDeleteCategory']); ?>
    <?php endif;?>


    <div class="align">
        <h1>Liste des catégories</h1>
        <button class="button button--blue">
            <a href="/admin/nouvelle-categorie">Ajouter une catégorie</a>
        </button>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
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
                            <a class="button button--black" href="/admin/modification-categorie?id=<?= $category['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                            <a class="button button--alert" href="/admin/suppression-categorie?id=<?= $category['id'] ?>"><i class="fas fa-trash"></i></a>
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