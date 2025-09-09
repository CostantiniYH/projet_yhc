<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../class/user.php';
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../class/upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Vérifier si les mots de passe correspondent
    if ($_POST['password'] !== $_POST['password2']) {
        header('Location: ' . BASE_URL . 'Form/Compte/register.php?message=Les mots de passe ne correspondent pas !');
        exit();
    }
    
    // Sécuriser et nettoyer les entrées utilisateur
    $id = $_POST['id'] ?? null;  
    $nom = trim(htmlspecialchars($_POST['nom']));
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $telephone = trim(htmlspecialchars($_POST['telephone']));
    $societe = trim(htmlspecialchars($_POST['societe']));

    
    
    $user = new User($nom, $prenom, $email, $password, $telephone, $societe);
    
    $error = $user->getError();
    
    if (!empty($error)) {
        header('Location: ' . BASE_URL . 'Form/Compte/register.php?erreur=' . urlencode($error[0]));
        exit();
    }

    // Vérifier si un fichier a été envoyé
    $upload = new Upload($_FILES['image']);
    
    $destination = null;
    
    if ($upload->validate()) {
        
        $uploadDir = 'uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crée le dossier avec les bonnes permissions
        }
        if (!file_exists($_FILES['image']['tmp_name'])) {
            die("Erreur : le fichier temporaire n'existe pas.");
        }
        
        $destination = $uploadDir . basename($_FILES['image']["name"]);
        
        if ($upload->moveTo($destination)) {
            //echo "Fichier uploadé avec succès ! <br>";
            echo "Chemin du fichier : " . $upload->getFilePath();
        } else {
            echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
        }
    } else {
        echo "Erreur de validation : " . implode(', ', $upload->getError());
    }
    
    $data = [
        'nom' => $user->getNom(),
        'prenom' => $user->getPrenom(),
        'email' => $user->getEmail(),
        'password' => $user->getPassword(),
        'telephone' => $user->getTelephone(),
        'societe' => $user->getSociete(),
        'photo' => $destination
    ];
    
    if (!empty($id)) {
        
        $data['id'] = $id;
        
        $pdo = connect();    
        
        $update = update($pdo, 't_users', $data, 'id', $id);

        if ($update) {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?success=Votre profil a été mis à jour avec succès !');
            exit();
        } else {
            echo "Erreur lors de la modification de votre profil !";
            exit();
        }
    } else {   
        
        insert($pdo,'t_users', $data);
        
        header('Location: ' . BASE_URL . 'compte/dashboard.php?success=Utilisateur ajouté avec succès !');
        exit();
    } 
}
?>
