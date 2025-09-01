<div class="rounded-4 shadow text-center">
  <img src="<?= $categorie['image']; ?>" class="card-img-top card-img rounded-4" 
  alt="..." style="height: 50px; overflow: hidden;" usemap="#map<?= $categorie['id']; ?>">
  <map name="map<?= $categorie['id']; ?>">
    <area shape="rect" coords="0,0,300,140" href="<?= BASE_URL ?>produits.php?id=<?= $categorie['id']; ?>">
</map>
<p class="position-absolute"><?= $categorie['nom'] ?></p>

</div>