<?php
/**
 * SETUP.PHP - Script d'installation et correction
 * 
 * Exécutez ce fichier UNE SEULE FOIS pour:
 * 1. Vérifier la configuration
 * 2. Créer les mots de passe des utilisateurs test
 * 3. Vérifier la connectivité base de données
 */

// Configuration
require_once __DIR__ . '/config.php';

echo "═══════════════════════════════════════════════════════\n";
echo "SOMAF - Script d'Installation & Vérification\n";
echo "═══════════════════════════════════════════════════════\n\n";

// 1. Vérifier connexion base de données
echo "1️⃣  Vérification connexion base de données...\n";
$result = $mysqli->query("SELECT DATABASE() AS db");
if ($result) {
    $row = $result->fetch_assoc();
    echo "   ✅ Connecté à: " . $row['db'] . "\n\n";
} else {
    echo "   ❌ Erreur de connexion: " . $mysqli->error . "\n\n";
    exit(1);
}

// 2. Vérifier tables
echo "2️⃣  Vérification des tables...\n";
$tables = ['users', 'equipment', 'loans', 'notifications', 'postes'];
foreach ($tables as $table) {
    $result = $mysqli->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "   ✅ Table '$table' trouvée\n";
    } else {
        echo "   ❌ Table '$table' MANQUANTE\n";
    }
}
echo "\n";

// 3. Vérifier utilisateurs et créer mots de passe
echo "3️⃣  Mise à jour des utilisateurs de test...\n";

$users = [
    ['email' => 'admin@somaf.com', 'password' => 'password', 'role' => 'admin'],
    ['email' => 'pierre@somaf.com', 'password' => 'password', 'role' => 'employe'],
    ['email' => 'jean@somaf.com', 'password' => 'password', 'role' => 'employe'],
    ['email' => 'marc@somaf.com', 'password' => 'password', 'role' => 'mecanicien'],
    ['email' => 'charge_materiel@somaf.com', 'password' => 'password', 'role' => 'charge_materiel'],
];

foreach ($users as $user) {
    $email = $user['email'];
    $password_hash = password_hash($user['password'], PASSWORD_DEFAULT);
    $role = $user['role'];
    
    // Mettre à jour ou créer utilisateur
    $sql = "INSERT INTO users (nom, email, password, role, statut) 
            VALUES (?, ?, ?, ?, 'actif')
            ON DUPLICATE KEY UPDATE 
            password = VALUES(password), 
            role = VALUES(role),
            statut = 'actif'";
    
    $stmt = $mysqli->prepare($sql);
    $nom = ucfirst(explode('@', $email)[0]);
    $stmt->bind_param('ssss', $nom, $email, $password_hash, $role);
    
    if ($stmt->execute()) {
        echo "   ✅ $email (rôle: $role) - mise à jour réussie\n";
    } else {
        echo "   ❌ $email - ERREUR: " . $stmt->error . "\n";
    }
}
echo "\n";

// 4. Vérifier équipements
echo "4️⃣  Vérification du matériel...\n";
$result = $mysqli->query("SELECT COUNT(*) as count FROM equipment");
$row = $result->fetch_assoc();
echo "   ✅ " . $row['count'] . " équipements trouvés\n\n";

// 5. Afficher identifiants de démonstration
echo "5️⃣  Identifiants de démonstration (tous les mots de passe: 'password')\n";
echo "   ┌─────────────────────────────────────────────┐\n";
echo "   │ ADMIN                                       │\n";
echo "   │ Email: admin@somaf.com                      │\n";
echo "   │                                             │\n";
echo "   │ EMPLOYE                                     │\n";
echo "   │ Email: pierre@somaf.com                     │\n";
echo "   │                                             │\n";
echo "   │ MECANICIEN                                  │\n";
echo "   │ Email: marc@somaf.com                       │\n";
echo "   │                                             │\n";
echo "   │ CHARGE MATERIEL                             │\n";
echo "   │ Email: charge_materiel@somaf.com            │\n";
echo "   └─────────────────────────────────────────────┘\n\n";

// 6. Afficher URL de test
echo "6️⃣  URL de connexion:\n";
echo "   http://localhost/Somaf/connexion.php\n\n";

echo "═══════════════════════════════════════════════════════\n";
echo "✅ SETUP TERMINÉ - Vous pouvez maintenant vous connecter!\n";
echo "═══════════════════════════════════════════════════════\n";
?>
