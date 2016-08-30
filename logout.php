<?php 
	session_start(); 
	$pseudo=$_SESSION['pseudo'];
	require_once 'db_connect.php';

	$rep=$bdd->prepare('UPDATE user SET last_connexion=NOW() WHERE id=:user_id');
	$rep->execute(array('user_id' => $_SESSION['uid']));

	session_destroy();
	session_start(); 
	$_SESSION['flash']['success']='Au revoir '.$pseudo.'. A très bientôt sur CampuSen!';
	header("location:LoginPage.php");
?>