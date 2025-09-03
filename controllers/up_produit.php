<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../Controllers/session.php';
require_once __DIR__ . '/../class/produit.php';
require_once __DIR__ . '/../class/upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'] ?? null;  
    $nom = htmlspecialchars($_POST['nom'] ?? '');
    $prix = htmlspecialchars($_POST['prix'] ?? '');
    $devise = htmlspecialchars($_POST['devise'] ?? '');
    $quantite = htmlspecialchars($_POST['quantite'] ?? '');
    $id_categorie = htmlspecialchars($_POST['id_categorie'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    
    $upload = new Upload($_FILES['image']);
    
    $destination = null;
    
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
    
    if ($id) {
        
        $produit = new Produit($nom, $prix, $devise, $quantite, $id_categorie, $description);

        $data = [
            'id' => $id,
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'devise' => $produit->getDevise(),
            'quantite' => $produit->getQuantite(),
            'description' => $produit->getDescription(),
            'id_categorie' => $produit->getCategorie(),
            'image' => $destination
        ];

        $update = update($pdo, 't_produits', $data, 'id', $id);
        
        if ($update) {
            header('Location: ' . BASE_URL . 'admin/dashboard_admin.php?success=Produit modifié avec succès');
            exit();
        } else {
            echo "Erreur lors de la modification du produit !";
        }
    } else {        
        
        $produit = new Produit($nom, $prix, $devise, $quantite, $id_categorie, $description);
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
        
        header('Location: ' . BASE_URL . 'admin/dashboard_admin.php?success=Produit ajouté avec succès !');
        exit();
    } 
}
?>
