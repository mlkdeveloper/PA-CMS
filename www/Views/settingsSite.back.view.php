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
                            <h4 class="center-margin">Logo</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col">
                                <img src="../images/logo/<?= $logo ?>">
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

