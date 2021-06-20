<section>
    <div class="container">
        <h1><?= strtoupper($name) ?></h1>
        <?php
        if (isset($description)){
            echo "<p>".$description."</p>";
        }
        ?>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">

            <?php
            foreach ($products as $product):
            ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"> <?= $product['name'] ?></h3>
                        <button class="button button--blue">ACHETER</button>
                    </div>
                </div>
            </div>


            <?php endforeach;?>
        </div>
    </div>
</section>

<section>

    <nav>
        <ul class="pagination">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($page == 1) ? "disabled" : "" ?>">
                <a href="/collections?name=<?= $name ?>&page=<?= $page - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($nbpage = 1; $nbpage <= $pages; $nbpage++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($page == $nbpage) ? "active" : "" ?>">
                    <a href="./?page=<?= $nbpage ?>" class="page-link"><?= $nbpage ?></a>
                </li>
            <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($page == $pages) ? "disabled" : "" ?>">
                <a href="/collections?name=<?= $name ?>&page=<?= $page + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>
</section>
