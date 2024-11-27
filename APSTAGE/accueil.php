<?php 
session_start();

if (isset($_POST['send_con']))
{
	$login=$_POST['login'];
	$mdp=$_POST['mdp'];
	$mdp=md5($mdp);
	include "_conf.php";
	if($connexion=mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD))
    {
		$requete="Select * from utilisateur WHERE login='$login' and motdepasse='$mdp'";
		//echo $requete;
        $resultat = mysqli_query($connexion, $requete);
        $trouve=0;
	    while($donnees = mysqli_fetch_assoc($resultat))
	    {
			$trouve=1;
			$_SESSION['Sid']=$donnees['num'];
			$_SESSION['Slogin']=$donnees['login'];
		
			$_SESSION['Stype']=$donnees['numType'];
			//echo "<hr>".$donnees['num']."-".$donnees['login']."-".$donnees['numType'];
		}
		if($trouve==1)
		{
			echo "connexion réussie";
		}
		else {
			echo "login/mdp pas trouvé";
		}
	}

}

//si j'ai une variable de session
if (isset($_SESSION['Sid']))
{

	echo "toujours connecté en tant que  ".$_SESSION['Slogin'];
	echo "<br> <a href='perso.php'>lien vers mes infos persos </a>";
?>
   <form method="post" action="index.php">
   <input type="submit" value="déconnexion" name="send_deco">
   </form>

<?php
  //PARTIE PROF
  echo "<hr>session type = ".$_SESSION['Stype'];
  
  if($_SESSION['Stype']==1)
  {
	  echo "<hr>PARTIE PROF ddd";
  } 
  //PARTIE ELEVE
  else {
		echo "<hr>PARTIE ELEVE ";	# code...
	}

}




?>