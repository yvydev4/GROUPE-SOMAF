<?php
/**
 * ACCEPTER_INVITATION.PHP - PAGE D'ACCEPTATION DE L'INVITATION
 * 
 * Quand l'admin crée un nouveau compte, l'utilisateur doit d'abord
 * accepter l'invitation et définir son mot de passe avant d'accéder
 * à l'application.
 */

require_once 'config.php';

// Si pas connecté, rediriger vers connexion
if (!connecte()) {
    rediriger('connexion.php');
}

// Vérifier que le statut est bien "invitation_pending"
if ($_SESSION['statut'] !== 'invitation_pending') {
    rediriger('index.php');
}

$message_succes = '';
$erreur = '';

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mdp = lire_post('password');
    $mdp_confirm = lire_post('password_confirm');
    
    // Validation
    if (empty($mdp) || empty($mdp_confirm)) {
        $erreur = 'Veuillez remplir tous les champs.';
    } elseif (strlen($mdp) < 8) {
        $erreur = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($mdp !== $mdp_confirm) {
        $erreur = 'Les deux mots de passe ne correspondent pas.';
    } else {
        // Hasher le mot de passe
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        
        // Mettre à jour le compte
        $update = $mysqli->prepare("
            UPDATE users 
            SET password = ?, statut = 'actif', invitation_token = NULL, token_expiration = NULL 
            WHERE id = ?
        ");
        $update->bind_param("si", $mdp_hash, $_SESSION['user_id']);
        
        if ($update->execute()) {
            $update->close();
            
            // Mettre à jour la session
            $_SESSION['statut'] = 'actif';
            
            // Créer une notification de bienvenue
            $notif = $mysqli->prepare("
                INSERT INTO notifications (user_id, type, titre, message) 
                VALUES (?, 'bienvenue', 'Bienvenue!', 'Votre compte a été activé. Bienvenue dans SOMAF!')
            ");
            $notif->bind_param("i", $_SESSION['user_id']);
            $notif->execute();
            $notif->close();
            
            // Rediriger vers le dashboard
            rediriger('index.php');
        } else {
            $erreur = 'Erreur lors de la mise à jour du compte.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepter l'invitation - SOMAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    
    
</head>
<body>

<div class="invitation-card">
    <h1><i class="fas fa-envelope-open-text"></i> Accepter l'invitation</h1>
    
    <p>
        Bienvenue dans <strong>SOMAF</strong> !<br>
        Votre administrateur vous a créé un compte. Veuillez définir votre mot de passe pour activer votre compte et accéder à l'application.
    </p>
    
    <!-- Infos utilisateur -->
    <div class="user-info">
        <strong>Compte créé pour :</strong><br>
        <?php echo echapper($_SESSION['nom']); ?><br>
        <small><?php echo echapper($_SESSION['email']); ?></small>
    </div>
    
    <!-- Message de succès -->
    <?php if (!empty($message_succes)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo echapper($message_succes); ?>
        </div>
    <?php endif; ?>
    
    <!-- Message d'erreur -->
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo echapper($erreur); ?>
        </div>
    <?php endif; ?>
    
    <!-- Formulaire -->
    <form method="POST">
        <div class="form-group">
            <label for="password">
                <i class="fas fa-lock"></i>
                Nouveau mot de passe
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Minimum 8 caractères"
                required
            >
            <small>
                Le mot de passe doit contenir au moins 8 caractères.
            </small>
        </div>
        
        <div class="form-group">
            <label for="password_confirm">
                <i class="fas fa-lock"></i>
                Confirmer le mot de passe
            </label>
            <input 
                type="password" 
                id="password_confirm" 
                name="password_confirm" 
                placeholder="Répétez le mot de passe"
                required
            >
        </div>
        
        <button type="submit" class="btn-submit">
            <i class="fas fa-check"></i>
            Activer mon compte
        </button>
    </form>
</div>

</body>
</html>

