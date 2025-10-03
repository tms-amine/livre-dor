<?php
include 'config.php';
// on suppose $bdd = new PDO(...), session_start() dans config.php

$comments = $bdd->query("
  SELECT c.message, c.date, u.login
  FROM commentaires c
  JOIN utilisateurs u ON u.id = c.id_utilisateur
  ORDER BY c.date DESC
")->fetchAll(PDO::FETCH_ASSOC);

function h($s){ return htmlspecialchars($s ?? ''); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livre d’or</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <div class="container">
    <h1>Livre d’or</h1>
    <nav>
      <a href="index.php">Accueil</a>
      <?php if(isset($_SESSION['login'])): ?>
        <a href="profil.php">Profil</a>
        <a href="logout.php">Déconnexion</a>
      <?php else: ?>
        <a href="connexion.php">Connexion</a>
        <a href="inscription.php">Créer un compte</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="container">
  <div class="card headered">
    <div class="card__header">
      <div class="card__title">Tous les avis</div>
      <?php if(isset($_SESSION['login'])): ?>
        <a class="btn btn--ghost" href="commentai.php">Écrire un avis</a>
      <?php endif; ?>
    </div>

    <?php if(empty($comments)): ?>
      <p class="text-muted">Aucun commentaire pour l’instant.</p>
    <?php else: ?>
      <div class="stack">
        <?php foreach($comments as $c): ?>
          <article class="card">
            <small class="text-muted">
              Posté le <?= date('d/m/Y à H:i', strtotime($c['date'])) ?>
              par <strong><?= h($c['login']) ?></strong>
            </small>
            <p><?= nl2br(h($c['message'])) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
