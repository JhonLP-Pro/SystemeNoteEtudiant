<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Connexion</h1>
    <form action="index.php?action=login" method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="index.php?action=register_form">Inscrivez-vous</a></p>
</body>
</html>
