<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Module Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Mon projet site web </h1>
            <nav>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="profil.php">Profil</a>
                    <a href="commentai.php">ton avis ?
                    </a>
                    <a href="logout.php">Déconnexion</a>
                    <a href="livre.php">Commentaire</a>
                <?php else: ?>
                    <a href="connexion.php">Connexion</a>
                    <a href="inscription.php">Créer un compte</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['login']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="admin.php">Admin</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container01">
        <section>
            <h2>Bienvenue sur mon site</h2>
            <p>Vous etre bien dans mon module de connexion simple </p>
        </section>
    </main>

</body>
</html>
