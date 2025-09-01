<?php
require_once __DIR__ . '/backend/db_connect.php';
require_once __DIR__ . '/controllers/session.php';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/class/navbar.php';
require_once __DIR__ . '/class/carousel.php';

$connect = connect ();
$produits = getAllWhere ($connect, 't_produits', 'deleted_at IS NULL AND quantite >', [0]);
$id = $_GET['id'] ?? null;

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
    $navbar->AddItem('', 'javascript:location.replace("logout.php")', 'right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
} else {
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

<div class="container mb-5 mt-5">
    <?php require_once __DIR__ . '/components/alerts.php'; ?>
    
    
    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success"> 
        <?php
            $titre = findBy2 ($connect, 'nom, id', 't_categories', 'id',$id);
            
            if (!empty($_GET['id'])) {
                    echo 'Produits ' . htmlspecialchars($titre['nom']);
                   // echo ' (ID: ' . htmlspecialchars($titre['id']) . ')';
            } else {
                echo 'Tous les produits';
            }
        ?>
    </h1>
     
    <div class="row gy-5 text-center">
        <?php 
            if (!empty($_GET['id'])) {
                $id = $_GET['id'];
                $produitID = findBy ($connect, 't_produits', 'id_categorie', $id); 

                foreach ($produitID as $row => $value) {
                ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-duration="2000">
                        <?php require __DIR__ . '/components/card.php'; ?> </br>
                    </div>
                <?php 
                }
            } else {
                
                foreach ($produits as $row => $value) {
                ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-duration="2000" data-bs-toggle="
                    tooltip" data-bs-placement="top" title="<?= $value['nom'] ?>">
                        <?php require __DIR__ . '/components/card.php'; ?> 
                        </br>
                    </div>
                <?php 
                }
            }
        ?>
    </div>   
</div>
<?php
require_once __DIR__ . '/components/footer.php';
?>