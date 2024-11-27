<?php 
session_start();
if (isset($_POST['send_deco']))
{
	echo "déconnexion réussi";
	session_destroy();
}
?>

<form method="post" action="accueil.php">
login <input type="text" name="login"> <br>
mot de passe <input type="password" name="mdp"> <br>
<input type="submit" name="send_con" value="OK"> <br>
</form>

<a href="oubli.php">oubli mot de passe </a>