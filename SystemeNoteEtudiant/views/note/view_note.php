<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la note</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($note['titre']); ?></h1>
    <p>Catégorie: <?php echo htmlspecialchars($note['categorie_nom']); ?></p>
    <p>Créée le: <?php echo htmlspecialchars($note['date_creation']); ?></p>
    <p>Dernière modification: <?php echo htmlspecialchars($note['date_modification']); ?></p>
    <div class="note-content">
        <?php echo nl2br(htmlspecialchars($note['contenu'])); ?>
    </div>
    <div class="actions">
        <a href="index.php?action=edit_note&id=<?php echo $note['id']; ?>" class="btn">Modifier</a>
        <a href="index.php?action=delete_note&id=<?php echo $note['id']; ?>" class="btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');">Supprimer</a>
    </div>
    <p><a href="index.php?action=dashboard">Retour au tableau de bord</a></p>
</body>
</html>
