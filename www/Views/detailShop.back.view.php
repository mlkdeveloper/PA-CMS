<div class="container">
    <div class="row">
        <div class="col col-lg-12">
            <h1 style="text-align: center;font-size: 40px">Modification du magasin</h1>
            <div class="jumbotron">
                <?php if(isset($errors)):?>

                    <?php foreach ($errors as $error):?>
                        <li><?=$error?></li>
                    <?php endforeach;?>

                <?php endif;?>
                <?php App\Core\FormBuilder::render($form); ?>

                <br><hr>
                <h2 style="text-align: center;font-size: 30px">Liste des produits</h2>
                <table id="table" class="row-border hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th style="width:150px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($products as $value):
                        ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['name'] ?></td>
                            <td><?= $value['description'] ?></td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <div class="align">
                                    <div class="align">
                                        <button class="button button--black">
                                            <a href="/admin/detail-products?id=<?= $value['id']?>"><i class="fas fa-pencil-alt"></i>
                                                Modifier
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
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