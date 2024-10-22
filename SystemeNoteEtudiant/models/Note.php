<?php
class Note {
    private $conn;
    private $table_name = "notes";

    public $id;
    public $etudiant_id;
    public $categorie_id;
    public $titre;
    public $contenu;
    public $date_creation;
    public $date_modification;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET etudiant_id=:etudiant_id, categorie_id=:categorie_id, titre=:titre, contenu=:contenu";
        $stmt = $this->conn->prepare($query);

        $this->etudiant_id = htmlspecialchars(strip_tags($this->etudiant_id));
        $this->categorie_id = htmlspecialchars(strip_tags($this->categorie_id));
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->contenu = htmlspecialchars(strip_tags($this->contenu));

        $stmt->bindParam(":etudiant_id", $this->etudiant_id);
        $stmt->bindParam(":categorie_id", $this->categorie_id);
        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":contenu", $this->contenu);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->etudiant_id = $row['etudiant_id'];
        $this->categorie_id = $row['categorie_id'];
        $this->titre = $row['titre'];
        $this->contenu = $row['contenu'];
        $this->date_creation = $row['date_creation'];
        $this->date_modification = $row['date_modification'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET categorie_id=:categorie_id, titre=:titre, contenu=:contenu WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->categorie_id = htmlspecialchars(strip_tags($this->categorie_id));
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->contenu = htmlspecialchars(strip_tags($this->contenu));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":categorie_id", $this->categorie_id);
        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":contenu", $this->contenu);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getNotesForEtudiant($etudiant_id, $categorie_id = null) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE etudiant_id = ?";
        $params = [$etudiant_id];
        
        if ($categorie_id !== null) {
            $query .= " AND categorie_id = ?";
            $params[] = $categorie_id;
        }
        
        $query .= " ORDER BY date_creation DESC";
        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLatestNotesForEtudiant($etudiant_id, $limit = 5) {
        $query = "SELECT n.*, c.nom as categorie_nom FROM " . $this->table_name . " n 
                  LEFT JOIN categories c ON n.categorie_id = c.id
                  WHERE n.etudiant_id = ? 
                  ORDER BY n.date_creation DESC 
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $etudiant_id);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNote($id) {
        $query = "SELECT n.*, c.nom as categorie_nom FROM " . $this->table_name . " n 
                  LEFT JOIN categories c ON n.categorie_id = c.id
                  WHERE n.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
