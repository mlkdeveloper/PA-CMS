<div class="container">
    <div class="row centered">
        <div class="col col-lg-10">
            <h1 style="text-align: center;font-size: 40px">Connexion</h1>
            <div class="jumbotron">

                <?php if(isset($_SESSION['successRegister'])):?>
                <div class="alert alert--green errorMessageImage"><h4><?=$_SESSION['successRegister']?></h4></div>
                <?php unset($_SESSION['successRegister']);?>
                <?php endif;?>

                <?php if(isset($errors)):?>
                    <ul class="alert alert--red">
                        <?php foreach ($errors as $error):?>
                            <?=$error?><br>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
                <?php App\Core\FormBuilder::render($formLogin, true, true); ?>
                <a href="/mot-de-passe-oublie" class="centered"> Mot de passe oublié</a>
                <p class="centered">Pas encore de compte ?&nbsp;<a href="/inscription" class="centered">S'inscrire</a></p>
            </div>
        </div>
    </div>
</div>