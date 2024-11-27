
<?php 
function motDePasse($longueur) { // par d�faut, on affiche un mot de passe de 5 caract�res
 // chaine de caract�res qui sera mis dans le d�sordre:
 $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!+()*-/"; // 62 caract�res au total
 // on m�lange la chaine avec la fonction str_shuffle(), propre � PHP
 $Chaine = str_shuffle($Chaine);
 // ensuite on coupe � la longueur voulue avec la fonction substr(), propre � PHP aussi
 $Chaine = substr($Chaine,0,$longueur);
 // ensuite on retourne notre chaine al�atoire de "longueur" caract�res:
 return $Chaine;
}


include "_conf.php";
if (isset($_POST['email']))
{
     $lemail=$_POST['email'];
     echo "le formulaire a �t� envoy� avec comme email la valeur :".$lemail;
     if($connexion=mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD))
     {
         echo "connexion ok";
         //A faire apr�s la s�lection BDD
        $requete="Select * from utilisateur WHERE email='$lemail'";
        echo "<br>".$requete."<br>";
        $resultat = mysqli_query($connexion, $requete);
        $login=0;
	    while($donnees = mysqli_fetch_assoc($resultat))
	    {
		    $login =$donnees['login']; //mettre le nom du champ dans la table
		    $mdp =$donnees['motdepasse'];	
            
	    }
        if ($login==0)
        {
            echo "email non trouv�";
        }
        else {

            //ETAPE1 : on g�n�re un mot de passe al�atoire
            $newmdp=motDePasse(12);
            echo "<hr>$newmdp<hr>";
            
            $mdphache=md5($newmdp);
            //ETAPE2: on modifie la BDD UPDATE avec le nouveau mot de passe hach�
            $requete="UPDATE `utilisateur` SET `motdepasse` = '$mdphache' WHERE email='$lemail';";
            if (!mysqli_query($connexion,$requete)) 
            {
                 echo "<br>Erreur : ".mysqli_error($connexion)."<br>";
            }
            //ETAPE3 : envoie du nouveau mot de passe

	        echo "<br>email trouv�  = envoi de l'email'";
            // Le message
        $message = "votre nouveau mot de passe est : '$newmdp' - votre login : '$login'";

        // Envoi du mail
        mail($lemail, 'Votre login/mot de passe sur le site des stages', $message);
        }


     }
     else {
	    echo "erreur de connexion";
   }

}
else
{
?>

    <form method="POST">
    <input type="email" name="email">
    <input type="submit" value="OK" name="envoi">

    </form>
<?php
}
?>


