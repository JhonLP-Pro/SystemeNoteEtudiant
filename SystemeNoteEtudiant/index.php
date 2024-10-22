<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/NoteController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CategorieController.php';

$database = new Database();
$db = $database->getConnection();

$note_controller = new NoteController($db);
$auth_controller = new AuthController($db);
$categorie_controller = new CategorieController($db);

$action = isset($_GET['action']) ? $_GET['action'] : '';

function isLoggedIn() {
    return isset($_SESSION['etudiant_id']);
}

switch($action) {
    case 'register_form':
        include 'views/etudiant/register.php';
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $auth_controller->register($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mot_de_passe']);
            echo $message;
        }
        break;
    case 'login_form':
        include 'views/etudiant/login.php';
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth_controller->login($_POST['email'], $_POST['mot_de_passe']);
        }
        break;
    case 'logout':
        $auth_controller->logout();
        break;
    case 'dashboard':
        if (isLoggedIn()) {
            $latestNotes = $note_controller->getLatestNotes($_SESSION['etudiant_id']);
            include 'views/etudiant/dashboard.php';
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'create_note':
        if (isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $etudiant_id = $_SESSION['etudiant_id'];
                $categorie_id = $_POST['categorie_id'];
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $message = $note_controller->create($etudiant_id, $categorie_id, $titre, $contenu);
                echo $message;
                header("Location: index.php?action=dashboard&message=" . urlencode($message));
                exit();
            } else {
                $categories = $categorie_controller->getCategoriesForEtudiant($_SESSION['etudiant_id']);
                include 'views/note/create_note.php';
            }
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'list_categories':
        if (isLoggedIn()) {
            $categories = $categorie_controller->listCategoriesWithNoteCount($_SESSION['etudiant_id']);
            include 'views/categorie/list_categories.php';
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'list_notes':
        if (isLoggedIn()) {
            $categorie_id = isset($_GET['categorie_id']) ? $_GET['categorie_id'] : null;
            $notes = $note_controller->listNotes($_SESSION['etudiant_id'], $categorie_id);
            include 'views/note/list_notes.php';
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'create_categorie_form':
        if (isLoggedIn()) {
            include 'views/categorie/create_categorie.php';
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'create_categorie':
        if (isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $etudiant_id = $_SESSION['etudiant_id'];
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $message = $categorie_controller->create($etudiant_id, $nom, $description);
                echo $message;
                header("Location: index.php?action=dashboard&message=" . urlencode($message));
                exit();
            }
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'view_note':
        if (isLoggedIn()) {
            $note_id = isset($_GET['id']) ? $_GET['id'] : null;
            if ($note_id) {
                $note = $note_controller->viewNote($note_id, $_SESSION['etudiant_id']);
                if ($note) {
                    include 'views/note/view_note.php';
                } else {
                    echo "Note non trouvée ou vous n'avez pas les droits pour y accéder.";
                }
            } else {
                echo "ID de note non spécifié.";
            }
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'edit_note':
        if (isLoggedIn()) {
            $note_id = isset($_GET['id']) ? $_GET['id'] : null;
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categorie_id = $_POST['categorie_id'];
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $message = $note_controller->update($note_id, $_SESSION['etudiant_id'], $categorie_id, $titre, $contenu);
                header("Location: index.php?action=view_note&id=$note_id&message=" . urlencode($message));
                exit();
            } else {
                $note = $note_controller->viewNote($note_id, $_SESSION['etudiant_id']);
                $categories = $categorie_controller->getCategoriesForEtudiant($_SESSION['etudiant_id']);
                if ($note) {
                    include 'views/note/edit_note.php';
                } else {
                    echo "Note non trouvée ou vous n'avez pas les droits pour y accéder.";
                }
            }
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    case 'delete_note':
        if (isLoggedIn()) {
            $note_id = isset($_GET['id']) ? $_GET['id'] : null;
            $message = $note_controller->delete($note_id, $_SESSION['etudiant_id']);
            header("Location: index.php?action=dashboard&message=" . urlencode($message));
            exit();
        } else {
            header("Location: index.php?action=login_form");
        }
        break;
    default:
        if (isLoggedIn()) {
            header("Location: index.php?action=dashboard");
        } else {
            include 'views/etudiant/home.php';
        }
}
