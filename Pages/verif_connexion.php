<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectez-vous</title>
    <script>
        function logerr(){
            var madiv = document.getElementById("erreur");
            madiv.innerHTML = "Login ou mot de passe incorrect";
        }
    </script>
</head>
<body>
<?php
	include("PHP/connect_bd.php");
	$login = $_POST['login'];
	$mdp = $_POST['mdp'];

	$sql = "SELECT * FROM visiteur WHERE login = '$login'";
	$result = $connexion->query($sql);
	$ligne = $result->fetch();
    if ($ligne)
    {
        $motPasseBdd = $ligne['mdp'];
        $role = $ligne['role'];

        if(!password_verify($mdp, $motPasseBdd))
        {
            include 'Connexion.php';
            echo "<script>logerr();</script>";
        }
        else if($role=="V" && password_verify($mdp, $motPasseBdd)){
            session_start();
            $_SESSION['ok'] = "oui";
            $_SESSION['ID'] = $ligne['id'];
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $role;
            // Retour vers la page d'entr�e du site
            header("Location: Visiteurs.php");
            // On quitte le script courant sans effectuer les �ventuelles  instructions qui suivent
            exit;
        }
        else if($role=="C" && password_verify($mdp, $motPasseBdd)){
            session_start();
            $_SESSION['ok'] = "oui";
            $_SESSION['ID'] = $ligne['id'];
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $role;
            header("Location: Comptables.php");
            exit;
        }
    }
    else
    {
        include 'Connexion.php';
        echo "<script>logerr();</script>";
    }

	$result->closeCursor();
	$connexion = null;

?>
</body>
</html>