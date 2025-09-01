<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../class/upload.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $categorie = [
        'nom' => $_POST['nom']
        ];

    $upload = new Upload($_FILES['image']);

    if ($upload->validate()) {
        $uploadDir = __DIR__ . '/../uploads/';
        $baseUrl = BASE_URL . 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true); // Crée le dossier avec les bonnes permissions
        }

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
            die("Impossible de créer le dossier upload principal !");
        }

        
        
        $categorieClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $categorie['nom']);
        $categorieDir = $uploadDir . $categorieClean . '/';
        $categorieUrl = $baseUrl . $categorieClean . '/';
        
        if (!is_dir($categorieDir)) {
            mkdir($categorieDir, 0775, true); // Crée le dossier de la catégorie avec les bonnes permissions
        }
        
        if (!is_dir($categorieDir) && !mkdir($categorieDir, 0775, true)) {
            die("Impossible de créer le dossier de la catégorie !");
        }

        if (!file_exists($_FILES['image']['tmp_name'])) {
            die("Erreur : le fichier temporaire n'existe pas.");
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('img_') . '.' . $ext;
        $destination = $categorieDir . $fileName;


        //echo "UploadDir : $uploadDir<br>";
        //echo "CategorieDir : $categorieDir<br>";
        //echo "Destination : $destination<br>";
        //echo "Dossier existe ? " . (is_dir($categorieDir) ? 'Oui' : 'Non') . "<br>";
        //echo "Permissions : " . substr(sprintf('%o', fileperms($categorieDir)), -4);
        //exit;

        if ($upload->moveTo($destination)) {
            echo "Fichier uploadé avec succès ! <br>";
            echo "Chemin du fichier : " . $upload->getFilePath();
            $pdo = connect();
        
            $imageUrl = $categorieUrl . $fileName;
            $data = [
                'nom' => $categorie['nom'],
                'image' => $imageUrl
            ];

        
            insert($pdo,'t_categories', $data);
            header('Location: ' . BASE_URL . 'crud/categorie.php?success=Catégorie ajoutée avec succès !');
            exit();
        } else {
            $erreurMove = "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
            header( 'Location: ' . BASE_URL . 'crud/categorie.php?erreur=' . $erreurMove . '' ) ;
            exit();
        }
    } else {
        $erreurValidation = "Erreur de validation : " . implode(', ', $upload->getError());
        header( 'Location: ' . BASE_URL . 'crud/categorie.php?erreur=' . $erreurValidation . '' ) ;
        exit();
    } 
} else {
    header( 'Location: ' . BASE_URL . 'crud/categorie.php?erreur=La catégorie n\'a pas pu être ajoutée.' ) ;
    exit();
}
?>