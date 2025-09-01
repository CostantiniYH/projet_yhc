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
        $baseUrl = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Crée le dossier avec les bonnes permissions
        }
        
        $categorieDir = $uploadDir . $categorie['nom'] . '/';
        $categorieUrl = $baseUrl . $categorie['nom'] . '/';

        if (!is_dir($categorieDir)) {
            mkdir($categorieDir, 0755, true); // Crée le dossier de la catégorie avec les bonnes permissions
        }

        if (!file_exists($_FILES['image']['tmp_name'])) {
            die("Erreur : le fichier temporaire n'existe pas.");
        }

        $fileName = uniqid('img_') . '.' . basename($_FILES['image']['name']);
        $destination = $categorieDir . $fileName;

        if ($upload->moveTo($destination)) {
            echo "Fichier uploadé avec succès ! <br>";
            echo "Chemin du fichier : " . $upload->getFilePath();
            $pdo = connect();
        
            $imageUrl = $categorieUrl . $fileName;
            $data = [
                'nom' => $categorie['nom'],
                'image' => $imageUrl
            ];
            echo $uploadDir; exit;

        
            insert($pdo,'t_categories', $data);
            header('Location: ' . BASE_URL . 'crud/categorie.php?success=Catégorie ajoutée avec succès !');
            exit();
        } else {
            echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
            exit();
        }
    } else {
        echo "Erreur de validation : " . implode(', ', $upload->getError());
        exit();
    } 
} else {
    header( 'Location: ' . BASE_URL . 'crud/categorie.php?erreur=La catégorie n\'a pas pu être ajoutée.' ) ;
    exit();
}
?>