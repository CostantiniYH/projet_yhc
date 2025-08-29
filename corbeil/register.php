<?php
require '../backend/db_connect.php';
require '../class/user.php';
require './session.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Vérifier si les mots de passe correspondent
    if ($_POST['password'] !== $_POST['password2']) {
        header('Location: ' . BASE_URL . 'register.php?message=Les mots de passe ne correspondent pas !');
        exit();
    }
    
    // Sécuriser et nettoyer les entrées utilisateur
    $nom = trim(htmlspecialchars($_POST['nom']));
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $telephone = trim(htmlspecialchars($_POST['telephone']));
    $societe = trim(htmlspecialchars($_POST['societe']));
    $image = $_FILES['image'];

    // Vérifier si un fichier a été envoyé
    $upload = new Upload($_FILES['image']);
    
    $destination = null;
    
    if ($upload->validate()) {
        
        $uploadDir = '../uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crée le dossier avec les bonnes permissions
        }
        if (!file_exists($_FILES['image']['tmp_name'])) {
            die("Erreur : le fichier temporaire n'existe pas.");
        }
        
        $destination = $uploadDir . basename($_FILES['image']["name"]);
        
        if ($upload->moveTo($destination)) {
            echo "Fichier uploadé avec succès ! <br>";
            echo "Chemin du fichier : " . $upload->getFilePath();
        } else {
            echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
        }
    } else {
        echo "Erreur de validation : " . implode(', ', $upload->getError());
    }

    $user = new User($nom, $prenom, $email, $password, $telephone, $societe);

    $error = $user->getError();

    if (!empty($error)) {
        header("Location: ../compte/register.php?erreur=" . urlencode($error[0]));
        exit();
    }

    $pdo = connect();

    $data = [
        'nom' => $user->getNom(),
        'prenom' => $user->getPrenom(),
        'email' => $user->getEmail(),
        'password' => $user->getPassword(),
        'telephone' => $user->getTelephone(),
        'societe' => $user->getSociete(),
        'photo' => $destination
    ];

    insert($pdo, 't_users', $data);

    header('Location: ' . BASE_URL . 'compte/dashboard.php?success=Inscription réussie !');
    exit();

} else {
    header('Location: ' . BASE_URL . 'compte/register.php?erreur=Accès interdit !');
    exit();
}