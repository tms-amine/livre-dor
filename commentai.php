<?php
include 'config.php';
if(!isset($_SESSION['id'])){ header('Location: connexion.php'); exit(); }

$error = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $comment = trim($_POST['commentaire'] ?? '');
  if($comment === ''){
    $error = "Le commentaire est vide.";
  } else {
    $stmt = $bdd->prepare("INSERT INTO commentaires (message, id_utilisateur, date) VALUES (?, ?, NOW())");
    $stmt->execute([$comment, $_SESSION['id']]);
    header('Location: livre.php');
    exit();
  }
}
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un commentaire</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <div class="container">
    <h1>Ajouter un commentaire</h1>
    <nav> 
      <a href="index.php">Accueil</a>
      <a href="logout.php">Déconnexion</a>
    </nav>
  </div>
</header>

<main class="container">
  <div class="form-container">
    <h2>Votre avis</h2>
    <?php if($error): ?><div class="error-message"><?= h($error) ?></div><?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="commentaire">Commentaire</label>
        <textarea id="commentaire" name="commentaire" rows="5" required></textarea>
      </div>
      <button class="btn" type="submit">Publier</button>
    </form>
  </div>
</main>
</body>
</html>
