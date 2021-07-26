<section>
    <div class="container">

        <?php
        if (isset($errors)){

            echo "<div class='container'>";
            echo "<div class='alert alert--red'>";

            foreach($errors as $error){
                echo $error . "<br>";
            }

            echo "</div>";
            echo "</div>";
        }

        if (isset($success)){

            echo "<div class='container'>";
            echo "<div class='alert alert--green'>";
            echo $success;
            echo "</div>";
            echo "</div>";
        }

        ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col">
                    <div class="jumbotron">

                        <div class="row mb-5">
                            <h1>Logo</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col">
                                <img src="../images/logo/<?= $logo ?>" style="width: 20rem; height: 20rem; object-fit: cover;">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col">
                                <div class="form_align--top center-margin">
                                    <label class="mb-1" for="logo">Upload logo :</label>
                                    <input style="width: 250px; margin-bottom: 40px" accept="image/png, image/jpg, image/jpeg, image/svg" class="input" type="file" id="logo" name="logo" required="required"">
                                </div>

                                <input type="submit" value="Changer le logo" class="button button--blue">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col">
                <div class="jumbotron">

                    <div class="">
                        <h4 class="">Mes thèmes</h4>
                    </div>

                    <div class="row">
                        <?php foreach ($themes as $theme):?>
                            <div class="col-lg-3 col-md-3  col-sm-6 col">
                                <div class="card" style="min-height: 150px;">
                                    <div class="card-body">
                                        <h3 class="card-title"> <?= $theme['name'] ?></h3>
                                        <?php if (!$theme['status']): ?>
                                        <a href="/admin/activer-theme?id=<?= $theme['id']?>"><button class="button button--blue">Activer le thème</button></a>
                                        <?php else: ?>
                                        <p>Thème activé</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

