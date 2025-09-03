<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../Controllers/session.php';
require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../class/navbar.php';
require_once __DIR__ . '/../../class/carousel.php';

require_login();

if (!isAdmin()) {
    echo "Accès interdit !";
}


$pdo = connect();
$categories = getAll($pdo, 't_categories');


$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$categorie = null;
if ($id) {
    $categorie = findBy1 ($pdo, 't_categories', 'id', $id);
    $categorie = $categorie[0] ?? null;
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
    $navbar->AddItem('', 'Compte/dashboard.php', 'center', '', 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'crud/categorie.php', 'center', true, 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('','Form/Crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'Form/Crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'Compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('','javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');

$navbar->render() ;
?>

<div class="container mb-5 mt-5">
    <?php require_once __DIR__ . '/../../components/alerts.php'; ?>

    <div class="row mb-4 gap-4">
        <form action="<?= BASE_URL ?>Controllers/Create-Update/categorie.php" method="post" class="col-md-5 mb-5 p-2 shadow-lg
         rounded-4 border border-1 border-success" data-aos="zoom-in" enctype="multipart/form-data">

         <?php if ($id) { ?>
            <h2 class="text-center">Modifier la catégorie</h2>
        <?php } else { ?>
            <h2 class="text-center">Ajouter une catégorie</h2>
        <?php } ?>

            <div class="form-group m-4">
                <input value="<?= $categorie['id'] ?? '' ?>" type="hidden" name="id">
                <label for="nom" class="mb-2">Nom de la catégorie</label>
                <input value="<?= htmlspecialchars($categorie['nom'] ?? '' ) ?>" type="text" 
                class="form-control" id="nom" name="nom" required>
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
            <h3 class="text-center">Catégories existantes</h3>
            <div class="row">
            <?php foreach ($categories as $categorie) { ?>
                <div class="col-md-3 mb-5">
                    <?php require __DIR__ . '/../../components/mini_categorie.php'; ?>
                </div>
            <?php } ?>
            </div>
        </div>                    
    </div>
</div>
<?php
require_once __DIR__ . '/../../components/footer.php';
?>
