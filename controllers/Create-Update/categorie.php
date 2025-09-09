<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../class/upload.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $categorie = [
        'nom' => $_POST['nom']
        ];

    $upload = new Upload($_FILES['image']);

    if ($upload->validate()) {
        $uploadDir = 'uploads/';
        $uploadPath = __DIR__ . '/../../uploads/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true); 
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
  
        $categorieClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $categorie['nom']);
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
        
        
        //echo "UploadDir : $uploadDir<br>";
        //echo "CategorieDir : $categorieDir<br>";
        //echo "Destination : $destination<br>";
        //echo "Dossier existe ? " . (is_dir($categorieDir) ? 'Oui' : 'Non') . "<br>";
        //echo "Permissions : " . substr(sprintf('%o', fileperms($categorieDir)), -4);
        //exit;
        
        if ($upload->moveTo($destination)) {
            echo "Fichier uploadé avec succès ! <br>";
            echo "Chemin du fichier : " . $upload->getFilePath();
            
            $categorieDir = $uploadDir . $categorieClean . '/';
            $imageUrl = $categorieDir . $fileName;
            $data = [
                'nom' => $categorie['nom'],
                'image' => $imageUrl
            ];
            
            $pdo = connect();
            
            insert($pdo,'t_categories', $data);
            header('Location: ' . BASE_URL . 'Form/Crud/categorie.php?success=Catégorie ajoutée avec succès !');
            exit();
        } else {
            $erreurMove = "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
            header('Location: ' . BASE_URL . 'crud/categorie.php?erreur=' . $erreurMove . '' ) ;
            exit();
        }
    } else {
        $erreurValidation = "Erreur de validation : " . implode(', ', $upload->getError());
        header('Location: ' . BASE_URL . 'Form/Crud/categorie.php?erreur=' . $erreurValidation . '' ) ;
        exit();
    } 
} else {
    header( 'Location: ' . BASE_URL . 'Form/Crud/categorie.php?erreur=La catégorie n\'a pas pu être ajoutée.' ) ;
    exit();
}
?>