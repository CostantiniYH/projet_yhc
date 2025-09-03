<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../Controllers/session.php';


$id = $_GET['id'];

if ($id) {
    $connect = connect();
    $produit = findBy1($connect, 't_produits', 'id', $id);
    $produit = $produit[0] ?? null;
    $produitNom = $produit['nom'];
    
    if ($produit) {
        delete($connect, 't_produits', $id, true);
       // var_dump(delete($connect, 't_produits', $id, true));
       // exit();
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard_admin.php?success=' . urlencode("Produit $produitNom supprimé avec succès !"));
        } else {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?success=' . urlencode("Votre produit $produitNom a été supprimé avec succès !"));
        }
        exit();
    } else {
        header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=Produit introuvable.');
        exit();
    }
} else {
    header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=ID produit manquant.');
    exit();
}
?>