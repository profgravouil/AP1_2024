
<?php 
function motDePasse($longueur) { // par défaut, on affiche un mot de passe de 5 caractères
 // chaine de caractères qui sera mis dans le désordre:
 $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!+()*-/"; // 62 caractères au total
 // on mélange la chaine avec la fonction str_shuffle(), propre à PHP
 $Chaine = str_shuffle($Chaine);
 // ensuite on coupe à la longueur voulue avec la fonction substr(), propre à PHP aussi
 $Chaine = substr($Chaine,0,$longueur);
 // ensuite on retourne notre chaine aléatoire de "longueur" caractères:
 return $Chaine;
}


include "_conf.php";
if (isset($_POST['email']))
{
     $lemail=$_POST['email'];
     echo "le formulaire a été envoyé avec comme email la valeur :".$lemail;
     if($connexion=mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD))
     {
         echo "connexion ok";
         //A faire après la sélection BDD
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
            echo "email non trouvé";
        }
        else {

            //ETAPE1 : on génére un mot de passe aléatoire
            $newmdp=motDePasse(12);
            echo "<hr>$newmdp<hr>";
            
            $mdphache=md5($newmdp);
            //ETAPE2: on modifie la BDD UPDATE avec le nouveau mot de passe haché
            $requete="UPDATE `utilisateur` SET `motdepasse` = '$mdphache' WHERE email='$lemail';";
            if (!mysqli_query($connexion,$requete)) 
            {
                 echo "<br>Erreur : ".mysqli_error($connexion)."<br>";
            }
            //ETAPE3 : envoie du nouveau mot de passe

	        echo "<br>email trouvé  = envoi de l'email'";
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


