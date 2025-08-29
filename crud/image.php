<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../class/navbar.php';
require_once __DIR__ . '/../class/carousel.php';

require_login();

if (isLoggedIn()) {
    echo "Vous êtes connecté";
}

$pdo = connect();
$categories = findAll($pdo, 't_categories');
$images = findAll($pdo, 't_images');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$image = null;
if ($id) {
    $image = findBy ($pdo, 't_images', 'id', $id);
    $image = $image[0] ?? null;
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
    $navbar->AddItem('', 'crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('','crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'crud/image.php', 'center', true, 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('','javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');

$navbar->render() ;
?>

<div class="container mb-5 mt-5">

    <?php if (isset($_GET['erreur'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" data-bs-dismiss="3000" role="alert">
            <?= htmlspecialchars($_GET['erreur']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" data-bs-dismiss="3000" role="alert">
            <?= htmlspecialchars($_GET['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" data-bs-dismiss="3000" role="alert">
            <?= htmlspecialchars($_GET['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row mb-4 gap-4">
        <form action="<?= BASE_URL ?>controllers/image.php" method="post" class="col-md-5 mb-5 p-2 shadow-lg
         rounded-4 border border-1 border-success" data-aos="zoom-in" enctype="multipart/form-data">
            <?php if ($id) { ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($image['id']) ?>">
                <h2 class="text-center">Modifier l'image</h2>
            <?php } else { ?>
                <h2 class="text-center">Ajouter une image</h2>
            <?php } ?>
            <div class="form-group m-4">
                <label for="nom" class="mb-2">Nom de l'image</label>
                <input value="<?= htmlspecialchars($image['nom'] ?? '') ?>" type="text" class="form-control" id="nom" name="nom"
                placeholder="Entrez le nom" required>
            </div>
            <div class="form-group m-4">
                <label for="categorie" class="mb-2">Catégorie</label>
                <select class="form-select" id="categorie" name="categorie">
                    <option value="<?= htmlspecialchars($produit['id_categorie'] ?? '') ?>"><?= htmlspecialchars($image['nom_categorie'] ?? '') ?> </option>
                    <?php                    
                    foreach ($categories as $categorie) : ?>
                    <option value="<?= $categorie['id']; ?>"><?php echo $categorie['nom'] ?? ''; ?></option>
                    <?php endforeach; ?>                        
                </select>
            </div>
            <div class="form-group m-4">
                <label for="image" class="mb-2">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group m-4">
                <input type="submit" class="btn btn-primary" value="Ajouter">
            </div>
        </form>
        <div class="col-md shadow rounded-4 p-3 border border-1 border-primary">
            <h3 class="text-center">Images existantes</h3>
            <div class="row">
            <?php foreach ($images as $image => $value) { ?>
                <div class="col-md-3 mb-2">
                    <?php require __DIR__ . '/../components/image.php'; ?>
                </div>
            <?php } ?>
            </div>
        </div>                    
    </div>
</div>
<?php
require_once __DIR__ . '/../components/footer.php';
?>
