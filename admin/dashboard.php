<?php
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../class/navbar.php';

require_login();

if (isAdmin()) {
    getUserSession();
    } else {
    header('Location: ' . BASE_URL . 'index.php?erreur=L\'accès est restraint.');
    exit();
}

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

$pdo = connect();

$user = getAll($pdo, 't_users');
$categorie = getAll($pdo, 't_categories');

function produitDash($pdo) {
    try {
    $sql = "SELECT p.*, c.nom AS nom_categorie FROM t_produits p
    INNER JOIN t_categories c ON p.id_categorie = c.id WHERE deleted_at IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);
    $produit = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $produit;
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
} 
$produit = produitDash($pdo);
$image = getAll2($pdo, 't_images');

if (!isset($_SESSION['user'])) {
    die("Erreur : utilisateur non connecté.");
} 


$navbar = new Navbar();
$navbar->AddItem('|| YHC ||','index.php', 'left', '', '');
$navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
$navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', '', '');   
$navbar->AddItem('Produits liste', 'produits.php', 'dropdown', '', '');
$navbar->AddItem('Galerie','image.php','dropdown', '', '');
$navbar->AddItem('', 'admin/dashboard.php', 'center', true, 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
$navbar->AddItem('', 'compte/dashboard.php', 'center', '', 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
$navbar->AddItem('', 'Form/Crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
$navbar->AddItem('', 'Form/Crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
$navbar->AddItem('', 'Form/Crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
$navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
$navbar->AddItem('', 'javascript:location.replace(BASE_URL + "logout.php")', 'right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
$navbar->render();

?>
<div class="container mt-2">
    <?php require_once __DIR__ . '/../components/alerts.php'; ?>

    <p class="mt-2 border border-2 border-success p-3 rounded mb-3">Bonjour Administrateur : <?= $_SESSION['user']['email']; ?></p>
    <h1 class="shadow rounded p-4 border-start border-end border-2 border-success">Dashboard admin de : <?= $_SESSION['user']['nom']; ?> <?php echo $_SESSION['user']['prenom']; ?></h1>

    <?php
        if (isset($_GET['deploy']) && isset($_SESSION['deploy_result'])) {
        $result = $_SESSION['deploy_result'];
        echo '<div style="border:1px solid #ccc;padding:10px;margin:10px 0;background:#f9f9f9">';
        $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
        $title = $result['success'] ? '✅ Déploiement réussi' : '❌ Erreur lors du déploiement';

        echo '<div class="alert ' . $alertClass . ' mt-3">';
        echo '<h4>' . $title . '</h4>';
        echo '<pre style="max-height:300px;overflow:auto;">';
        foreach ($result['log'] as $line) {
            echo htmlspecialchars($line) . "\n";
        }
        echo '</pre>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        echo '</div>';
        unset($_SESSION['deploy_result']); // nettoyage après affichage
    }

        if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['REMOTE_ADDR'] === '127.0.0.1') { 
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    ?>
        <div class="mb-3 p-3 border border-2 border-info rounded shadow text-center">
            <form method="POST" action="<?= BASE_URL ?>controllers/deploy.php">
                <h3>Cliquer ici pour lancer le déployer</h3>
                <label for="remote">Sélectionner un remote :</label>
                <div class="d-flex col-md-3 mx-auto mt-3 mb-3">
                    <select class=" mx-auto form-select" name="remote" id="remote" aria-label="Defaullt select example">
                        <option value="origin">origin</option>
                        <option value="github">github</option>
                        <option value="wan">wan</option>
                        <option value="mobile">mobile</option>
                    </select>
                </div>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <button type="submit" class="btn btn-success bi bi-cloud-arrow-up-fill" > Déployer</button>
            </form>
        </div>
    <?php
    }
    ?>

    <img class="bandeau rounded-4 shadow" src="<?= BASE_URL . $_SESSION['user']['photo']; ?>">
    <div class="d-flex flex-column row">    
        <div class="row row-cols row-cols g-3">
            <div class="mt-5 p-4 rounded-4 shadow border-start border-2 border-danger table-responsive">
                <h1 class="fs-2 d-block">Table utilisateurs</h1>    
                <table class="table mt-2 w-100">
                    <tr>
                        <th>ID</th>
                        <?php foreach ($user as $key => $u) { ?>
                            <td> <?= $u['id'] ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <?php foreach ($user as $key => $u) { ?> 
                            <td> <?= $u['nom']?> </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Prénom</th>
                        <?php foreach ($user as $key => $u) { ?> 
                            <td> <?= $u['prenom']?> </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <?php foreach ($user as $key => $u) { ?> 
                            <td> <?= $u['email']; ?> </td>
                        <?php } ?>
                    </tr>
                    <tr>                        
                        <th>Téléphone</th>
                        <?php foreach ($user as $key => $u) { ?> 
                            <td> <?= $u['telephone']; ?> </td>
                        <?php } ?>
                    </tr>
                    <tr>                        
                        <th>Société</th>  
                        <?php foreach ($user as $key => $u) { ?> 
                            <td> <?= $u['societe']; ?> </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Photo profil</th> 
                        <?php foreach ($user as $key => $u) { ?> 
                            <td> <img width="100" src="<?= BASE_URL . $u['photo']; ?>"></td>
                        <?php } ?>
                    </tr>
                    <tr>                        
                        <th>Action</th>
                        <?php foreach ($user as $key => $u) { ?> 
                            <td>
                                <a href="#.php?id=<?= $u['id']; ?>" 
                                    class="btn btn-primary bi bi-eye"></a>
                                <a href="<?= BASE_URL ?>Form/Compte/register.php?id=<?= $u['id']; ?>" 
                                    class="btn btn-warning bi bi-pencil"></a>
                                <a href="<?= BASE_URL ?>Controllers/Delete/user.php?id=<?= $u['id']; ?>" 
                                class="btn btn-danger bi bi-trash" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')"></a>
                            </td>
                        <?php } ?>
                    </tr>
                </table>
            </div>
            <div class=" h-50  mt-5 p-4 rounded-4 shadow  border-start border-2 border-danger table-responsive">
                <h1 class="fs-2">Table catégories</h1>
                <table class="table mt-2 w-100">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($categorie as $row => $c) { ?> 
                        <tr>
                            <td><?= $c['id']; ?></td>
                            <td><?= $c['nom']; ?></td>
                            <td><?= $c['image']; ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>produits.php?id=<?= $c['id']; ?>" 
                                    class="btn btn-primary bi bi-eye"></a>
                                <a href="<?= BASE_URL ?>Form/Crud/categorie.php?id=<?= $c['id']; ?>" 
                                    class="btn btn-warning bi bi-pencil"></a>
                                <a href="<?= BASE_URL ?>controllers/Delete/categorie.php?id=<?= $c['id']; ?>" 
                                class="btn btn-danger bi bi-trash" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="mt-5 p-4 rounded-4 overflow-auto shadow border-start border-2 border-danger table-
            responsive" style="max-height: 300px;">
                <h1 class="fs-2">Table produits</h1>
                <table class="table mt-2 w-100">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Devise</th>
                        <th>Quantité</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Image</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($produit as $row => $p) { ?> 
                        <tr>
                            <td><?= $p['id']; ?></td>
                            <td><?= $p['nom']; ?></td>
                            <td><?= $p['prix']; ?></td>
                            <td><?= $p['devise']; ?></td>
                            <td><?= $p['quantite']; ?></td>
                            <td><?= $p['description']; ?></td>
                            <td><?= $p['nom_categorie']; ?></td>
                            <td><?= $p['image']; ?></td>
                            <td><?= $p['id']; ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>produit_one.php?id=<?= $p['id']; ?>" 
                                    class="btn btn-primary bi bi-eye"></a>
                                <a href="<?= BASE_URL ?>Form/Crud/produit.php?id=<?= $p['id']; ?>" 
                                    class="btn btn-warning bi bi-pencil"></a>
                                <a href="<?= BASE_URL ?>controllers/Delete/produit.php?id=<?= $p['id']; ?>" 
                                class="btn btn-danger bi bi-trash" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class=" h-50  mt-5 p-4 rounded-4 shadow  border-start border-2 border-danger table-responsive">
                <h1 class="fs-2">Table galerie</h1>
                <table class="table mt-2 w-100">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>Catégorie</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($image as $row => $i) { ?> 
                        <tr>
                            <td><?= $i['id']; ?></td>
                            <td><?= $i['nom']; ?></td>
                            <td><?= $i['image']; ?></td>
                            <td><?= $i['nom_categorie']; ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>image.php?id=<?= $i['id']; ?>" 
                                    class="btn btn-primary bi bi-eye"></a>
                                <a href="<?= BASE_URL ?>Form/Crud/image.php?id=<?= $i['id']; ?>" 
                                    class="btn btn-warning bi bi-pencil"></a>
                                <a href="<?= BASE_URL ?>controllers/Delete/image.php?id=<?= $i['id']; ?>" 
                                class="btn btn-danger bi bi-trash" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    fetch('BASE_URL + controllers/deploy.php', { method: 'POST', body: new URLSearchParams({ token: 'MON_TOKEN' }) })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                // Redirection après succès
                window.location.href = 'BASE_URL + admin/dashboard.php';
            } else {
                alert('Erreur pendant le déploiement');
            }
    });
</script>
<?php 
require_once __DIR__ . '/../components/footer.php'
?>