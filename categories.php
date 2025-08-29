<?php
require_once __DIR__ . '/backend/db_connect.php';
require_once __DIR__ . '/controllers/session.php';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/class/navbar.php';
require_once __DIR__ . '/class/carousel.php';

$connect = connect();
//$categories = findAll($connect,'t_categories');
$sql = "SELECT c.id, c.nom, c.image, COUNT(p.id) AS nombre_produits
FROM t_categories c
LEFT JOIN t_produits p ON p.id_categorie = c.id
GROUP BY c.id, c.nom
ORDER BY c.nom ASC";
$stmt = $connect->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


$navbar = new Navbar();
$navbar->AddItem('|| YHC ||','index.php', 'left', '', '');
if (isLoggedIn()) {
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', true, '');   
    $navbar->AddItem('Produits liste', 'produits.php', 'dropdown', '', '');
    $navbar->AddItem('Galerie','image.php','dropdown', '', '');
    if (isAdmin()) {
        $navbar->AddItem('', 'admin/dashboard_admin.php', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
    }
    $navbar->AddItem('', 'compte/dashboard.php', 'center', '', 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'crud/categorie.php', 'center', true, 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');
    $navbar->AddItem('','crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('', 'javascript:location.replace("logout.php")', 'right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
} else {
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories', 'categories.php', 'center', true, '');   
    $navbar->AddItem('Produits', 'produits.php', 'center','', '');
    $navbar->AddItem('Galerie','image.php','center', '', '');
    $navbar->AddItem('', 'crud/categorie.php', 'dropdown', '', 'bi bi-grid-3x3-gap-fill');   
    $navbar->AddItem('','crud/produit.php','dropdown', '', 'bi bi-box-fill');
    $navbar->AddItem('', 'crud/image.php', 'dropdown', '', 'bi bi-image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('','compte/login.php','right', '', 'bi bi-person-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Connexion');
    $navbar->AddItem('Inscription','compte/register.php', 'right', '', '');
}
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

    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">Catégories</h1>

    
    <div class="row gy-5 text-center">
        <?php foreach ($categories as $categorie) { ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="2000">
                <?php require __DIR__ . '/components/categorie.php';?>            
            </div>
        <?php } ?>

    </div> 
</div>

<?php
require_once __DIR__ . '/components/footer.php';
?>