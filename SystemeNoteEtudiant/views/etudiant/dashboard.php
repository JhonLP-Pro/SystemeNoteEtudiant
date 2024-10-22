<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['etudiant_prenom'] . ' ' . $_SESSION['etudiant_nom']; ?> !</h1>
    <nav>
        <ul>
            <li><a href="index.php?action=create_note">Créer une nouvelle note</a></li>
            <li><a href="index.php?action=list_categories">Voir mes catégories et notes</a></li>
            <li><a href="index.php?action=create_categorie_form">Créer une nouvelle catégorie</a></li>
            <li><a href="index.php?action=logout">Se déconnecter</a></li>
        </ul>
    </nav>
    <section>
        <h2>Vos dernières notes</h2>
        <?php if (empty($latestNotes)): ?>
            <p>Vous n'avez pas encore de notes.</p>
        <?php else: ?>
            <ul>
            <?php foreach ($latestNotes as $note): ?>
                <li>
                    <h3><?php echo htmlspecialchars($note['titre']); ?></h3>
                    <p>Catégorie: <?php echo htmlspecialchars($note['categorie_nom']); ?></p>
                    <p>Créée le: <?php echo htmlspecialchars($note['date_creation']); ?></p>
                    <p><?php echo htmlspecialchars(substr($note['contenu'], 0, 100)) . '...'; ?></p>
                    <a href="index.php?action=view_note&id=<?php echo $note['id']; ?>">Voir plus</a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</body>
</html>
