<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectez-vous</title>
    <link rel="stylesheet" href="Scripts/styles_Connexion.css">
    <link rel="stylesheet" href="Scripts/styles_loader.css">
    <link rel="icon" href="Medias/GSB-icon.ico" type="image/logo">


    <?php
    session_start();
    if(isset($_SESSION['ok']) && $_SESSION['role'] == "V"){
        header("Location: Visiteurs.php");
        exit();
    }
    else if(isset($_SESSION['ok']) && $_SESSION['role'] == "C"){
        header("Location: Comptables.php");
        exit();
    }
    ?>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="Medias/logo.png" alt="logo">
        </div>
        <div class="login-container">
            <form action="verif_connexion.php" method="post">
                <h2 class="titre">Connexion</h2>
                <div class="input-container">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <input type="text" placeholder="Identifiant" name="login" class="input" required>
                    </div>
                </div>
                <div class="input-container">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" placeholder="Mot de passe" name="mdp" class="input" required>
                    </div>
                </div>
                <a href="Mail.html">Mot de passe oublié</a>
                <input type="submit" class="btn" value="Connexion">
            </form>
            <div id="erreur" style="color: red"></div>
        </div>
    </div>
    <div class="loader" id="loader">
        <div class="spinner"></div>
    </div>
    <script src="Scripts/script_load.js"></script>
</body>
</html>