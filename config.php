<?php
/**
 * ========================================================================
 * CONFIG.PHP - FICHIER CENTRAL DE CONFIGURATION
 * ========================================================================
 * 
 * Ce fichier est le cœur du projet. Il fait 4 choses essentielles :
 * 
 * 1. Démarre la SESSION (pour mémoriser qui est connecté)
 * 2. Se connecte à la BASE DE DONNÉES MySQL
 * 3. Définit les FONCTIONS utilitaires réutilisables
 * 4. Vérifie que l'utilisateur connecté existe toujours
 * 
 * ========================================================================
 */

// ===========================================
// 1. DÉMARRER LA SESSION
// ===========================================
// La session permet de mémoriser l'utilisateur entre les pages.
// Exemple : quand vous vous connectez, votre ID est stocké dans $_SESSION
// et reste disponible sur toutes les pages.
session_start();


// ===========================================
// 2. CONNEXION À LA BASE DE DONNÉES
// ===========================================
// Paramètres de connexion MySQL (à adapter selon votre serveur)
$host     = 'localhost';              // Serveur MySQL
$username = 'root';                   // Utilisateur MySQL
$password = '';                       // Mot de passe MySQL (vide par défaut WAMP)
$database = 'somaf_materiel';         // Nom de la base de données

// Créer la connexion
$mysqli = new mysqli($host, $username, $password, $database);

// Vérifier si la connexion a réussi
if ($mysqli->connect_error) {
    die("❌ ERREUR DE CONNEXION À LA BASE DE DONNÉES : " . $mysqli->connect_error);
}

// Définir l'encodage en UTF-8 (important pour les caractères accentués)
$mysqli->set_charset("utf8mb4");


// ===========================================
// 3. FONCTIONS UTILITAIRES
// ===========================================
// Ce sont des petites fonctions qu'on réutilise partout dans le projet
// pour éviter de répéter le même code.

/**
 * FONCTION : connecte()
 * BUT : Vérifier si l'utilisateur est connecté
 * RETOUR : true si connecté, false sinon
 * EXEMPLE : if (connecte()) { echo "Bienvenue !"; }
 */
function connecte() {
    // Si $_SESSION['user_id'] existe, c'est qu'on est connecté
    return isset($_SESSION['user_id']);
}

/**
 * FONCTION : est_admin()
 * BUT : Vérifier si l'utilisateur est administrateur
 * RETOUR : true si admin, false sinon
 * EXEMPLE : if (est_admin()) { afficher le bouton "Créer utilisateur"; }
 */
function est_admin() {
    // On vérifie si le rôle stocké en session est 'admin'
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * FONCTION : est_employe()
 * BUT : Vérifier si l'utilisateur est un simple employé
 * RETOUR : true si employé, false sinon
 */
function est_employe() {
    // On vérifie si le rôle est 'employe'
    return isset($_SESSION['role']) && $_SESSION['role'] === 'employe';
}

/**
 * FONCTION : est_mecanicien()
 * BUT : Vérifier si l'utilisateur est mécanicien
 * RETOUR : true si mécanicien, false sinon
 * NOTE : On regarde le champ 'poste' qui est défini par l'admin
 */
function est_mecanicien() {
    // Si le poste n'existe pas, c'est que ce n'est pas un mécanicien
    if (!isset($_SESSION['poste'])) {
        return false;
    }
    
    // On met le poste en minuscules et on supprime les accents
    $poste = strtolower($_SESSION['poste']);
    $poste = str_replace(['é', 'è', 'ê', 'ë'], 'e', $poste);
    
    // On cherche le mot "mecanicien" dans le poste
    return strpos($poste, 'mecanicien') !== false;
}

/**
 * FONCTION : est_charge_materiel()
 * BUT : Vérifier si l'utilisateur est "Chargé du matériel"
 * RETOUR : true si chargé du matériel, false sinon
 * NOTE : Ce rôle valide les retours d'emprunts
 */
function est_charge_materiel() {
    // Si le poste n'existe pas, ce n'est pas un chargé du matériel
    if (!isset($_SESSION['poste'])) {
        return false;
    }
    
    // Mettre en minuscules et supprimer accents
    $poste = strtolower($_SESSION['poste']);
    $poste = str_replace(['é', 'è', 'ê', 'ë', '→'], 'e', $poste);
    $poste = str_replace(['ç'], 'c', $poste);
    
    // On cherche "charge" ET "materiel" dans le poste
    return strpos($poste, 'charge') !== false && strpos($poste, 'materiel') !== false;
}

/**
 * FONCTION : exiger_connexion()
 * BUT : Vérifier que l'utilisateur est connecté.
 *       Si pas connecté, le rediriger vers la page de connexion
 * EXEMPLE : Au début d'une page protégée, mettre : exiger_connexion();
 */
function exiger_connexion() {
    // Si pas connecté, on le redirige
    if (!connecte()) {
        rediriger('connexion.php');
    }
}

/**
 * FONCTION : exiger_admin()
 * BUT : Vérifier que l'utilisateur est admin.
 *       Si pas admin, le rediriger vers son dashboard
 * EXEMPLE : Au début d'une page admin, mettre : exiger_admin();
 */
function exiger_admin() {
    exiger_connexion();  // D'abord, vérifier qu'il est connecté
    
    if (!est_admin()) {
        // Si ce n'est pas un admin, on le redirige
        rediriger('index.php');
    }
}

/**
 * FONCTION : exiger_employe()
 * BUT : Vérifier que l'utilisateur est un employé
 */
function exiger_employe() {
    exiger_connexion();
    
    if (!est_employe()) {
        rediriger('index.php');
    }
}

/**
 * FONCTION : exiger_mecanicien()
 * BUT : Vérifier que l'utilisateur est un mécanicien
 */
function exiger_mecanicien() {
    exiger_connexion();
    
    if (!est_mecanicien()) {
        rediriger('index.php');
    }
}

/**
 * FONCTION : exiger_charge_materiel()
 * BUT : Vérifier que l'utilisateur est chargé du matériel
 */
function exiger_charge_materiel() {
    exiger_connexion();
    
    if (!est_charge_materiel()) {
        rediriger('index.php');
    }
}

/**
 * FONCTION : echapper($texte)
 * BUT : Protéger le texte avant de l'afficher en HTML
 *       Cela évite les attaques "injection de code" (XSS)
 * EXEMPLE : echo echapper($_GET['nom']);  // Sûr !
 * NOTE : On doit TOUJOURS utiliser cette fonction pour afficher les données
 *        venant de l'utilisateur ou de la base de données
 */
function echapper($texte) {
    // htmlspecialchars() transforme les caractères spéciaux en codes HTML
    // Exemple : < devient &lt;
    // Cela empêche les scripts malveillants de s'exécuter
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}

/**
 * FONCTION : lire_post($clé, $défaut)
 * BUT : Lire une valeur envoyée par un formulaire (méthode POST)
 * EXEMPLE : $nom = lire_post('nom', 'Anonyme');
 *           // Si le champ 'nom' n'existe pas, utiliser 'Anonyme'
 * NOTE : On utilise 'trim()' pour enlever les espaces au début et à la fin
 */
function lire_post($clé, $défaut = '') {
    // Si la clé existe en POST, la lire et enlever les espaces
    // Sinon, utiliser la valeur par défaut
    return trim($_POST[$clé] ?? $défaut);
}

/**
 * FONCTION : lire_get($clé, $défaut)
 * BUT : Lire une valeur depuis l'URL (méthode GET)
 * EXEMPLE : $id = lire_get('id', 0);
 *           // Si l'URL est "page.php?id=5", retourne 5
 *           // Sinon, retourne 0
 */
function lire_get($clé, $défaut = '') {
    // Si la clé existe en GET, la lire et enlever les espaces
    // Sinon, utiliser la valeur par défaut
    return trim($_GET[$clé] ?? $défaut);
}

/**
 * FONCTION : rediriger($url)
 * BUT : Rediriger l'utilisateur vers une autre page
 * EXEMPLE : rediriger('connexion.php');
 *           // L'utilisateur est immédiatement envoyé vers connexion.php
 * ATTENTION : Après cette fonction, le code s'arrête !
 */
function rediriger($url) {
    // Utiliser header() pour faire une vraie redirection HTTP
    header('Location: ' . $url);
    exit;  // Arrêter le script (important !)
}

/**
 * FONCTION : libelle_etat($etat)
 * BUT : Transformer le code de l'état du matériel en texte lisible
 * EXEMPLE : libelle_etat('emprunte') retourne "Emprunté"
 * NOTE : On utilise cette fonction partout où on affiche l'état du matériel
 */
function libelle_etat($etat) {
    // Dictionnaire des états et leurs traductions
    $libelles = [
        'disponible'      => 'Disponible',
        'emprunte'        => 'Emprunté',
        'panne'           => 'En panne',
        'en_maintenance'  => 'En maintenance',
        'hors_service'    => 'Hors service'
    ];
    
    // Si l'état existe dans le dictionnaire, retourner la traduction
    // Sinon, retourner l'état tel quel
    return $libelles[$etat] ?? ucfirst(str_replace('_', ' ', $etat));
}

/**
 * FONCTION : libelle_statut_emprunt($statut)
 * BUT : Transformer le code du statut d'emprunt en texte lisible
 * EXEMPLE : libelle_statut_emprunt('en_attente') retourne "En attente de validation"
 */
function libelle_statut_emprunt($statut) {
    $libelles = [
        'en_attente'    => 'En attente de validation',
        'en_cours'      => 'En cours',
        'refuse'        => 'Refusé',
        'retour_demande' => 'Retour demandé',
        'termine'       => 'Terminé'
    ];
    
    return $libelles[$statut] ?? ucfirst(str_replace('_', ' ', $statut));
}

/**
 * FONCTION : libelle_role($role)
 * BUT : Transformer le code du rôle en texte lisible
 */
function libelle_role($role) {
    $libelles = [
        'admin'   => 'Administrateur',
        'employe' => 'Employé'
    ];
    
    return $libelles[$role] ?? ucfirst($role);
}

/**
 * FONCTION : prenom_utilisateur()
 * BUT : Retourner le prénom de l'utilisateur connecté
 * EXEMPLE : Si le nom est "Jean Dupont", retourne "Jean"
 */
function prenom_utilisateur() {
    // Si le nom n'existe pas en session, retourner une chaîne vide
    if (!isset($_SESSION['nom'])) {
        return '';
    }
    
    // On sépare le nom par les espaces et on prend la première partie
    $parties = explode(' ', $_SESSION['nom']);
    return $parties[0];
}

/**
 * FONCTION : generer_matricule()
 * BUT : Créer un matricule unique automatique au format SMF-XXNNNN
 * EXEMPLE : SMF-AB1234, SMF-CD5678, etc.
 * RETOUR : Une chaîne de caractères unique
 * GLOBAL : Utilise $mysqli (la connexion à la base de données)
 */
function generer_matricule() {
    global $mysqli;
    
    do {
        // Générer 2 lettres aléatoires (sans I, O, U pour éviter la confusion)
        $lettres = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 2);
        
        // Générer 4 chiffres aléatoires (avec zéros initiaux : 0001, 0042, etc.)
        $chiffres = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // Construire le matricule final
        $matricule = 'SMF-' . strtoupper($lettres) . $chiffres;
        
        // Vérifier que ce matricule n'existe pas déjà en base
        $verif = $mysqli->prepare("SELECT id FROM equipment WHERE matricule = ?");
        $verif->bind_param("s", $matricule);
        $verif->execute();
        $verif->store_result();
        $existe = $verif->num_rows > 0;
        $verif->close();
        
        // Si le matricule existe déjà, on recommence (boucle do-while)
    } while ($existe);
    
    // Retourner le matricule unique généré
    return $matricule;
}

/**
 * FONCTION : generer_token_invitation()
 * BUT : Créer un token unique pour les invitations
 * RETOUR : Une chaîne aléatoire de 32 caractères
 * EXEMPLE : "7f3a9b2e1c4d8f6a9e2b5c7d0f3a6b9e"
 */
function generer_token_invitation() {
    // bin2hex() transforme les bytes aléatoires en chaîne hexadécimale
    // random_bytes(16) crée 16 bytes aléatoires = 32 caractères hex
    return bin2hex(random_bytes(16));
}

/**
 * FONCTION : envoyer_email($email, $sujet, $message)
 * BUT : Envoyer un email (simplifié pour le projet)
 * NOTE : Pour un projet réel, utiliser une vraie librairie comme PHPMailer
 * POUR LE MOMENT : On affiche juste le lien en attendant ou on utilise mail()
 */
function envoyer_email($email, $sujet, $message) {
    // En développement, on peut juste afficher le message ou le loguer
    // Pour production, configurer mail() ou utiliser PHPMailer
    
    // Tentative simple avec mail() de PHP (si configuré sur le serveur)
    // return mail($email, $sujet, $message, "Content-Type: text/html; charset=UTF-8\r\n");
    
    // Pour maintenant, retourner true (on suppose l'email envoyé)
    return true;
}


// ===========================================
// 4. VÉRIFICATION DE L'UTILISATEUR CONNECTÉ
// ===========================================
// À chaque page, on vérifie que l'utilisateur en session existe toujours
// en base de données. Si son compte a été supprimé ou désactivé → déconnexion.

if (isset($_SESSION['user_id'])) {
    // On cherche l'utilisateur dans la base de données
    $verification = $mysqli->prepare(
        "SELECT id, statut, poste, nom, role, email FROM users WHERE id = ?"
    );
    $verification->bind_param("i", $_SESSION['user_id']);
    $verification->execute();
    $resultat = $verification->get_result()->fetch_assoc();
    $verification->close();
    
    // Si l'utilisateur n'existe plus → le déconnecter
    if (!$resultat) {
        session_destroy();
        rediriger('connexion.php');
    }
    
    // Rafraîchir les informations depuis la base
    // (au cas où l'admin aurait changé le poste, le statut, etc.)
    $_SESSION['statut']  = $resultat['statut'] ?? 'actif';
    $_SESSION['poste']   = $resultat['poste'] ?? '';
    $_SESSION['nom']     = $resultat['nom'] ?? '';
    $_SESSION['role']    = $resultat['role'] ?? 'employe';
    $_SESSION['email']   = $resultat['email'] ?? '';
    
    // Si l'utilisateur a un statut "invitation_pending", le rediriger
    if ($_SESSION['statut'] === 'invitation_pending' && basename($_SERVER['PHP_SELF']) !== 'accepter_invitation.php') {
        rediriger('accepter_invitation.php');
    }
    
    // Si le compte a été désactivé (refusé) → le déconnecter
    if ($_SESSION['statut'] === 'refuse') {
        session_destroy();
        rediriger('connexion.php?erreur=compte_refuse');
    }
}

// ========================================
// FIN DE CONFIG.PHP
// ========================================
?>
