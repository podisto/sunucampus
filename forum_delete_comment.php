<?php
	session_start();

	if(!empty($_GET['id']) && isset($_GET['id']) && !empty($_GET['page']) && isset($_GET['page']) ){
		$id=(int)($_GET['id']);
		$page=(int)($_GET['page']);

		require_once 'db_connect.php';

		// Verify if the persone who wanna edit the post is the one who posted it
		$verification=$bdd->prepare('SELECT id_user FROM for_messages WHERE id=:id_comment');
		$verification->execute(array('id_comment' => $id));
		$verif_result=$verification->fetch();

		if($verif_result['id_user']!=$_SESSION['uid']){
			$_SESSION['flash']['warning']="Il semble que vous avez tenté de modifier un contenu dont vous n'êtes pas le propriétaire. Votre action a été annulée";
			header('location:forum_topics.php');
			exit();
		}

		$suppression=$bdd->prepare('DELETE FROM for_messages WHERE id=:id_message');
		$suppression->execute(array('id_message' => $id));

		if($suppression!=false){
			$_SESSION['flash']['success']="Votre commentaire a été supprimé avec succès";
			header('location:forum_read.php?id='.$page);
			exit();
		}
		else{
			$_SESSION['flash']['failure']="La suppression de votre commentaire a échouée. Veuillez réessayer plus tard";
			header('location:forum_read.php?id='.$page);
			exit();
		}

	}