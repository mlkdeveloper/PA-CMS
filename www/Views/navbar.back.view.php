<section>
    <div class="container">
        <div class="align">
            <h1>Menu principal</h1>
            <a href="/admin/nouveau-onglet-navigation">
                <button class="button button--blue">Ajouter un onglet</button>
            </a>
        </div>
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
                                    <div class="pr-3">
                                        <span><i class="fas fa-arrow-up"></i></span>
                                        <span><i class="fas fa-arrow-down"></i></span>
                                    </div>
                                    <button class="button button--black">
                                        <i class="fas fa-pencil-alt"></i>
                                        Modifier
                                    </button>
                                    <span><i class="fas fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
    </div>
</section>