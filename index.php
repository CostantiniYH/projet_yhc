<?php
require_once __DIR__ . '/controllers/session.php';
require_once __DIR__ . '/backend/db_connect.php';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/class/navbar.php';
require_once __DIR__ . '/class/carousel.php';


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
    
    <?php require_once __DIR__ . '/components/alerts.php'; ?>

    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">
        Bienvenue sur || YHC ||</h1>

        
    <div class="carousel-container shadow mb-5 rounded-4" style="overflow: hidden; width: 100%; height: 20rem;"
     data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="1000">

        <?php
            $pdo = connect();
            
            $categories = getAll ($pdo, 't_categories');
            
            $carousel = new Carousel();
            
            $a = [];
            
            foreach ($categories as $categorie) {

                $files = glob('uploads/' . $categorie['nom'] . '/*.{jpg}', GLOB_BRACE);
                
                foreach ($files as $file) {
                    $fileName = basename($file, pathinfo($file, PATHINFO_EXTENSION));
                    $text = ucwords(str_replace(['_', '-', '.'], ' ', $fileName));
                    $a[] = [
                        'link' => $file,
                        'text' => $text,
                        'id' => $categorie['id']
                    ];
                }
            }
            $carousel->Read($a, 1);
        ?>
    </div>            
    <div class="row">
        <div class="col-md-4  mb-5 img-map img-index" style="height: 200px; overflow: hidden;"  data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Produits/magasin.jpg" class="card-img rounded-4 shadow" alt="Produits" usemap="#produitMap">
            <map name="produitMap">
            <area shape="rect" coords="0, 0, 350,250" alt="Produits" href="produits.php">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index " style="height: 200px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Categories/categories.jpg" class="card-img rounded-4 shadow" alt="Categories" usemap="#categorieMap">
            <map name="categorieMap">
                <area shape="rect" coords="0,0, 350,250" alt="Categories" href="categories.php">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index" style="height: 200px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Galerie/galerie.jpg" class="card-img rounded-4 shadow" alt="Galerie" usemap="#galerieMap">
            <map name="galerieMap">
                <area shape="rect" coords="0,0, 350,250" alt="Galerie" href="image.php">
            </map>
        </div>
        <div class="mb-5 img-map img-index rounded-4" style="height: 300px; overflow: hidden;" data-aos="flip-up" data-aos-duration="1500" data-aos-delay="500">
            <div class="card-img-top card-img shadow">
                <?php
                    $carousel = new Carousel();

                    $a = [];

                    foreach ($categories as $categorie) {
                        $file = $categorie['image'];
                        $text = $categorie['nom'];
                        $id_categorie = $categorie['id'];
                        $a[] = [
                            'link' => $file,
                            'text' => $text,
                            'id' => $id_categorie
                        ];
                    }  

                    $carousel->Read($a, 2);
                ?>
            </div>
            <?php foreach ($a as $item) { ?>
                <map name="map<?= $item['id']; ?>">
                    <area shape="rect" coords="400,0,800,400" href="<?= BASE_URL ?>produits.php?id=<?= $item['id']; ?>">
                </map>
            <?php } ?>
        </div>
    </div>    
</div>
<?php
require_once __DIR__ . '/components/footer.php';
?>                                    