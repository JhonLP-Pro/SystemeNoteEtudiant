-- Création de la base de données
CREATE DATABASE IF NOT EXISTS systeme_notes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utilisation de la base de données
USE systeme_notes;

-- Création de la table des étudiants
CREATE TABLE IF NOT EXISTS etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Création de la table des catégories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
) ENGINE=InnoDB;

-- Création de la table des notes
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    categorie_id INT,
    titre VARCHAR(100) NOT NULL,
    contenu TEXT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Insertion de quelques données de test pour les étudiants avec des mots de passe hachés (code: password)
INSERT INTO etudiants (nom, prenom, email, mot_de_passe) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Martin', 'Marie', 'marie.martin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Dubois', 'Pierre', 'pierre.dubois@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insertion de quelques catégories de test
INSERT INTO categories (nom, description) VALUES
('Mathématiques', 'Notes liées aux cours de mathématiques'),
('Physique', 'Notes liées aux cours de physique'),
('Langues', 'Notes liées aux cours de langues'),
('Général', 'Notes générales et divers');

-- Insertion de quelques notes de test
INSERT INTO notes (etudiant_id, categorie_id, titre, contenu) VALUES
(1, 1, 'Cours de mathématiques', 'Révision des équations du second degré'),
(1, 2, 'Projet de physique', 'Idées pour l''expérience sur la gravité'),
(2, 3, 'Vocabulaire d''anglais', 'Liste des mots à apprendre pour le prochain test'),
(3, 4, 'Plan du rapport de stage', 'Introduction, développement, conclusion');

-- Modification de la table des catégories
ALTER TABLE categories ADD COLUMN etudiant_id INT;
ALTER TABLE categories ADD FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE;

-- Mise à jour des catégories existantes (attribuons-les à l'étudiant 1 pour cet exemple)
UPDATE categories SET etudiant_id = 1;
