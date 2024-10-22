<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la note</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Modifier la note</h1>
    <form action="index.php?action=edit_note&id=<?php echo $note['id']; ?>" method="post">
        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie_id" required>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?php echo $categorie['id']; ?>" <?php echo ($categorie['id'] == $note['categorie_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categorie['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($note['titre']); ?>" required>
        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($note['contenu']); ?></textarea>
        <button type="submit">Mettre à jour la note</button>
    </form>
    <p><a href="index.php?action=view_note&id=<?php echo $note['id']; ?>">Annuler</a></p>
</body>
</html>
