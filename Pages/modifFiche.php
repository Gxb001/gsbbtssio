<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Medias/GSB-icon.ico" type="image/logo">
</head>
<body>

<?php
session_start();
$mois = $_GET['mois'];
if(isset($_SESSION['ok']) && $_SESSION['role'] == "C"){
    header("Location: Comptables.php");
    exit();
}
else if(!isset($_SESSION['ok']) || $_SESSION['ok'] != "oui"){
    header("Location: Connexion.php");
    exit();
}
if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)){
    session_unset();
    session_destroy();
    header("Location: Connexion.php");
    exit();
}
?>


<h2>Modifier une fiche de frais HF : </h2>
<?php
$req_ficheHF = ("SELECT * FROM lignefraishorsforfait WHERE idvisiteur = '$id_visiteur'");
$result_ficheHF = $connexion->query($req_ficheHF);

//affichage des fiches de frais hors forfait
echo "<table>";
echo "<tr>";
echo "<th>" . "Id : " . "</th>";
echo "<th>" . "Date Validation : " . "</th>";
echo "<th>" . "Libelle : " . "</th>";
echo "<th>" . "Mois : " . "</th>";
echo "<th>" . "Montant : " . "</th>";
echo "</tr>";
while($result_ficheHF ->fetch()){
    echo "<tr>";
    echo "<td>" . $result_ficheHF['id'] . "</td>";
    echo "<td>" . $result_ficheHF['date'] . "</td>";
    echo "<td>" . $result_ficheHF['libelle']. "</td>";
    echo "<td>" . $result_ficheHF['mois']. "</td>";
    echo "<td>" . $result_ficheHF['montant']. "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>

