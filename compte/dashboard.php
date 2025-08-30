<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../class/navbar.php';

require_login();

$connect = connect();

if (!isset($_SESSION['user'])) {
    die("Erreur : utilisateur non connecté.");
} 

$user = $_SESSION['user'];

$navbar = new Navbar();
    $navbar->AddItem('|| YHC ||','index.php', 'left', '', '');
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', '', '');   
    $navbar->AddItem('Produits liste', 'produits.php', 'dropdown', '', '');
    $navbar->AddItem('Galerie','image.php','dropdown', '', '');
        if (isAdmin()) {
            $navbar->AddItem('', 'admin/dashboard_admin.php', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
        }
    $navbar->AddItem('', 'dashboard.php', 'center', true, 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('','crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('','javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
$navbar->render();
?>

<div class="container mt-2">
    <?php require_once __DIR__ . '/../components/alerts.php'; ?>

    <p class="mt-2 border border-2 border-success p-3 rounded mb-3">Vous êtes connecté en tant que <?php echo $user['email']; ?></p>
    <h1 class="shadow rounded p-4">Dashboard <?php echo $user['nom']; ?> <?php echo $user['prenom']; ?></h1>

    <img class="bandeau rounded-4 shadow" src="<?php echo $user['photo']; ?>">
        <table class="table row mt-2">
            <tr class="table-header">
                <th>Nom</th>
                <th>Prénom</th>
                <th class="">Email</th>
                <th class="">Téléphone</t>
                <th class="">Société</th>                
            </tr>
            <tr>
                <td> <?= $user['nom']?> </td>
                <td> <?= $user['prenom']?> </td>
                <td> <?= $user['email']; ?> </td>
                <td> <?= $user['telephone']; ?> </td>
                <td> <?= $user['societe']; ?> </td>
            </tr>
        </table>
    </div>
</div>
<?php 
require_once __DIR__ . '/../components/footer.php'
?>