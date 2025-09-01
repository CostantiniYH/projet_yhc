<?php
require_once __DIR__ . '/../backend/db_connect.php';
require_once __DIR__ . '/../controllers/session.php';


$id = $_GET['id'];

if ($id) {
    $pdo = connect();
    $image = findBy1($pdo, 't_images', 'id', $id);
    $image = $image[0] ?? null;
    $imageNom = $image['nom'];
    
    if ($image) {
        delete($pdo, 't_images', $id);
       // var_dump(delete($connect, 't_images', $id, true));
       // exit();
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard_admin.php?success=' . urlencode("image $imageNom supprimé avec succès !"));
        } else {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?success=' . urlencode("Votre image $imageNom a été supprimé avec succès !"));
        }
        exit();
    } else {
        header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=image introuvable.');
        exit();
    }
} else {
    header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=ID image manquant.');
    exit();
}
?>