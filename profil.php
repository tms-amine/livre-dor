<?php 
include 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit();
}

$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($password)) {
        if ($password == $confirm_password) {
            
            $stmt = $bdd->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ?, password = ? WHERE id = ?");
            $stmt->execute([$login, $prenom, $nom, $password, $_SESSION['id']]);
        } else {
            $error = "Les mots de passe ne correspondent pas";
        }
    } else {
        $stmt = $bdd->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ? WHERE id = ?");
        $stmt->execute([$login, $prenom, $nom, $_SESSION['id']]);
    }
    
    if (!isset($error)) {
        $_SESSION['login'] = $login;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['nom'] = $nom;
        header("Location: profil.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Profil de <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></h1>
            <nav>
                <a href="index.php">Accueil</a>
                <a href="logout.php">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="form-container">
            <h2>Modifier le profil</h2>
            
            <?php if(isset($error)): ?>
                <p style="color:red"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php echo $user['role'] ?>
            <form method="POST">
                <div class="form-group">
                    <label for="login">Nom d'utilisateur:</label>
                    <input type="text" id="login" name="login" value="<?php echo $user['login']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo $user['prenom']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" value="<?php echo $user['nom']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Nouveau mot de passe:</label>
                    <input type="password" id="password" name="password">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe:</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
                
                <button type="submit" class="btn">Mettre à jour</button>
            </form>
        </div>
    </main>
</body>
</html>
