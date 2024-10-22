<?php
class Categorie {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $etudiant_id;
    public $nom;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET etudiant_id=:etudiant_id, nom=:nom, description=:description";
        $stmt = $this->conn->prepare($query);

        $this->etudiant_id = htmlspecialchars(strip_tags($this->etudiant_id));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":etudiant_id", $this->etudiant_id);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":description", $this->description);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCategoriesForEtudiant($etudiant_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE etudiant_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $etudiant_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoriesWithNoteCountForEtudiant($etudiant_id) {
        $query = "SELECT c.*, COUNT(n.id) as note_count 
                  FROM " . $this->table_name . " c
                  LEFT JOIN notes n ON c.id = n.categorie_id
                  WHERE c.etudiant_id = ?
                  GROUP BY c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $etudiant_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
