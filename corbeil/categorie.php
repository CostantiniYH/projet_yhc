<div class="rounded-4 shadow text-center card border-0 hvr-shadow-radial">
    <div class="card-img-top card-img rounded-top" style="width: 20rem; height: 150px; overflow: hidden;" 
    usemap="map<?= $categorie['id']; ?>">
        <?php
        $carousel = new Carousel();

        $a = [];

        $files = glob('./uploads/' . $categorie['nom'] . '/*.{jpg}', GLOB_BRACE);
        foreach ($files as $file) {
            $fileName = basename($file, pathinfo($file, PATHINFO_EXTENSION));
            $text = ucwords(str_replace(['_', '-', '.'], ' ', $fileName));
            $a[] = [
                'link' => $file,
                'text' => $text
            ];
        }
        $carousel->Read($a, $categorie['id']);?>
    </div>

    <!-- <img src="<?= $categorie['image']; ?>" class="card-img-top card-img rounded-top" 
     alt="..." style="width: 20rem; height: 150px; overflow: hidden;" usemap="#map<?= $categorie['id']; ?>">-->

    <map name="map<?= $categorie['id']; ?>">
        <area shape="rect" coords="0,0,350,160" href="../produits.php?id=<?= $categorie['id']; ?>">
    </map>
    <div class="card-body">
        <h5 class="card-title mt-2"><?= $categorie['nom'] ?></h5>
        <p class="card-text alert alert-success alert-dismissible fade show p-1 m-3 mb-3" data-bs-dismiss="3000" 
        role="alert">Nombre de catégorie : <?= $categorie['nombre_produits'] ?></p>
    </div>
</div>