<?php
/**
 * NOTIFICATIONS.PHP - AFFICHAGE DES NOTIFICATIONS
 * 
 * Affiche toutes les notifications de l'utilisateur connecté
 * avec possibilité de les marquer comme lues et de les supprimer.
 */

require_once 'config.php';
exiger_connexion();

$page_active = 'notifications';
$page_title = 'Notifications';

$user_id = $_SESSION['user_id'];
$action = lire_post('action') ?: '';
$erreur = '';
$succes = '';

// === MARQUER COMME LU ===
if ($action === 'mark_read') {
    $notification_id = lire_post('notification_id');
    $update = $mysqli->prepare("UPDATE notifications SET lu = TRUE WHERE id = ? AND user_id = ?");
    $update->bind_param("ii", $notification_id, $user_id);
    $update->execute();
    $update->close();
}

// === SUPPRIMER ===
if ($action === 'delete') {
    $notification_id = lire_post('notification_id');
    $delete = $mysqli->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ?");
    $delete->bind_param("ii", $notification_id, $user_id);
    $delete->execute();
    $delete->close();
}

// === MARQUER TOUT COMME LU ===
if ($action === 'mark_all_read') {
    $update = $mysqli->prepare("UPDATE notifications SET lu = TRUE WHERE user_id = ? AND lu = FALSE");
    $update->bind_param("i", $user_id);
    $update->execute();
    $update->close();
    $succes = 'Toutes les notifications sont marquées comme lues.';
}

// Récupérer les notifications
$notifications = $mysqli->query("
    SELECT id, type, titre, message, lu, created_at
    FROM notifications
    WHERE user_id = $user_id
    ORDER BY created_at DESC
    LIMIT 50
");

// Compteurs
$non_lues = $mysqli->query("SELECT COUNT(*) as count FROM notifications WHERE user_id = $user_id AND lu = FALSE");
$non_lues_count = $non_lues->fetch_assoc()['count'];

?>
<?php include 'templates/header.php'; ?>

<!-- Titre et actions -->
<div>
    <div>
        <h1>Notifications</h1>
        <p>
            <?php echo $non_lues_count; ?> notification<?php echo $non_lues_count > 1 ? 's' : ''; ?> non lue<?php echo $non_lues_count > 1 ? 's' : ''; ?>
        </p>
    </div>
    <?php if ($non_lues_count > 0): ?>
        <form method="POST">
            <input type="hidden" name="action" value="mark_all_read">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-check-double"></i> Tout marquer comme lu
            </button>
        </form>
    <?php endif; ?>
</div>

<!-- Message de succès -->
<?php if (!empty($succes)): ?>
    <div>
        <i class="fas fa-check-circle"></i> <?php echo echapper($succes); ?>
    </div>
<?php endif; ?>

<!-- Liste des notifications -->
<?php if ($notifications->num_rows > 0): ?>
    <div>
        <?php while ($notif = $notifications->fetch_assoc()): ?>
            <div class="card">
                
                <div>
                    <div>
                        <div>
                            <h3>
                                <?php 
                                $icons = [
                                    'demande_emprunt' => 'ð???',
                                    'emprunt_valide' => '→',
                                    'emprunt_refuse' => '→?',
                                    'retour_demande' => 'ð??¦',
                                    'bienvenue' => 'ð???',
                                    'alert' => '→? ï¸',
                                ];
                                $icon = $icons[$notif['type']] ?? 'ð???';
                                echo $icon . ' ';
                                echo echapper($notif['titre']);
                                ?>
                            </h3>
                            <?php if (!$notif['lu']): ?>
                                <span></span>
                            <?php endif; ?>
                        </div>
                        
                        <p>
                            <?php echo echapper($notif['message']); ?>
                        </p>
                        
                        <p>
                            <?php echo date('d/m/Y H:i', strtotime($notif['created_at'])); ?>
                        </p>
                    </div>
                    
                    <!-- Actions -->
                    <div>
                        <?php if (!$notif['lu']): ?>
                            <form method="POST">
                                <input type="hidden" name="action" value="mark_read">
                                <input type="hidden" name="notification_id" value="<?php echo $notif['id']; ?>">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="notification_id" value="<?php echo $notif['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer cette notification?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="card">
        <i class="fas fa-bell"></i>
        <h2>Aucune notification</h2>
        <p>
            Vous n'avez aucune notification pour le moment.
        </p>
    </div>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>

