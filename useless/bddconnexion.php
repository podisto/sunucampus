try
				{
					$bdd=new PDO ('mysql:host=localhost;dbname=sunucampus','root','');
				}
				catch(PDOexeption $e)
				{
					die('Erreur'.$e->getmessage());
				}