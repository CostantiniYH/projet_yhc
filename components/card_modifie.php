<div class="card"  style="width: 18rem;">
  <img src="<?= BASE_URL . $value['image']; ?>" class="card-img-top" alt="..." style="height: 150px; object-fit: cover;">
  <div class="card-body">
    <h5 class="card-title"><?= $value['nom']; ?></h5>
    <p class="card-text"><?= $value['nom_categorie']; ?> </p>
    <h5 class="card-text"><?= $value['prix']; ?><?= $value ['devise']; ?></h5>
    <?php if ($value['quantite'] > 0) {
        echo '<p class="alert alert-success alert-dismissible fade show" data-bs-dismiss="3000" 
        role="alert">Quantité disponible : ' . $value['quantite']; 
        echo '</p>';
        } else {
          echo '<p  class="alert alert-danger alert-dismissible fade show" data-bs-dismiss="3000" 
          role="alert">Quantité disponible : 0';
          echo '</p>';
      }
      ?>
    <a href="<?= BASE_URL ?>produit_one.php?id=<?= $value['id']; ?>" <?= $value['status'] == "0" ? "disabled" : ""?>
       class="btn btn-primary bi bi-eye"></a>
    <a href="<?= BASE_URL ?>up_produit.php?id=<?= $value['id']; ?>" <?= $value['status'] == "0" ? "disabled" : ""?>
       class="btn btn-warning bi bi-pencil"></a>
    <a href="<?= BASE_URL ?>del_produit.php?id=<?= $value['id']; ?>" <?= $value['status'] == "0" ? "disabled" : ""?>
       class="btn btn-danger bi bi-trash" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')"></a>
  </div>
</div>