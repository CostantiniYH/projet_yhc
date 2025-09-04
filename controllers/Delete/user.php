<?php
require_once __DIR__ . '/../../backend/db_connect.php';
require_once __DIR__ . '/../../controllers/session.php';


$id = $_GET['id'];

if ($id) {
    $connect = connect();
    $user = findBy1($connect, 't_users', 'id', $id);
    $user = $user[0] ?? null;
    
    if ($user) {
        delete($connect, 't_users', $id, true);
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard_admin.php?success=Utilisateur supprimé avec succès !');
        } else {
        header('Location: ' . BASE_URL . 'compte/login.php?success=Utilisateur supprimé avec succès !');
        exit();
        }
    } else {
        header('Location: ' . BASE_URL . 'compte/login.php?erreur=Utilisateur introuvable.');
        exit();
    }
} else {
    header('Location: ' . BASE_URL . 'compte/login.php?erreur=ID utilisateur manquant.');
    exit();
}


?> 