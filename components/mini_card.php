<div class="rounded-4 shadow">
  <img src="<?= BASE_URL . $value['image']; ?>" class="card-img-top rounded-4" 
  alt="<?= $value['nom'];?>" style="height: 8rem; object-fit: cover;" usemap="#map<?= $value['id']; ?>">
  <map name="map<?= $value['id']; ?>">
    <area shape="rect" coords="0,0,250,140" href="<?= BASE_URL ?>produit_one.php?id=<?= $value['id']; ?>"
     <?= $value['status'] == "0" ? 'aria-disabled="true" onclick="return false;"' : "" ?>>
</map>
</div>