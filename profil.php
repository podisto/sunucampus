<?php session_start(); ?>
<!--Control Panel for admins-->
	<?php
		if( !isset($_SESSION['role']) && !isset($_SESSION['password']) && !isset($_SESSION['pseudo']) &&
		   	 empty($_SESSION['role']) && empty($_SESSION['password']) && empty($_SESSION['pseudo']) )
				{
					// if($_SESSION['role']!='admin')	
					// {
						header("location:index.php");
					// }
				}
	?>

<?php 
				// var_dump($_SESSION);die;

	require_once('db_connect.php');

	function debug($variable){
		// echo '<pre>'.print_r($variable,true).'</pre>';
		foreach ($variable as $type => $message) {
					echo $message."</br></br>";
		}
	}

	$errors=array();
	$success=array();

	if(!empty($_POST)){
		if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'])){
			$errors['pseudo']="Ce pseudo n'est pas valide. Il doit être alphanumérique! Exemple : super_user09";
		}else {
			if($_POST['pseudo']!=$_SESSION['pseudo']){
				$rep = $bdd->prepare('SELECT id FROM user WHERE pseudo=?');
				$rep->execute([$_POST['pseudo']]);
				$user=$rep->fetch();
				if($user){
					$errors['pseudo']="Ce pseudo est déjà pris. Veuillez en choisir un autre !";
				}
			}
			
		}

		if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors['email']="Votre email n'est pas valide. Veuillez respecter le bon format! Exemple : email@exemple.com";
		} 

		if(empty($_POST['nom'])){
			$errors['nom']="Vous devez rentrer un nom valide !";
		}

		if(empty($_POST['prenom'])){
			$errors['prenom']="Vous devez rentrer un prenom valide !";
		}

		if(empty($errors)){
			$requete=$bdd->prepare('UPDATE user SET pseudo=:username, nom=:name,prenom=:nickname,mail=:email WHERE id=:uid');
			$requete->execute(array('username' => $_POST['pseudo'], 'name' => $_POST['nom'], 'nickname' => $_POST['prenom'], 'email' => $_POST['email'], 'uid' => $_SESSION['uid'] ));


			if($requete!=false){
				$_SESSION['pseudo']=$_POST['pseudo'];
				$success['ok']="Votre profil a été mis à jour avec succès";
			}
			else{
				$errors['echec']="La mise a jour de votre profil a échouée. Veuillez réessayer plus tard ou contactez le staff en cas de problème";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page D'accueil</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/profile.css">
</head>
<body>
<div id="wrapper">
	<!-- Header -->
	<header>
		<!--Include the page's head-->
		<?php include('PageHead.php');?>

		<!-- header image -->
		<img src="img/banners/accueil.png" width="100%" height="100%" alt="">
	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>

	<?php
		if(!empty($_SESSION['pseudo']) && !empty($_SESSION['password']) && isset($_SESSION['pseudo']) && isset($_SESSION['password']))
			{ 
				
				// debug($success);

				$rep=$bdd->prepare('SELECT * FROM user WHERE pseudo=:username');
				$rep->execute(array('username' => $_SESSION['pseudo']));
				$donnees_user=$rep->fetch();	

				$rep3=$bdd->prepare('SELECT DAY(date_inscription) AS jour, MONTH(date_inscription) AS mois, YEAR(date_inscription) AS annee, MINUTE(date_inscription) AS minute, HOUR(date_inscription) AS heure FROM user WHERE pseudo=:username');
				$rep3->execute(array('username' => $_SESSION['pseudo']));
				$inscription_user=$rep3->fetch();	

				// var_dump($inscription_user);die;

				$rep2=$bdd->prepare('SELECT * FROM dossier WHERE user_id=:uid');
				$rep2->execute(array('uid'=>$_SESSION['uid']));
				$donnees_dossier=$rep2->fetch();
			}
	?>

	<style type="text/css">

		#infos_profil input{
			width: 90%;
			height: 40px;
			border-radius: 3px;
			color: white;
			background-color: rgba(255,255,255,0.1);
			border: 1px rgba(255,255,255,0.5) solid;
			margin: 5px 0px 5px 0px;
			-webkit-transition: 0.5s;
			-moz-transition: 0.5s;
			transition: 0.5s;
			text-align: center;
			font-size: 15px;
		}

		#infos_profil input:focus{
			background-color: white;
			color: teal;
			font-size: 15px;
			outline-color: teal;
		}

		#infos_profil input[type=password]{
			background-color: rgba(0,0,0,0.4);
		}

/*		#infos_profil input{
			border: solid 1px black;
			margin: 5px;
			text-align: center;
			padding-top: 8px;
			padding-bottom: 8px;	
			border-radius: 5px;
		}*/

		#infos_profil p:hover{
			background-color: rgba(255,255,255,0.5);
			color: black;
			/*border: white solid 3px;*/
		}

		#modifier_profil {
			border: solid 2px white;
			margin: 5px;
			text-align: center;
			padding-top: 8px;
			padding-bottom: 8px;	
			border-radius: 5px;
			background-color: rgba(255,255,255,0);
			color: white;
			font-size: 15px;
			letter-spacing: 1.5px;
			width: 40%;
		}

		#modifier_profil:hover{
			background-color: white;
			color: teal;
		}
	</style>

	<!--Main page-->
	<div style="width: 100%;height: auto;min-height: 600px;position: relative; ">
		<?php if(!empty($errors)): ?>
				<div style='width:100%;background-color:red;color:white;font-size:18px;text-align: center;padding-top: 20px;p '>
					<?php debug($errors); ?>
				</div>
		<?php endif; ?>
		<?php if(!empty($success)): ?>
				<div style='width:100%;background-color:green;color:white;font-size:18px;text-align: center;padding-top: 20px;p '>
					<?php debug($success); ?>
				</div>
		<?php endif; ?>
		<!-- Bloc contenant les infos de l'utilisateur -->
		<div style="width: 300px;height: auto; min-height: 500px;border:solid black 1.5px;margin: auto;vertical-align: middle;border-radius: 5px;box-shadow: 0 0 20px black;margin-top: 50px;margin-bottom: 100px; background-color: rgba(0,128,128,0.5);position: relative;text-align: center; ">
			<!-- Bloc supérieur -->
			<div style="width: 100%;height: 100px;position: relative;padding-bottom: 10px;margin-bottom: 20px;background-color: rgba(0,128,128,0.5); ; ">
				<!-- Photo de profil de l'utilisateur -->
				<a href="user_photo_upload.php"><img id="profile_picture" src="img/<?php if($donnees_user['avatar']!=0 && !empty($donnees_user['avatar'])) echo "avatar/".$donnees_user['avatar'];else echo "default_profile.png"; ?>" style=" border-radius: 50%;width: 90px;margin: 10px auto auto 20px;box-shadow: 0 0 20px black; "></a>
				<p style="display: block;width:60%;float: right;text-align: center; font-size: 30px;color: white;font-weight: bold;letter-spacing: 2px;font-style: italic;margin: 0px;height: auto;padding-top:34px;word-wrap: break-word;overflow: auto; "><?php echo $donnees_user['pseudo']; ?></p>
			</div >
			
			<form action="" method="post">
				<!-- Bloc infos -->				
				<div id="infos_profil">
					<input type="text" name="nom" value="<?php echo $donnees_user['nom'];?>">
					<input type="text" name="prenom" value="<?php echo $donnees_user['prenom'];?>">
					<input type="text" name="pseudo" value="<?php echo $donnees_user['pseudo'];?>">
					<input type="email" name="email" value="<?php echo $donnees_user['mail'];?>">
					<input type="password" name="" disabled="disabled" value="**********">
				</div>
				<div style="text-align: right; "><button id="modifier_profil" type="submit">Modifier</button></div>
			</form>
			<!-- <div style="width: 100%; "> -->
				<!-- <img src="img/settings.png" style="width: 50px;position:absolute;right: 5px;"> -->
			<!-- </div> -->
			<p style="text-align: center;position: absolute;bottom: 0px;width: 100%;margin: 0px;padding-top: 10px;padding-bottom: 10px;  "> <?php echo "Inscrit le ".$inscription_user['jour']."/".$inscription_user['mois']."/".$inscription_user['annee']." à ".$inscription_user['heure']." heures ".$inscription_user['minute'];?> </p>
		</div>
	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>
</body>
</html>

<?php 
	if(empty($erros)){

	}
?>

