		<?php 
			try
			{
				$bdd=new PDO ('mysql:host=localhost;dbname=sunucampus','root','');
			}
			catch(PDOexeption $e)
			{
				die('Erreur'.$e->getmessage());
			}

			$req=$bdd->query(	'SELECT COUNT(*) as nbMsg FROM contact WHERE etat=1');
			$donnees=$req->fetch();
			$req->closeCursor();
		?>	