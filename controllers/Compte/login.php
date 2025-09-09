<?php
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../class/user.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = connect();

$value = findBy2( $pdo, '*', 't_users', 'email', $email);

//var_dump($value);
//exit();

if (is_array($value) && count($value) == 0) {
    header('Location: ' . BASE_URL . 'Form/Compte/login.php?erreur=L\'utilisateur n\'existe pas.');
    exit();
}

$password_hash = $value['password'];

    if (User::verifyPassword($password, $password_hash)) {
        loginUser($value);
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard.php?success=Vous êtes connecté en tant qu\'administrateur.');
            exit();
        } 
        header ('Location: ' . BASE_URL . 'compte/dashboard.php?success=Connexion réussi !');
        exit();
    } else {
        header('Location: ' . BASE_URL . 'Form/Compte/login.php?erreur=Le mot de passe est incorrecte !');
        exit();
    }

?>