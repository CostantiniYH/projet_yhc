<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../class/upload.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $nom = htmlspecialchars($_POST['nom']);
    $categorie = htmlspecialchars($_POST['categorie']);

    $pdo = connect();

    $N_C = findBy2($pdo, 'nom','t_categories', 'id', $categorie);
    $nom_categorie = $N_C['nom'];

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
  
        $categorieClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nom_categorie);
        $categoriePath = $uploadPath . $categorieClean . '/';
        
        if (!is_dir($categoriePath)) {
            mkdir($categoriePath, 0775, true); // Crée le dossier de la catégorie avec les bonnes permissions
        }
        
        if (!is_dir($categoriePath) && !mkdir($categoriePath, 0775, true)) {
            header('Location: ' . BASE_URL . 'Form/Crud/categorie.php?erreur=Impossible de créer le dossier ' . $categorieClean . '!');
            exit();
        }

        if (!file_exists($_FILES['image']['tmp_name'])) {
            die("Erreur : le fichier temporaire n'existe pas.");
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('img_') . '.' . $ext;

        $destination = $uploadPath . $categorieClean . '/' . $fileName;

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

    $categorieDir = $uploadDir . $categorieClean . '/';
    $imageUrl = $categorieDir . $fileName;

    $pdo = connect();

    $data = [
        'nom' => $nom,
        'chemin' => $imageUrl,
        'id_categorie' => $categorie
    ];

    insert($pdo,'t_images', $data);

    header('Location: ' . BASE_URL . 'Form/Crud/image.php?success=Image ajoutée avec succès !');
} else {
    header('Location: ' . BASE_URL . 'Form/Crud/image.php?erreur=L\'image n\'a pas pu être ajouté.' ) ;
}

exit();
?>