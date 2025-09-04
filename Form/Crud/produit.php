<?php
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../class/navbar.php';
require_once __DIR__ . '/../../class/carousel.php';

require_login();

$pdo = connect();
$categories = getAll($pdo, 't_categories');
$produits = getAllWhere($pdo, 't_produits', 'deleted_at IS NULL AND quantite > ?', 0);

$id = isset($_GET['id']) ? intval($_GET['id']) : null;  // Sécurisation

$produit = null;
if ($id) {
    $produit = findBy($pdo, 't_produits', 'id', $id);
    $produit = $produit[0] ?? null; // Vérifier si le produit existe
    if (!$produit || empty($produit)) {
        die("Produit introuvable.");
    }
}


$navbar = new Navbar();
    $navbar->AddItem('|| YHC ||','index.php', 'left', '', '');
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', '', '');   
    $navbar->AddItem('Produits liste', 'produits.php', 'dropdown', '', '');
    $navbar->AddItem('Galerie','image.php','dropdown', '', '');
        if (isAdmin()) {
            $navbar->AddItem('', 'admin/dashboard_admin.php', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
        }
    $navbar->AddItem('', 'compte/dashboard.php', 'center', '', 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'Form/Crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('','Form/Crud/produit.php','center', true, 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'Form/Crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('','javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
$navbar->render() ;
?>
<div class="container mb-5 mt-5">
    <?php require_once __DIR__ . '/../../components/alerts.php'; ?>
        <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">
            Gestion des produits
        </h1>

    <div class="row mb-4 gap-4">
        <form action="<?= BASE_URL ?>controllers/Create-Update/produit.php" method="post" class="col-md-5 mb-5 p-2 shadow-lg
         rounded-4 border border-1 border-success" data-aos="zoom-in" enctype="multipart/form-data">
         <?php if ($id) { ?>
            <h2 class="text-center">Modifier le produit</h2>
            <?php } else { ?>
                <h2 class="text-center">Ajouter un produit</h2>
            <?php } ?>
            <div class="form-group m-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id'] ?? '') ?>">
                <label for="nom" class="mb-2">Nom</label>
                <input value="<?= $id ? htmlspecialchars($produit['nom']) : '' ?>" type="text" class="form-control" id="nom" name="nom"
                placeholder="Entrez le nom" required>
            </div>
            <div class="form-group m-4">
                <label for="prix" class="mb-2">Prix</label>
                <input value="<?= htmlspecialchars($produit['prix'] ?? '') ?>" type="number" class="form-control" id="prix" name="prix" min="0"
                placeholder="Entrez le prix" required>
            </div>
            <div class="form-group m-4">
                <label for="devise" class="mb-2">Devise</label>
                <select class="form-select" id="devise" name="devise">
                    <option value="€" <?= $produit && $produit['devise'] == '€' ? 'selected' : '' ?>>€</option>
                    <option value="$" <?= $produit && $produit['devise'] == '$' ? 'selected' : '' ?>>$</option>
                    <option value="£" <?= $produit && $produit['devise'] == '£' ? 'selected' : '' ?>>£</option>
                </select>
            </div>
            <div class="form-group m-4">
                <label for="quantite" class="mb-2">Quantité</label>
                <input value="<?= htmlspecialchars($produit['quantite'] ?? '') ?>" type="number" class="form-control" id="quantite" name="quantite" min="0"
                placeholder="Entrez la quantité" required>
            </div>
            <div class="form-group m-4">
                <label for="categorie" class="mb-2">Catégorie</label>
                <select class="form-select" id="categorie" name="categorie">
                    <option value="<?= $id ? $produit['id_categorie'] : '' ?>" selected><?= $id ? $produit['nom_categorie'] : '' ?></option>
                    <?php                    
                    foreach ($categories as $categorie) : ?>
                    <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['nom']; ?></option>
                    <?php endforeach; ?>                        
                </select>
            </div>
            <div class="form-group m-4">
                <label for="description" class="m-2">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Entrez votre description"
                 required><?= $id ? htmlspecialchars($produit['description']) : '' ?></textarea>
            </div>
            <div class="form-group m-4">
                <label for="image" class="mb-2">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group m-4">
                <input type="submit" class="btn btn-primary" value="<?= $id ? 'Modifier' : 'Ajouter' ?>">
            </div>
        </form>
        <div class="col-md shadow rounded-4 p-3 border border-1 border-primary">
            <h3 class="text-center">Produits existant</h3>
            <div class="row gy-4">
            <?php foreach ($produits as $produit => $value) { ?>
                <div class="col-md-4">
                    <?php require __DIR__ . '/../../components/mini_card.php'; ?>
                </div>
            <?php } ?>
            </div>
        </div>                    
    </div>    
</div>
<?php
require_once __DIR__ . '/../../components/footer.php';
?>
