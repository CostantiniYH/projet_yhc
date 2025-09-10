<?php
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
            $navbar->AddItem('', 'admin/dashboard.php', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
        }
    $navbar->AddItem('', 'compte/dashboard.php', 'center', true, 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'Form/Crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('', 'Form/Crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'Form/Crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('', 'javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
$navbar->render();
?>

<div class="container mt-2">
    <?php require_once __DIR__ . '/../components/alerts.php'; ?>

    <p class="mt-2 border border-2 border-success p-3 rounded mb-3">Vous êtes connecté en tant que <?= $user['email']; ?></p>
    <h1 class="shadow rounded p-4">Dashboard <?= $user['nom']; ?> <?= $user['prenom']; ?></h1>

    <img class="bandeau rounded-4 shadow" src="<?= BASE_URL . $user['photo']; ?>">
    <div class="d-flex row mt-4 shadow rounded border border-1 border-success table-responsive">
        <table class="table row mt-2 shadow col-md-4 table-responsive">
            <h3>Vos informations</h3>
            <tr class="">
                <th>Nom</th>
                <td> <?= $user['nom']?> </td>
            </tr>
            <tr>
                <th>Prénom</th>
                <td> <?= $user['prenom']?> </td>
            </tr>
            <tr>
                <th class="">Email</th>
                <td> <?= $user['email']; ?> </td>
            </tr>
            <tr>    
                <th class="">Téléphone</t>
                <td> <?= $user['telephone']; ?> </td>
            </th>
            <tr>
                <th class="">Société</th>  
                <td> <?= $user['societe']; ?> </td>
            </tr>
            <tr>
                <th>Photo profil</th>              
                <td> <img width="100" class="rounded" src="<?= BASE_URL . $user['photo']; ?>"> </td>
            </tr>
        </table>
    </div>
</div>
<?php 
require_once __DIR__ . '/../components/footer.php'
?>