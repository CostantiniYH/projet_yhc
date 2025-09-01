<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../class/navbar.php';

require_login();
$connect = connect(); 
$categories = getAll($connect, 't_categories');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide.");
}

$id = intval($_GET['id']); // Sécurisation

$up_produit = findBy($connect, 't_produits', 'id', $id);

if (!$up_produit || empty($up_produit)) {
    die("Produit introuvable.");
}

$up_produit = $up_produit[0] ?? null; // Vérifier si le produit existe


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
    $navbar->AddItem('','crud/produit.php','center', true, 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('','javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
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
            
    <div class="row gap-4">
        <form action="<?= BASE_URL ?>controllers/up_produit.php" method="post" enctype="multipart/form-data" 
        class="col-md-5 rounded-4 shadow p-5 border border-2 border-warning" 
        data-aos="fade-in-zoom" data-aos-duration="1500">
        
            <h2 class="text-center">Modifiez votre produit</h2>
            <div class="form-group">
                <input type="hidden" name="id" value="<?= $up_produit['id'] ?>">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= $up_produit['nom'] ?>">
            </div><br>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" class="form-control" id="prix" name="prix" value="<?= $up_produit['prix'] ?>">
            </div><br>
            <div class="form-group">
                <label for="devise">Devise</label>
                <select class="form-control" id="devise" name="devise">
                    <option value="€" <?= $up_produit['devise'] == '€' ? ' selected' : '' ?>>€</option>
                    <option value="$" <?= $up_produit['devise'] == '$' ? 'selected' : '' ?>>$</option>
                    <option value="£" <?= $up_produit['devise'] == '£' ? ' selected' : '' ?>>£</option>
                </select>
            </div><br>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" class="form-control" id="quantite" name="quantite" value="<?= $up_produit['quantite'] ?>">
            </div>
            <br><br>
            <div class="form-group">
                <label for="id_categorie">Catégorie</label>
                <select class="form-select" id="id_categorie" name="id_categorie">
                <option value="<?= $up_produit['id_categorie'];?>" selected><?= $up_produit['nom_categorie']; ?></option>
                    <?php                    
                    foreach ($categories as $categorie) : ?>
                        <option value="<?= $categorie['id']; ?>">
                            <?php echo $categorie['nom']; ?>
                        </option>
                    <?php endforeach; ?>    
                </select>
            </div><br>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" value="<?= $up_produit['image'] ?>">
            </div><br>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" value="<?= 
                $up_produit ['description']?>"><?= $up_produit ['description']?></textarea> 
            </div><br>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
        <div class="col shadow rounded-4 p-3 border border-1 border-warning">
            <h2>Produit à modifier</h2>            
            <?php 
                $value = $up_produit;
                require_once __DIR__ . '/../components/card_modifie.php';       
            
            ?>
        </div>
    </div>
</div>



<?php
require_once __DIR__ . '/../components/footer.php';
?>