<section>
    <div class="container">

        <form method="POST" action="/admin/update-logo" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col">
                    <div class="jumbotron">

                        <div class="row mb-5">
                            <h4 class="center-margin">Logo</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col">
                                <img src="../images/publisher/icon-image.svg">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col">
                                <div class="form_align--top center-margin">
                                    <label class="mb-1" for="logo">Upload logo :</label>
                                    <input style="width: 250px; margin-bottom: 40px" class="input" type="file" id="logo" name="logo" required">
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

