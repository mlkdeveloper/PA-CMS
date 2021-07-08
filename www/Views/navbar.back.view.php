<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">
                    <div class="align">
                        <h1>Menu principal</h1>
                        <button class="button button--blue">
                            <a href="">Ajouter un onglet</a>
                        </button>
                    </div>
                    <div id="menu">
                        <?php
                        foreach ($dataNavbar as $value):
                            ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col">
                                    <h4><?= $value['name'] ?></h4>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>