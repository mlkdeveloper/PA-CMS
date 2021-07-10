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
                    <div class="col-lg-12 col-md-12 col-sm-12 col">
                        <div class="jumbotron">
                            <div class="">
                                <h4><?= $value['name'] ?></h4>
                                <div>
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