<?php
require_once __DIR__ . '/backend/db_connect.php';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/class/navbar.php';
require_once __DIR__ . '/class/carousel.php';
require_once __DIR__ . '/controllers/session.php';


$navbar = new Navbar();
$navbar->AddItem('|| YHC ||','index.php', 'left', '', '');

if (isLoggedIn()) {
    $navbar->AddItem('','index.php','center', true, 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', '', '');   
    $navbar->AddItem('Produits liste', 'produits.php', 'dropdown', '', '');
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
    $navbar->AddItem('','index.php','center', true, 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories', 'categories.php', 'center', '', '');   
    $navbar->AddItem('Produits', 'produits.php', 'center','', '');
    $navbar->AddItem('Galerie','image.php','center', '', '');
    $navbar->AddItem('', 'crud/categorie.php', 'dropdown', '', 'bi bi-grid-3x3-gap-fill');   
    $navbar->AddItem('','crud/produit.php','dropdown', '', 'bi bi-box-fill');
    $navbar->AddItem('', 'crud/image.php', 'dropdown', '', 'bi bi-image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');

    $navbar->AddItem('','compte/login.php','right', '', 'bi bi-person-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Connexion');
    $navbar->AddItem('Inscription','compte/register.php', 'right', '', '');
}

$navbar->render();
?>
<div class="container mb-5 mt-5" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="1000">
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
    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">
        Bienvenue sur || YHC ||</h1>

        
    <div class="carousel-container shadow mb-5 rounded-4" style="overflow: hidden; width: 100%; height: 20rem;"
     data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="1000">

        <?php
            $pdo = connect();
            
            $categories = findAll ($pdo, 't_categories');
            
            $carousel = new Carousel();
            
            $a = [];
            
            foreach ($categories as $categorie) {

                $files = glob('uploads/' . $categorie['nom'] . '/*.{jpg}', GLOB_BRACE);
                
                foreach ($files as $file) {
                    $fileName = basename($file, pathinfo($file, PATHINFO_EXTENSION));
                    $text = ucwords(str_replace(['_', '-', '.'], ' ', $fileName));
                    $a[] = [
                        'link' => $file,
                        'text' => $text
                    ];
                }
            }
            $carousel->Read($a, 1);
        ?>
    </div>            
    <div class="row">
        <div class="col-md-4  mb-5 img-map img-index" style="height: 300px; overflow: hidden;"  data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Produits/magasin.jpg" class="card-img rounded-4 shadow" alt="Produits" usemap="#produitMap">
            <map name="produitMap">
            <area shape="rect" coords="0, 0, 350,250" alt="Produits" href="produits.php">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index " style="height: 300px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Categories/categories.jpg" class="card-img rounded-4 shadow" alt="Categories" usemap="#categorieMap">
            <map name="categorieMap">
            <area shape="rect" coords="0,0, 350,250" alt="Categories" href="categories.php">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index" style="height: 300px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Galerie/galerie.jpg" class="card-img rounded-4 shadow" alt="Galerie" usemap="#galerieMap">
            <map name="galerieMap">
            <area shape="rect" coords="0,0, 350,250" alt="Galerie" href="image.php">
            </map>
        </div>
        <div class="mb-5 img-map img-index" style="height: 300px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <div class="card-img-top card-img rounded-top">
                <?php
                    $carousel = new Carousel();

                    $a = [];
                    foreach ($categories as $categorie) {
                        $files = glob('./uploads/' . $categorie['nom'] . '/*.{jpg}', GLOB_BRACE);
                        foreach ($files as $file) {
                            $fileName = basename($file, pathinfo($file, PATHINFO_EXTENSION));
                            $text = ucwords(str_replace(['_', '-', '.'], ' ', $fileName));
                            $a[] = [
                                'link' => $file,
                                'text' => $text
                            ];
                        }
                    }
                    $carousel->Read($a, 2);
                ?>
            </div>
            <map name="map<?= $categorie['id']; ?>">
                <area shape="rect" coords="0,0,350,200" href="<?= BASE_URL ?>produits.php?id=<?= $categorie['id']; ?>">
            </map>
        </div>
    </div>    
</div>
<?php
require_once __DIR__ . '/components/footer.php';
?>                                    