<?php 
	session_start();

	if(!empty($_GET)){
		$id_topic=(int)($_GET['id']);
		require_once 'db_connect.php';

		// Verify if the persone who wanna edit the post is the one who posted it
		$verification=$bdd->prepare('SELECT id_user FROM for_content WHERE id=:id_topic');
		$verification->execute(array('id_topic' => $id_topic));
		$verif_result=$verification->fetch();

		if($verif_result['id_user']!=$_SESSION['uid']){
			$_SESSION['flash']['warning']="Il semble que vous avez tenté de modifier un contenu dont vous n'êtes pas le propriétaire. Votre action a été annulée";
			header('location:forum_topics.php');
			exit();
		}

		$requete=$bdd->prepare('UPDATE for_content SET solved=1 WHERE id=:id_topic');
		$requete->execute(array('id_topic' => $id_topic));

		if($requete!=false){
			$_SESSION['flash']['success']="Votre topic a été marqué comme résolu !";
			header('location:forum_read.php?id='.$id_topic);
			exit();
		}else{
			$_SESSION['flash']['failure']="Une erreur s'est produite lors du traitement, veuillez réessayer !";
			header('location:forum_read.php?id='.$id_topic);
			exit();
		}
	}else{
		header('location:forum_topics.php');
		exit();
	}