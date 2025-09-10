<?php
require_once __DIR__ . '/../../controllers/session.php';
require_once __DIR__ . '/../../class/produit.php';
require_once __DIR__ . '/../../class/upload.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = htmlspecialchars($_POST['nom']);
    $prix = htmlspecialchars($_POST['prix']);
    $devise = htmlspecialchars($_POST['devise']);
    $quantite = htmlspecialchars($_POST['quantite']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $description = htmlspecialchars($_POST['description']);
    
    $pdo = connect();

    $N_C = findBy2($pdo, 'nom','t_categories', 'id', $categorie);
    $nom_categorie = $N_C['nom'];
   
    $produit = new Produit($nom, $prix, $devise, $quantite, $categorie, $description);

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

        $destination = $categoriePath . '/' . $fileName;

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
    
    $data = [
        'nom' => $produit->getNom(),
        'prix' => $produit->getPrix(),
        'devise' => $produit->getDevise(),
        'quantite' => $produit->getQuantite(),
        'description' => $produit->getDescription(),
        'id_categorie' => $produit->getCategorie(),
        'image' => $imageUrl
    ];

    insert($pdo,'t_produits', $data);
    header('Location: ' . BASE_URL . 'Form/Crud/produit.php?success=Produit ajouté avec succès !');
    exit();
} else {
    header('Location: ' . BASE_URL . 'Form/Crud/produit.php?erreur=Le produit n\'a pas pu être ajouté.' ) ;
    exit();
}
?>