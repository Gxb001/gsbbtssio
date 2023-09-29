<?php
echo "
<style>@import url('https://fonts.googleapis.com/css2?family=Oswald&family=Yantramanav:wght@500&display=swap');
body{
    background-color: #1a1a1a;
    font-family: 'Yantramanav', sans-serif;
    color: black;
    text-align: center;
    font-size: 20px;
}
.rectangle{
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 300px;
  height: 200px;
  background-color: white;
  border-radius: 7px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
    
}
</style>";
echo "<div class=rectangle>
       Demande prise en compte. Vous allez etre rediriger vers la page de connexion dans 5 secondes.
    </div>";
header("refresh:5;url=../Connexion.php");
exit;
?>



