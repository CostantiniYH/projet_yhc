<?php 

class User {
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $telephone;
    private $societe;
    private $error = [];

    public function __construct($nom, $prenom, $email, $password, $telephone, $societe) {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setTelephone($telephone);
        $this->setSociete($societe);
    }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getSociete() { return $this->societe; }
    public function getTelephone() { return $this->telephone; }
    public function getError() { return $this->error; }

    public function setError($error) {
        return array_push($this->error, $error);
    }    
    public function setNom($nom) {
        if (empty($nom)) {
            return $this->setError("Le nom est vide");
        } elseif (strlen($nom) < 3) {
            return $this->setError("Le nom doit contenir au moins 3 caractères");
        }
        $this->nom = $nom;
        return $this->nom;        
    }
    public function setPrenom($prenom) {
        if (empty($prenom)) {
           return $this->setError("Le prénom est vide");
        } elseif (strlen($prenom) < 3) {
               return $this->setError("Le prénom doit contenir au moins 3 caractères");
        }
        $this->prenom = $prenom;
        return $this->prenom; 
    }
    public function setEmail($email) {
        $emailSql = $this->verifyEmail($email);
        $verif = $this->validateEmail($email);

        if ($emailSql == true) {
            return $this->setError("L'email existe déjà !");
        }
        
        if ($verif == false ) {
            return $this->setError("L'email est invalide !");
        }

        $this->email = $email;
        return $this->email;
    }
    public static function verifyEmail($email) {
        $pdo = connect();
        $value = findBy2 ($pdo, '*', 't_users',  'email', $email);

        if (is_array($value) && count($value) >= 1) {
            return true;
            } else {
                return false;
            }
    }
    private function validateEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
        return false;
        }
    }

    public function setPassword($password) {
        if (strlen($password) < 8) {
            return $this->setError("Le mot de passe doit contenir au moins 8 caractères");
        }
        
        $password = $this->hashPassword($password);
        $this->password = $password;
        return $this->password;
    }
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    public static function verifyPassword($password, $hash) {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    public function setTelephone($telephone) {
        if (strlen($telephone) < 10) {
            return $this->setError("Le numéro de téléphone doit contenir au moins 10 chiffres !");
        }
        $this->telephone = $telephone;
        return $this->telephone;
    }
    public function setSociete($societe) {
        if (strlen($societe) < 2) {
            return $this->setError("La société doit contenir au moins 2 caractères !");
        }
        $this->societe = $societe;
        return $this->societe;
    }
}