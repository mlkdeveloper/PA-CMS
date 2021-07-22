<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <h2>Informations nécessaires du magasin</h2>
                <hr>

                <?php if(isset($errors)):?>
                    <ul class="alert alert--red">
                        <?php foreach ($errors as $error):?>
                            <li style="list-style-type: none; "><?=$error?></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
                <div class="col col-lg-4 col-md-4 center-margin">
                    <?php App\Core\FormBuilder::render($form); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>