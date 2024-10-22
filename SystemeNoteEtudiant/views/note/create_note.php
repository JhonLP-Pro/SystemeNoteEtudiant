<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une note</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Créer une nouvelle note</h1>
    <form action="index.php?action=create_note" method="post">
        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie_id" required>
            <option value="">Choisir une catégorie</option>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?php echo $categorie['id']; ?>"><?php echo htmlspecialchars($categorie['nom']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required>
        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required></textarea>
        <button type="submit">Créer la note</button>
    </form>
    <p><a href="index.php?action=dashboard">Retour au tableau de bord</a></p>
</body>
</html>
