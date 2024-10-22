<?php
require_once 'models/Etudiant.php';

class AuthController {
    private $db;
    private $etudiant;

    public function __construct($db) {
        $this->db = $db;
        $this->etudiant = new Etudiant($db);
    }

    public function register($nom, $prenom, $email, $mot_de_passe) {
        if($this->etudiant->emailExists($email)) {
            return "Cet email est déjà utilisé.";
        }

        $this->etudiant->nom = $nom;
        $this->etudiant->prenom = $prenom;
        $this->etudiant->email = $email;
        $this->etudiant->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        if($this->etudiant->create()) {
            return "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            return "Une erreur est survenue lors de l'inscription.";
        }
    }

    public function login($email, $mot_de_passe) {
        if($this->etudiant->emailExists($email)) {
            $this->etudiant->getEtudiantByEmail($email);
            if(password_verify($mot_de_passe, $this->etudiant->mot_de_passe)) {
                $_SESSION['etudiant_id'] = $this->etudiant->id;
                $_SESSION['etudiant_nom'] = $this->etudiant->nom;
                $_SESSION['etudiant_prenom'] = $this->etudiant->prenom;
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                return "Mot de passe incorrect.";
            }
        } else {
            return "Aucun compte n'est associé à cet email.";
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
