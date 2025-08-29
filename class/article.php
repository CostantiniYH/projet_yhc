<?php
class Article {
    private $title;
    private $content;
    private $author;
    private $picture;

    public function __construct($title, $content, $author, $picture) {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setAuthor($author);
        $this->setPicture($picture);
    }

    public function getTitle() {
        return $this->title;
    }
    public function getContent() {
        return $this->content;
    }
    public function getAuthor() {
        return $this->author;
    }
    public function getPicture() {
        return $this->picture;
    }


//fonction pour modifier les valeurs
    public function setTitle($title) {
        if (is_string($title)) {
            $this->title = $title;
        }
    }
    public function setContent($content) {
        if (!is_string($content)) {
            throw new Exception("Le contenu doit être une chaîne de caractères");
        }
        $this->content = $content;
    }
    public function setAuthor($author) {
        if (!is_string($author)) {
            throw new Exception("L'auteur doit être une chaîne de caractères");
        }
        $this->author = $author;
    }
    public function setPicture($picture) {
        $errorMessages = [
            UPLOAD_ERR_OK => "Aucune erreur.",
            UPLOAD_ERR_INI_SIZE => "Fichier trop volumineux (php.ini).",
            UPLOAD_ERR_FORM_SIZE => "Fichier trop volumineux (formulaire).",
            UPLOAD_ERR_PARTIAL => "Fichier partiellement téléchargé.",
            UPLOAD_ERR_NO_FILE => "Aucun fichier téléchargé.",
            UPLOAD_ERR_NO_TMP_DIR => "Dossier temporaire manquant.",
            UPLOAD_ERR_CANT_WRITE => "Impossible d’écrire sur le disque.",
            UPLOAD_ERR_EXTENSION => "Extension de fichier non autorisée."
        ];
    
        if (!isset($picture) || !isset($picture['error'])) {
            throw new Exception("Aucune image reçue.");
        }
    
        $errorCode = $picture['error'];
        if ($errorCode !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur : " . ($errorMessages[$errorCode] ?? "Erreur inconnue."));
        }
    
        // Vérification de l'extension
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($picture['name']);
        $extension = strtolower($fileInfo['extension'] ?? '');
    
        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception("Format non autorisé. Extensions acceptées : " . implode(", ", $allowedExtensions));
        }
    
        if (!file_exists($picture['tmp_name'])) {
            throw new Exception("Le fichier temporaire est introuvable.");
        }

        // Vérification du type MIME
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileMimeType = mime_content_type($picture['tmp_name']);
    
        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            throw new Exception("Type de fichier non valide.");
        }
    
        // Vérification de la taille (5 Mo max)
        $maxSize = 5 * 1024 * 1024; // 5 Mo
        if ($picture['size'] > $maxSize) {
            throw new Exception("Le fichier est trop volumineux (max 5 Mo).");
        }
    
        // Définition du dossier de destination
        $uploadDir = __DIR__ . "/uploads/"; // Assure-toi que ce dossier existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
    
        // Sécurisation du nom du fichier
        $newFileName = uniqid() . "." . $extension;
        $destination = $uploadDir . $newFileName;
    
        // Déplacement du fichier depuis le dossier temporaire
        if (!move_uploaded_file($picture['tmp_name'], $destination)) {
            throw new Exception("Échec de l'enregistrement de l'image.");
        }
    
        // Stocker le chemin de l'image dans l'objet
        $this->picture = $destination;
    
        return $destination; // Retourne le chemin du fichier sauvegardé
    }
    

}