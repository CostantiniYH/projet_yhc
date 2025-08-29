<div class="card border-0 shadow hvr-shadow-radial"  style="width: 18rem;">
  <img src="<?= BASE_URL . $value['image']; ?>" class="card-img-top card-img" 
  alt="<?= $value['nom']; ?>" style="height: 200px; object-fit: cover;" usemap="#map<?= $value['id']; ?>">
  <map name="map<?= $value['id']; ?>">
    <area shape="rect" coords="0,0,300,200" href="<?= BASE_URL ?>produit_one.php?id=<?= $value['id']; ?>"
     <?= $value['status'] == "0" ? 'aria-disabled="true" onclick="return false;"' : "" ?>>
  </map>
  <div class="card-body">
      <h5 class="card-title"><?= $value['nom']; ?></h5>
      <p class="card-text"><?= $value['nom_categorie']; ?> </p>
      <h5 class="card-text"><?= $value['prix']; ?><?= $value ['devise']; ?></h5>
      <?php if ($value['quantite'] > 0) {
        echo '<p class="alert alert-success alert-dismissible fade show" data-bs-dismiss="3000" 
        role="alert">Stock disponible : ' . $value['quantite']; 
        echo '</p>';
        } else {
          echo '<p  class="alert alert-danger alert-dismissible fade show" data-bs-dismiss="3000" 
          role="alert">Quantité disponible : 0';
          echo '</p>';
      }
      ?>
  </div>
</div>