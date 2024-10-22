<?php
require_once 'models/Categorie.php';

class CategorieController {
    private $db;
    private $categorie;

    public function __construct($db) {
        $this->db = $db;
        $this->categorie = new Categorie($db);
    }

    public function create($etudiant_id, $nom, $description) {
        $this->categorie->etudiant_id = $etudiant_id;
        $this->categorie->nom = $nom;
        $this->categorie->description = $description;

        if($this->categorie->create()) {
            return "La catégorie a été créée avec succès.";
        } else {
            return "Impossible de créer la catégorie.";
        }
    }

    public function listCategories($etudiant_id) {
        return $this->categorie->getCategoriesForEtudiant($etudiant_id);
    }

    public function listCategoriesWithNoteCount($etudiant_id) {
        return $this->categorie->getCategoriesWithNoteCountForEtudiant($etudiant_id);
    }

    public function getCategoriesForEtudiant($etudiant_id) {
        return $this->categorie->getCategoriesForEtudiant($etudiant_id);
    }
}
