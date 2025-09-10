<?php
require_once __DIR__ . '/../../class/user.php';
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../class/upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'] ?? null;  
    $nom = trim(htmlspecialchars($_POST['nom']));
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password2']);
    $telephone = trim(htmlspecialchars($_POST['telephone']));
    $societe = trim(htmlspecialchars($_POST['societe']));
    
    if ($password !== $passwordConfirm) {
        header('Location: ' . BASE_URL . 'Form/Compte/register.php?message=Les mots de passe ne correspondent pas !');
        exit();
    }
    
    $user = new User($nom, $prenom, $email, $password, $telephone, $societe);
    
    $error = $user->getError();
    
    if (!empty($error)) {
        header('Location: ' . BASE_URL . 'Form/Compte/register.php?erreur=' . urlencode($error[0]));
        exit();
    }
    
    $upload = new Upload($_FILES['image']);
    if ($upload->validate()) {
        $uploadDir = 'uploads/';
        $uploadPath = __DIR__ . '/../../uploads/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true); // Crée le dossier avec les bonnes permissions
        }

         if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775,
         true)) {
            header('Location: ' . BASE_URL . 'Form/Crud/categorie.php?erreur=Impossible de créer le dossier 
            uploads principal !');
            exit();
        }

        if (!is_writable($uploadPath)) {
            die("Erreur : le dossier uploads n'est pas inscriptible par PHP !");
        }

        $userDir = $user->getNom() . '_' . $user->getPrenom();
  
        $userClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $userDir);
        $userPath = $uploadPath . $userClean . '/';
        
        if (!is_dir($userPath)) {
            mkdir($userPath, 0775, true); // Crée le dossier de la catégorie avec les bonnes permissions
        }
        
        if (!is_dir($userPath) && !mkdir($userPath, 0775, true)) {
            header('Location: ' . BASE_URL . 'Form/Compte/register.php?erreur=Impossible de créer le dossier ' . $categorieClean . '!');
            exit();
        }

        if (!file_exists($_FILES['image']['tmp_name'])) {
            die("Erreur : le fichier temporaire n'existe pas.");
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('img_') . '.' . $ext;

        $destination = $userPath . '/' . $fileName;
        
        if ($upload->moveTo($destination)) {
            echo "Fichier uploadé avec succès ! <br>";
            echo "Chemin du fichier : " . $upload->getFilePath();
        } else {
            echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
            exit();
        }
    } else {
        echo "Erreur de validation : " . implode(', ', $upload->getError());
        exit();
    } 
    
    $imageUrl = $uploadDir . $userClean . '/' . $fileName;
    
    $data = [
        'nom' => $user->getNom(),
        'prenom' => $user->getPrenom(),
        'email' => $user->getEmail(),
        'password' => $user->getPassword(),
        'telephone' => $user->getTelephone(),
        'societe' => $user->getSociete(),
        'photo' => $imageUrl
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
        $pdo = connect();    
        
        insert($pdo,'t_users', $data);
        
        header('Location: ' . BASE_URL . 'compte/dashboard.php?success=Utilisateur ajouté avec succès !');
        exit();
    } 
} else {
    header( 'Location: ' . BASE_URL . 'Form/Compte/register.php?erreur=Le compte n\'a pas pu être ajouté.' ) ;
    exit();
}

?>
