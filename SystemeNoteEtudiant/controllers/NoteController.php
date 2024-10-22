<?php
require_once 'models/Note.php';

class NoteController {
    private $db;
    private $note;

    public function __construct($db) {
        $this->db = $db;
        $this->note = new Note($db);
    }

    public function create($etudiant_id, $categorie_id, $titre, $contenu) {
        $this->note->etudiant_id = $etudiant_id;
        $this->note->categorie_id = $categorie_id;
        $this->note->titre = $titre;
        $this->note->contenu = $contenu;

        if($this->note->create()) {
            return "La note a été créée avec succès.";
        } else {
            return "Impossible de créer la note.";
        }
    }

    public function read($id) {
        $this->note->read($id);
        return $this->note;
    }

    public function update($id, $etudiant_id, $categorie_id, $titre, $contenu) {
        $note = $this->note->getNote($id);
        if ($note && $note['etudiant_id'] == $etudiant_id) {
            $this->note->id = $id;
            $this->note->categorie_id = $categorie_id;
            $this->note->titre = $titre;
            $this->note->contenu = $contenu;

            if($this->note->update()) {
                return "La note a été mise à jour avec succès.";
            } else {
                return "Impossible de mettre à jour la note.";
            }
        }
        return "Note non trouvée ou vous n'avez pas les droits pour la modifier.";
    }

    public function delete($id, $etudiant_id) {
        $note = $this->note->getNote($id);
        if ($note && $note['etudiant_id'] == $etudiant_id) {
            if($this->note->delete($id)) {
                return "La note a été supprimée avec succès.";
            } else {
                return "Impossible de supprimer la note.";
            }
        }
        return "Note non trouvée ou vous n'avez pas les droits pour la supprimer.";
    }

    public function listNotes($etudiant_id, $categorie_id = null) {
        return $this->note->getNotesForEtudiant($etudiant_id, $categorie_id);
    }

    public function getLatestNotes($etudiant_id, $limit = 5) {
        return $this->note->getLatestNotesForEtudiant($etudiant_id, $limit);
    }

    public function viewNote($id, $etudiant_id) {
        $note = $this->note->getNote($id);
        if ($note && $note['etudiant_id'] == $etudiant_id) {
            return $note;
        }
        return null;
    }
}
