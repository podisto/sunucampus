			<li><a href="
						<?php
							include('db_connect.php'); 
			 				if(isset($_SESSION['password']) && isset($_SESSION['pseudo']))
			 				{	
			 					$username = $_SESSION['pseudo'];

			 					$req=$bdd->prepare('SELECT dossier.user_id , user.id,user.pseudo FROM dossier,user WHERE dossier.user_id=user.id AND user.pseudo =:nom_user ');
			 					$req->execute(array('nom_user' => $username));

			 					if($donnees=$req->fetch())
			 						echo 'user_gestion_dossier.php';
			 					else
			 						echo 'dossier.php';
			 				}
			 				else
			 					echo "LoginPage.php";
						 ?>">Dépot dossier</a></li>