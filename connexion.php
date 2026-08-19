<?php

header('Content-Type: text/html; charset=UTF-8');
require_once 'config.php';

// Si déjà connecté, rediriger vers l'accueil
if (connecte()) {
    rediriger('index.php');
}

// Variable pour stocker les messages d'erreur
$erreur = '';
$email_saisi = '';

// Traiter le formulaire de connexion (quand l'utilisateur appuie sur "Se connecter")
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'email et le mot de passe du formulaire
    $email = lire_post('email');
    $mdp = lire_post('password');
    $email_saisi = $email; // On le garde pour pré-remplir le formulaire

    // Vérifier que les deux champs ne sont pas vides
    if (empty($email) || empty($mdp)) {
        $erreur = 'Veuillez entrer votre email et mot de passe.';
    } else {
        // Chercher l'utilisateur dans la base avec son email
        $req = $mysqli->prepare("
            SELECT id, nom, email, password, role, poste, statut
            FROM users
            WHERE email = ?
        ");
        $req->bind_param("s", $email);
        $req->execute();
        $resultat = $req->get_result();
        $utilisateur = $resultat->fetch_assoc();
        $req->close();

        // Vérifier que l'utilisateur existe ET que le mot de passe est correct
        if ($utilisateur && password_verify($mdp, $utilisateur['password'])) {
            // Vérifier le statut du compte
            if ($utilisateur['statut'] === 'refuse') {
                $erreur = 'Votre compte a été désactivé. Contactez l\'administrateur.';
            } else if ($utilisateur['statut'] === 'invitation_pending') {
                // L'utilisateur doit accepter son invitation
                $_SESSION['user_id'] = $utilisateur['id'];
                $_SESSION['nom'] = $utilisateur['nom'];
                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['role'] = $utilisateur['role'];
                $_SESSION['poste'] = $utilisateur['poste'];
                $_SESSION['statut'] = 'invitation_pending';

                rediriger('accepter_invitation.php');
            } else {
                //  créer la session
                $_SESSION['user_id'] = $utilisateur['id'];
                $_SESSION['nom'] = $utilisateur['nom'];
                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['role'] = $utilisateur['role'];
                $_SESSION['poste'] = $utilisateur['poste'];
                $_SESSION['statut'] = $utilisateur['statut'];

                // Rediriger vers le bon dashboard selon le rôle
                rediriger('index.php');
            }
        } else {
            // Identifiants incorrects
            $erreur = 'Email ou mot de passe incorrect.';
        }
    }
}

// Message d'erreur depuis l'URL (ex: ?erreur=compte_refuse)
if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] === 'compte_refuse') {
        $erreur = 'Votre compte a été désactivé.';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SOMAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    

    
</head>
<body>

<div class="login-card">
    <!-- Logo / Titre -->
    <h1>📦 SOMAF</h1>
    <p>Gestion du Parc Matériel</p>

    <!-- Message d'erreur -->
    <?php if (!empty($erreur)): ?>
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo echapper($erreur); ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form method="POST" action="connexion.php">
        <div class="form-group">
            <label for="email">
                <i class="fas fa-envelope"></i>
                Email
            </label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="votre.email@gmail.com"
                value="<?php echo echapper($email_saisi); ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">
                <i class="fas fa-lock"></i>
                Mot de passe
            </label>
            <input
                type="password"
                id="password"
                name="password"
                
                required
            >
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt"></i>
            Se connecter
        </button>
    </form>

    <!-- Identifiants de démonstration -->
    <div class="demo-credentials">
        <strong>🔐 Identifiants de démonstration :</strong>
        <div>
            <strong>Admin:</strong><br>
            Email: <code>admin@somaf.com</code><br>
            Mot de passe: <code>password</code>
        </div>
        <div>
            <strong>Employé:</strong><br>
            Email: <code>pierre@somaf.com</code><br>
            Mot de passe: <code>password</code>
        </div>
        <div>
            <strong>Mécanicien:</strong><br>
            Email: <code>marc@somaf.com</code><br>
            Mot de passe: <code>password</code>
        </div>
    </div>
</div>

</body>
</html>

