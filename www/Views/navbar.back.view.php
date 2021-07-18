<section>
    <div class="container">
        <div class="align">
            <h1>Menu principal</h1>
            <a href="/admin/nouveau-onglet-navigation">
                <button class="button button--blue">Ajouter un onglet</button>
            </a>
        </div>
        <?php
        if (isset($_SESSION['errorDeleteTab'])){
            echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['errorDeleteTab'].'</h4></div>';
            unset($_SESSION['errorDeleteTab']);
        }
        ?>
        <?php
        foreach ($dataNavbar as $value):
            ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col center-margin">
                    <div class="jumbotron">
                        <div class="displayTabNavbar">
                            <h4><?= $value['name'] ?></h4>
                            <?php
                            if($value['status'] == 1){
                                    echo '<span>(Liste déroulante)</span>';
                                }
                            ?>

                            <div>
                                <div class="mb-1 containerArrowNavbar">
                                    <span><i style="color: #2D9CDB" onclick="up(<?= $value['id'] ?>, this)" class="fa-2x fas fa-arrow-circle-up"></i></span>
                                    <span><i style="color: #2D9CDB" onclick="down(<?= $value['id'] ?>, this)" class="fa-2x fas fa-arrow-circle-down"></i></span>
                                    <span><i class="fas fa-trash" onclick="showModalDeleteTab(<?=$value["id"]?>, <?=$value["status"]?>)"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <div class="modal" id="modalDeleteTab">
            <div class="modal-content">
                <h3>Voulez-vous vraiment supprimer cet onglet ?</h3>
                <a id="buttonDeleteTab"><button class="button button--success">Oui</button></a>
                <button class="button button--alert" onclick="hideModalDeleteTab()">Non</button>
            </div>
        </div>
    </div>
</section>

<script src="../public/js/navbar.js"></script>