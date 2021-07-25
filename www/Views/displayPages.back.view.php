<div class="container">
    <div class="align">
        <h1>Liste des pages</h1>
        <a href="/admin/nouvelle-page" class="button button--blue">Ajouter une page</a>
    </div>
    <div class="row">
        <div class="col col-md-12 col-sm-12 col-lg-12">
            <div class="jumbotron">
                <?php
                if (isset($_SESSION['errorNavbar'])){
                    echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['errorNavbar'].'</h4></div>';
                    unset($_SESSION['errorNavbar']);
                }
                ?>
                <table id="table" class="row-border hover">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date de création</th>
                        <th>Chemin d'accès</th>
                        <th>Publier</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($array as $value):
                        ?>
                        <tr>
                            <td><?= $value['name'] ?></td>
                            <td><?= $value['createdAt'] ?></td>
                            <td><?= $value['slug'] ?></td>
                            <td>
                                <?php
                                    if ($value['id'] != 1) {
                                        echo '<label class="switch">';
                                            if ($value['publication'] == 1) {
                                                echo('<input id="publicationSwitch" name="' . $value["id"] . '" type="checkbox" checked>');
                                            } else {
                                                echo('<input id="publicationSwitch" name="' . $value["id"] . '" type="checkbox">');
                                            }

                                            echo '<span class="sliderSwitch roundSwitch"></span>';
                                        echo '</label>';
                                    }else{
                                        echo '<p>Non modifiable</p>';
                                    }
                                ?>
                            </td>
                            <td>
                                <div>
                                    <?php
                                        if ($value['id'] != 1) {
                                            echo '<a href = "/admin/modification-page?id='.$value["id"].'&slug='.$value["slug"].'" class="button button--blue">';
                                                echo '<i class="fas fa-pencil-alt" ></i > Modifier';
                                            echo '</a>';
                                        }
                                    ?>
                                    <a href="/admin/editeur?name=<?= $value['name'] ?>" class="button button--blue">
                                        <i class="fas fa-eye"></i>Voir la page
                                    </a>
                                    <?php
                                        if ($value['id'] != 1){
                                            echo '<i class="fas fa-trash" onclick="showModalDeletePage('.$value["id"].', \''.$value["name"].'\', \''.$value["slug"].'\')"></i>';
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="modalDeletePage">
        <div class="modal-content">
            <h3>Voulez-vous vraiment supprimer cette page ?</h3>
            <a id="buttonDeletPage"><button class="button button--success">Oui</button></a>
            <button class="button button--alert" onclick="hideModalDeletePage()">Non</button>
        </div>
    </div>
</div>

<script src="../public/js/datatable.js"></script>
<script src="../public/js/pages.js" type="text/javascript"></script>