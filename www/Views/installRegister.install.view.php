<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col center-margin">
            <div class="jumbotron">
                <?php
                if(isset($_SESSION['securityInstall'])){
                    echo '<div class="alert alert--red errorMessageImage"><h4>'.$_SESSION['securityInstall'].'</h4></div>';
                    unset($_SESSION['securityInstall']);
                }
                ?>
                <h2>Informations nécessaires de l'administrateur</h2>
                <hr>
                <?php if(isset($errors)):?>
                    <div class="alert alert--red errorMessageImage">
                        <?php foreach ($errors as $error):?>
                            <h4><?=$error?></h4>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>
                <div class="col col-lg-4 col-md-4 center-margin">
                    <?php App\Core\FormBuilder::render($form); ?>
                </div>
            </div>
        </div>
    </div>
</div>