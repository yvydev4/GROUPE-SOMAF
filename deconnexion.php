<?php
/**
 *  DÉCONNEXION DE L'UTILISATEUR
 * 
 * Cette page détruit la session de l'utilisateur et le redirige vers
 * la page de connexion.
 */

require_once 'config.php';

// Détruire complètement la session
session_destroy();

// Rediriger vers la connexion
rediriger('connexion.php?deconnecte=1');
?>
