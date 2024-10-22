<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Catégories</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Mes Catégories</h1>
    <?php if (empty($categories)): ?>
        <p>Vous n'avez pas encore de catégories.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($categories as $categorie): ?>
            <li>
                <h2><?php echo htmlspecialchars($categorie['nom']); ?></h2>
                <p><?php echo htmlspecialchars($categorie['description']); ?></p>
                <p>Nombre de notes : <?php echo $categorie['note_count']; ?></p>
                <a href="index.php?action=list_notes&categorie_id=<?php echo $categorie['id']; ?>">Voir les notes</a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <p><a href="index.php?action=create_categorie_form">Créer une nouvelle catégorie</a></p>
    <p><a href="index.php?action=dashboard">Retour au tableau de bord</a></p>
</body>
</html>
