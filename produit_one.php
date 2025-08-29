<?php
require_once __DIR__ . '/backend/db_connect.php';
require_once __DIR__ . '/controllers/session.php';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/class/navbar.php';

$connect = connect();

$id = $_GET['id'];

$one = findBy ($connect, 't_produits', 'id', $id);

$one = $one[0];


$navbar = new Navbar();
$navbar->AddItem('|| YHC ||','index.php', 'left', '', '');

if (isLoggedIn()) {
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', '', '');   
    $navbar->AddItem('Produits liste', 'produits.php', 'dropdown', true, '');
    $navbar->AddItem('Galerie','image.php','dropdown', '', '');
    if (isAdmin()) {
        $navbar->AddItem('', 'admin/dashboard_admin.php', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
    }
    $navbar->AddItem('', 'compte/dashboard.php', 'center', '', 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('','crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');

    $navbar->AddItem('', 'javascript:location.replace("logout.php")', 'right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');} else {
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories', 'categories.php', 'center', '', '');   
    $navbar->AddItem('Produits', 'produits.php', 'center',true, '');
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

<div class="container">
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
    <div class="row m-5 shadow-lg p-4 rounded-4 border-start border-top border-bottom border-primary border-3">
        <h1 class="">Produit</h1>
        <div class="col-12 m-4">
            <?php
                require_once __DIR__ . '/components/one_card.php';
            ?>
        </div>                  
    </div>
</div>

<?php
require_once __DIR__ . '/components/footer.php';
?>