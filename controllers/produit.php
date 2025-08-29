<?php
require '../backend/db_connect.php';
require '../controllers/session.php';
require '../class/produit.php';
require '../class/upload.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $produit = new Produit(
    $_POST['nom'],
    $_POST['prix'],
    $_POST['devise'],
    $_POST['quantite'],
    $_POST['categorie'],
    $_POST['description']
    );

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
        } else {
            echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
        }
    } else {
        echo "Erreur de validation : " . implode(', ', $upload->getError());
    } 

    $pdo = connect();

    $data = [
        'nom' => $produit->getNom(),
        'prix' => $produit->getPrix(),
        'devise' => $produit->getDevise(),
        'quantite' => $produit->getQuantite(),
        'description' => $produit->getDescription(),
        'id_categorie' => $produit->getCategorie(),
        'image' => $destination
    ];

    insert($pdo,'t_produits', $data);
    header('Location: ' . BASE_URL . 'crud/produit.php?success=Produit ajouté avec succès !');
    exit();
} else {
    header('Location: ' . BASE_URL . 'crud/produit.php?erreur=Le produit n\'a pas pu être ajouté.' ) ;
    exit();
}
?>