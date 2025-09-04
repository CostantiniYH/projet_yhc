<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../Controllers/session.php';
require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../class/navbar.php';

$pdo = connect();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$user = null;
if ($id) {
    $user = findBy1 ($pdo, 't_users', 'id', $id);
    $user = $user[0] ?? null;
}

$navbar = new Navbar();
$navbar->AddItem('|| YHC ||','index.php', 'left', '','');
$navbar->AddItem('Accueil','index.php','center', '','');
$navbar->AddItem('Connexion','Form/Compte/login.php','right', '','');
$navbar->render();

?>
<div class="container mt-5">
    <?php require_once __DIR__ . '/../../components/alerts.php'; ?>

    <div class="row">
        <form action="<?= BASE_URL ?>Controllers/Compte/register.php" method="post" class="p-5 col-md-6 offset-3 mb-5 p-2 shadow-lg
        rounded-4 border border-1 border-success" enctype="multipart/form-data">
            <h2 class="text-center"><?= $user ? 'Modifier votre profil' : 'Inscription' ?></h2>
            <div class="form-group mb-2">
                <input type="hidden" name="id"  value="<?= $user['id'] ?? '' ?>">
                <label for="nom">Nom :</label> 
                <input value="<?= htmlspecialchars($user['nom'] ?? '') ?>" type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group mb-2">
                <label for="prenom">Prénom :</label>
                <input value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" type="text"class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group mb-2">
                <label for="telephone">Numéro de téléphone :</label>
                <input value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" type="telephone" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="form-group mb-2">
                <label for="societe">Société :</label>
                <input value="<?= htmlspecialchars($user['societe'] ?? '') ?>" type="text" class="form-control" id="societe" name="societe" required>
            </div>
            <div class="form-groupe mb-2">
                <label for="image">Photo de profil</label>
                <input value="" type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group mb-2">
                <label for="email">Email :</label>
                <input value="<?= htmlspecialchars($user['email'] ?? '') ?>" type="email" class="form-control" id="email" name="email" required>
            </div>

            <?php if (!$id) { ?>
                <div class="form-group mb-2">
                    <label for="password">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group mb-2">
                    <label for="password2">Confirmation mot de passe :</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="S'inscrire">
                </div>
            <?php } else { ?>        

            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Modifier les informations">
            </div>
            <?php } ?>
        </form>
    </div>
</div>

<?php

require_once __DIR__ . '/../../components/footer.php';
?>


