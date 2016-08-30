<?php session_start(); ?>

<?php 
	try
	{
		$bdd=new PDO ('mysql:host=localhost;dbname=sunucampus','root','');
	}
	catch(PDOexeption $e)
	{
		die('Erreur'.$e->getmessage());
	}

	if( isset($_GET['param']) && !empty($_GET['param']))
	{	$id=addslashes(strip_tags($_GET['param']));
	
		$req=$bdd->prepare('UPDATE contact SET etat=0 WHERE id=:id_message');
		$req->execute(array('id_message'=> $id ));
		if($req!=false){
			header('location:admin_messages_list.php#ancre_nav');
			$_SESSION['flash']['success']='Le message a été archivé avec succès !';
		}
		else{
			header('location:admin_messages_list.php#ancre_nav') ;
			$_SESSION['flash']['erreur']='L\'archivage du message a échouée';
		}
	}
	
	echo "Une erreur s'est produite. Veuillez réessayer";
?>

