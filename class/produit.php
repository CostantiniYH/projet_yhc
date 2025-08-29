<?php
class Produit {
    private $nom;
    private $prix;
    private $devise;
    private $quantite;
    private $categorie;
    private $description;
    private $errors = [];

    public function __construct($nom, $prix, $devise, $quantite, $categorie, $description) {
        $this->nom = $nom;
        $this->prix = $prix;
        $this->devise = $devise;
        $this->quantite = $quantite;
        $this->categorie = $categorie;
        $this->description = $description;
    }

    // Méthode de validation
    public function validate() {
        $this->errors = []; // Réinitialiser les erreurs
        if (empty($this->nom)) {
            $this->errors[] = 'Le nom est requis.';
        } elseif (strlen($this->nom) < 3) {
            $this->errors[] = 'Le nom doit contenir au moins 3 caractères.';
            }

        // Validation du prix
        if (!is_numeric($this->prix)) {
            $this->errors[] = "Le prix doit être un nombre.";
        } elseif ($this->prix <= 0) {
            $this->errors[] = "Le prix doit être supérieur à 0.";
        }

        // Validation de la devise
        if (!is_string($this->devise) || empty($this->devise)) {
            $this->errors[] = "La devise doit être une chaîne de caractères non vide.";
        }

        // Validation de la quantité
        if (!is_numeric($this->quantite)) {
            $this->errors[] = "La quantité doit être un nombre.";
        } elseif ($this->quantite <= 0) {
            $this->errors[] = "La quantité doit être supérieure à 0.";
        }

        // Validation de la catégorie
        if (!is_string($this->categorie) || empty($this->categorie)) {
            $this->errors[] = "La catégorie doit être une chaîne de caractères non vide.";
        }

        // Validation de la description
        if (!is_string($this->description)) {
            $this->errors[] = "La description doit être une chaîne de caractères.";
        } elseif (strlen($this->description) < 3 || strlen($this->description) > 200) {
            $this->errors[] = "La description doit contenir entre 3 et 200 caractères.";
        }

        return empty($this->errors);
    }

    // Méthode pour récupérer les erreurs
    public function getErrors() {
        return $this->errors;
    }

    // Getters
    public function getNom() { return $this->nom; }
    public function getPrix() { return $this->prix; }
    public function getDevise() { return $this->devise; }
    public function getQuantite() { return $this->quantite; }
    public function getCategorie() { return $this->categorie; }
    public function getDescription() { return $this->description; }
}
?>
