<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des notes</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Liste des notes</h1>
    <?php if (empty($notes)): ?>
        <p>Vous n'avez pas encore de notes dans cette catégorie.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($notes as $note): ?>
            <li>
                <h2><?php echo htmlspecialchars($note['titre']); ?></h2>
                <p>Créée le: <?php echo htmlspecialchars($note['date_creation']); ?></p>
                <p><?php echo htmlspecialchars(substr($note['contenu'], 0, 100)) . '...'; ?></p>
                <a href="index.php?action=view_note&id=<?php echo $note['id']; ?>">Voir plus</a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <p><a href="index.php?action=create_note">Créer une nouvelle note</a></p>
    <p><a href="index.php?action=dashboard">Retour au tableau de bord</a></p>
</body>
</html>
