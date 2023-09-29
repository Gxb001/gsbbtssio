<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un utilisateur</title>
</head>
<body>
<h1>Ajouter un utilisateur</h1>
<form method="post" action="ajouter_utilisateur.php">
    <label>Login :</label>
    <input type="text" name="login" required><br><br>
    <label>Mot de passe :</label>
    <input type="password" name="mdp" required><br><br>
    <label>Nom :</label>
    <input type="text" name="nom" required><br><br>
    <label>Prenom :</label>
    <input type="text" name="prenom" required><br><br>
    <label>Adresse :</label>
    <input type="text" name="adresse" required><br><br>
    <label>cp :</label>
    <input type="text" name="cp" required><br><br>
    <label>Ville :</label>
    <input type="text" name="ville" required><br><br>
    <label>date :</label>
    <input type="datetime-local" name="date" required><br><br>
    <label>Role :</label>
    <input type="text" name="role" placeholder="C ou V" required><br><br>
    <input type="submit" value="Ajouter">
</form>
</body>
</html>

<?php
// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $login = $_POST["login"];
    $mdp = $_POST["mdp"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $cp = $_POST["cp"];
    $ville = $_POST["ville"];
    $date = $_POST["date"];
    $role = $_POST["role"];
    $mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);

    // Connexion à la base de données
    require("connect_bd.php");

    // Préparation de la requête SQL
    $req = "INSERT INTO visiteur (login, mdp, nom, prenom, adresse, cp, ville, dateEmbauche, role) VALUES ('$login', '$mdp_hache', '$nom', '$prenom', '$adresse', '$cp', '$ville', '$date', '$role')";

    $res = $connexion->query($req);
    // Exécution de la requête SQL
    if ($res) {
        echo "L'utilisateur a été ajouté avec succès";
    } else {
        echo "Erreur : " . $req;
    }


}
?>

