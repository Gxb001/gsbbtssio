<?php
// Definitions de constantes pour la connexion MySQL
$hote="localhost";
$login="admin1";
$mdp="motdepasse1";
$nombd="gsb_frais";

// Connection au serveur
try {
    $connexion =  new  PDO ( "mysql:host=$hote;dbname=$nombd" , $login , $mdp );
} catch ( Exception $e ) {  // Si erreur, afficher le message d'erreur
    die( "Erreur : " . $e -> getMessage ());
}
?>
