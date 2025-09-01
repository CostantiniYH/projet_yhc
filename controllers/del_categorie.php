<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';


$id = $_GET['id'];

if ($id) {
    $pdo = connect();
    $categorie = findBy1($pdo, 't_categories', 'id', $id);
    $categorie = $categorie[0] ?? null;
    $categorieNom = $categorie['nom'];
    
    if ($categorie) {
        delete($pdo, 't_categories', $id);
       // var_dump(delete($connect, 't_categories', $id, true));
       // exit();
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard_admin.php?success=' . urlencode("categorie $categorieNom supprimé avec succès !"));
        } else {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?success=' . urlencode("Votre categorie $categorieNom a été supprimé avec succès !"));
        }
        exit();
    } else {
        header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=categorie introuvable.');
        exit();
    }
} else {
    header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=ID categorie manquant.');
    exit();
}
?>