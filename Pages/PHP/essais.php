<?php
include 'connect_bd.php';
function valider(){
$mois = date("m") + 0;
$id_utilisateur = 'A85';
global $id_utilisateur, $connexion;
$req_v = "UPDATE fichefrais SET idEtat = 'RB' WHERE idVisiteur = :id_utilisateur AND mois = :mois";
$stmt = $connexion->prepare($req_v);
$stmt->bindParam(':id_utilisateur', $id_utilisateur);
$stmt->bindParam(':mois', $mois);
$stmt->execute();
$errors = $stmt->errorInfo();
var_dump($errors);

}

function refuser(){
$mois = date("m") + 0;
global $id_utilisateur, $connexion;
$req_r = "UPDATE fichefrais SET idEtat = 'CL' WHERE idVisiteur = :id_utilisateur AND mois = :mois";
$stmt = $connexion->prepare($req_r);
$stmt->bindParam(':id_utilisateur', $id_utilisateur);
$stmt->bindParam(':mois', $mois);
$stmt->execute();

}
?>