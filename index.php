<?php
/**
 * INDEX.PHP - PAGE D'ACCUEIL
 * 
 * Cette page est la première page visitée par tous les utilisateurs.
 * Elle détecte si l'utilisateur est connecté et le redirige vers
 * le dashboard approprié selon son rôle.
 * 
 * - Si pas connecté → rediriger vers connexion.php
 * - Si connecté + admin → rediriger vers admin/dashboard.php
 * - Si connecté + employé → rediriger vers employe/dashboard.php
 * - Etc.
 */

// Toujours charger config.php en premier (la première ligne!)
require_once 'config.php';

// Si l'utilisateur est déjà connecté, le rediriger vers son dashboard
if (connecte()) {
    // Vérifier le rôle et le poste pour rediriger correctement
    if (est_admin()) {
        rediriger('admin/dashboard.php');
    } elseif (est_mecanicien()) {
        rediriger('mecanicien/dashboard.php');
    } elseif (est_charge_materiel()) {
        rediriger('charge_materiel/dashboard.php');
    } else {
        // Par défaut, envoyer vers le dashboard employé
        rediriger('employe/dashboard.php');
    }
}

// Si pas connecté, rediriger vers la connexion
rediriger('connexion.php');
?>
