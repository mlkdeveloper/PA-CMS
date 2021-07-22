<div class="container">
    <div class="row">
        <div class="col col-lg-12">
            <h1 style="text-align: center;font-size: 40px">Modification du magasin</h1>
            <div class="jumbotron ">
                <?php if(isset($errors)):?>
                <ul class="alert alert--red">
                    <?php foreach ($errors as $error):?>
                        <li style="list-style-type: none; "><?=$error?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <?php App\Core\FormBuilder::render($form); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/French.json'
            },
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"}
            ]
        });
    });
</script>