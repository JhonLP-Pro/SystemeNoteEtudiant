<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une catégorie</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Créer une nouvelle catégorie</h1>
    <form action="index.php?action=create_categorie" method="post">
        <label for="nom">Nom de la catégorie :</label>
        <input type="text" id="nom" name="nom" required>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
        <button type="submit">Créer la catégorie</button>
    </form>
    <p><a href="index.php?action=dashboard">Retour au tableau de bord</a></p>
</body>
</html>
