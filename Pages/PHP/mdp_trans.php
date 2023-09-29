<?php
//hachage des mots de passe de la base de données gsb_frais dans la table visiteur
// Connexion à la base de données
require("connect_bd.php");

// Préparation de la requête SQL
$req = "SELECT id, mdp FROM visiteur";

$res = $connexion->query($req);
// Exécution de la requête SQL
if ($res) {
    while ($ligne = $res->fetch()) {
        $mdp_hache = password_hash($ligne['mdp'], PASSWORD_DEFAULT);
        $req2 = "UPDATE visiteur SET mdp = '$mdp_hache' WHERE id = '$ligne[id]'";
        $res2 = $connexion->query($req2);
    }
} else {
    echo "Erreur : " . $req;
}
