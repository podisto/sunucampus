<?php
session_start();


	require_once('db_connect.php');

	if( isset($_GET['param']) && !empty($_GET['param']))
	{	
		$id=addslashes(strip_tags($_GET['param']));
		
		$req=$bdd->prepare('DELETE FROM filiere WHERE id=:id_message');
		$req->execute(array('id_message'=> $id ));
		if($req!=false){
			$_SESSION['flash']['success']='La filière a été supprimée avec succès !';
			header('location:base.php#ancre_nav');
			// $_SESSION['flash']['success']='La filière a été supprimée avec succès !';
		}
		else{
			$_SESSION['flash']['failure']='La suppression de la filière a échouée !';
			header('location:base.php#ancre_nav') ;
		}

	}
?>