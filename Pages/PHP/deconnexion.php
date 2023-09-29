<?php
session_start(); // Démarrage de la session
// Vérifier si l'utilisateur a cliqué sur le bouton de déconnexion
if(isset($_POST['deconnexion'])) {
    // Supprimer toutes les variables de session
    session_unset();
    // Détruire complètement la session
    session_destroy();
    // Rediriger vers une page de connexion ou une autre page appropriée
    header("Location: ../Connexion.php");
    exit();
}
?>