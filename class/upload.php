<?php
class Upload {
    private $file;
    private $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf');
    private $maxSize = 1024 * 1024 * 5; // 5MB
    private $filePath;
    private $error = [];

    public function __construct($file) {
        $this->file = $file;
    }
    
    public function getError() {
        return $this->error;
    }
    public function setError($error) {
        return array_push($this->error, $error);
    }
    public function getUploadErrorMessage($errorCode) {
        $errorMessages = [
            UPLOAD_ERR_OK => "Aucune erreur.",
            UPLOAD_ERR_INI_SIZE => "Fichier trop volumineux (php.ini).",
            UPLOAD_ERR_FORM_SIZE => "Fichier trop volumineux (formulaire).",
            UPLOAD_ERR_PARTIAL => "Fichier partiellement télécharger.",
            UPLOAD_ERR_NO_FILE => "Aucun fichier téléchargé.",
            UPLOAD_ERR_NO_TMP_DIR => "Dossier temporairement manquant.",
            UPLOAD_ERR_CANT_WRITE => "impossible d'écrire sur le disque.",
            UPLOAD_ERR_EXTENSION => "extension de fichier non autorisé."
        ];
        return $errorMessages[$errorCode] ?? "Erreur inconnue.";
    }
    public function validate() {
        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            return $this->setError("Erreur lors de l'upload : " . $this->getUploadErrorMessage($this->file['error']));
        }
        $extension = strtolower(pathInfo($this->file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            return $this->setError("Extension non autorisée.");
        }
        if ($this->file['size'] > $this->maxSize) {
            return $this->setError("Fichier trop volumineux.");
        }
        return true;
    }
    public function moveTo($destination) {
        $this->filePath = $destination;
        if (!move_uploaded_file($this->file['tmp_name'], $destination)) {
            $this->setError("impossible de déplacer le fichier.");
            return false;
        }
        return true;
    }
    public function getFilePath() {
        return $this->filePath;
    }
}
?>