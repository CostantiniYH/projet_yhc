<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../class/navbar.php';

$navbar = new Navbar();
$navbar->AddItem('|| YHC ||','index.php', 'left', '', '');
$navbar->AddItem('Accueil','index.php','center', '', '');
$navbar->AddItem('Inscription','compte/register.php','right', '', '');

$navbar->render() ;
?>

<div class="container mt-5">
    <?php require_once __DIR__ . '/../../components/alerts.php'; ?>
    
    <div class="row">
    <form action="<?= BASE_URL ?>Controllers/login.php" method="post" class="p-5 col-md-6 offset-3 mb-5 p-2 shadow-lg rounded-4 border border-1 border-success">
        <h2 class="text-center">Connexion</h2>
        <div class="form-group mb-2">
            <label for="email">Email :</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mb-2">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group m-4 container">
                <input type="submit" class="col-md-6 btn btn-primary" value="Se connecter">
            </div>
    </form>
    </div>
</div>

<?php

require_once __DIR__ . '/../../components/footer.php';
?>


