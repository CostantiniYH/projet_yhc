<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../class/upload.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $image = [
        'nom' => $_POST['nom'], 
        'id_categorie' => $_POST['categorie']
        ];

    $upload = new Upload($_FILES['image']);

    if ($upload->validate()) {
        $uploadDir = '' . BASE_URL . 'uploads/';
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
            $pdo = connect();
        
            $data = [
                'nom' => $image['nom'],
                'chemin' => $destination,
                'id_categorie' => $image['id_categorie']
            ];
        
            insert($pdo,'t_images', $data);
            header('Location: ' . BASE_URL . 'crud/image.php?success=Image ajoutée avec succès !');
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
    header( 'Location: ' . BASE_URL . 'crud/image.php?erreur=L\'image n\'a pas pu être ajouté.' ) ;
    exit();
}
?>