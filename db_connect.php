<?php
	try
	{
		$bdd= new PDO ('mysql:host=localhost;dbname=sunucampus','sunucampus','sunucampus@2016', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}
	catch(PDOexeption $e)
	{
		die('Erreur'.$e->getmessage());
	}
?>
