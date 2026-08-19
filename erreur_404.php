<?php
/**
 * ERREUR_404.PHP - PAGE D'ERREUR
 * 
 * Affichée quand une page n'existe pas.
 */

require_once 'config.php';

// Récupérer le chemin demandé
$chemin_demande = $_SERVER['REQUEST_URI'] ?? 'inconnu';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - SOMAF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    
</head>
<body>

<div class="error-container">
    <i class="fas fa-exclamation-triangle error-icon"></i>
    
    <div class="error-code">404</div>
    
    <h1 class="error-title">Page non trouvée</h1>
    
    <p class="error-message">
        Désolé, la page que vous recherchez n'existe pas ou a été déplacée.<br>
        <small>Chemin: <?php echo echapper($chemin_demande); ?></small>
    </p>
    
    <div>
        <i class="fas fa-search"></i>
    </div>
    
    <a href="index.php" class="btn-primary">
        <i class="fas fa-home"></i> Retour à l'accueil
    </a>
</div>

</body>
</html>
