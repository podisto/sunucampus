<?php
	session_start();

	if(!empty($_GET['id']) && isset($_GET['id']) ){
		$id_topic=(int)($_GET['id']);

		require_once 'db_connect.php';

		// Verify if the person who wanna delete the post is the one who posted it
		$verification=$bdd->prepare('SELECT id_user FROM for_content WHERE id=:id_topic');
		$verification->execute(array('id_topic' => $id_topic));
		$verif_result=$verification->fetch();

		if($verif_result['id_user']!=$_SESSION['uid']){
			$_SESSION['flash']['warning']="Il semble que vous avez tenté de modifier un contenu dont vous n'êtes pas le propriétaire. Votre action a été annulée";
			header('location:forum_topics.php');
			exit();
		}

		$suppression=$bdd->prepare('DELETE FROM for_content WHERE id=:id_topic');
		$suppression->execute(array('id_topic' => $id_topic));

		if($suppression!=false){
			$_SESSION['flash']['success']="Votre topic a été supprimé avec succès";
			header('location:forum_topics.php?');
			exit();
		}
		else{
			$_SESSION['flash']['failure']="La suppression de votre topic a échouée. Veuillez réessayer plus tard";
			header('location:forum_topics.php');
			exit();
		}

	}