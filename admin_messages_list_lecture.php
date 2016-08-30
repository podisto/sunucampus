<?php session_start(); ?>
<!--Control Panel for admins-->
	<?php
		if( !isset($_SESSION['role']) && !isset($_SESSION['password']) && !isset($_SESSION['pseudo']) &&
		   	 empty($_SESSION['role']) && empty($_SESSION['password']) && empty($_SESSION['pseudo']) )
				{
					if($_SESSION['role']!='admin')	
					{
						header("location:index.php");
					}
				}
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Gestion du site</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<?php include('include_plugins.php'); ?>
</head>
<body>
	<div id="wrapper">
		<!-- Header -->
		<header>
			<!--Include the page's head-->
			<?php include('PageHead.php');?>

			<!-- header image -->
			<img src="img/banners/gerer.png" width="100%" height="100%" alt="">
		</header>

		<!--Navigation links-->
		<?php include('nav.php'); ?>

		<?php 
			include('db_connect.php');

			$req=$bdd->query(	'SELECT COUNT(*) as nbMsg FROM contact WHERE etat=1');
			$donnees=$req->fetch();
			$req->closeCursor();
		?>		

		<div class="pagebody" >
			<!--Management bar-->
			<?php include('aside_management_bar.php'); ?>

			<div class="viewtype" >
				<div class="choice">
					<a href="admin_messages_list.php"><img src="img/vues/list.png" class="listview"></a>
					<a href="admin_messages_box.php"><img src="img/vues/box.png" class="boxview"></a>
				</div>
			</div>

			<div id="lecture_message" class="animated bounceIn">
			<?php
				// $id=addslashes(strip_tags($_GET['param']));

				if( isset($_GET['param']) && !empty($_GET['param']) && preg_match('#([0-9]+)#',$_GET['param']) && is_numeric($_GET['param']) )
				{	
					$id_sms=$_GET['param'];
					$rep=$bdd->query('SELECT * FROM contact WHERE id='.$id_sms);

					$donnees=$rep->fetch();
					// var_dump($donnees);die;

					if($donnees['id_user']!='aucun')
					{
						$id_id=$donnees['id_user'];
						$rep2=$bdd->query('SELECT pseudo FROM user WHERE id='.$id_id);
						$donnees2=$rep2->fetch();

						$rep_date=$bdd->query('SELECT DAY(date_envoi) AS jour, MONTH(date_envoi) AS mois, YEAR(date_envoi) AS annee, HOUR(date_envoi) AS heure, MINUTE(date_envoi) AS minute FROM contact WHERE id='.$id_sms);
						$date=$rep_date->fetch();
						// var_dump($date);

						?>
							<h1><?php echo $donnees2['pseudo'] ?></h1>
							<p class="sm"><?php echo "Sujet : ".$donnees['sujet'];?></p><!--sujet message-->
							<p class="lm"><?php echo $donnees['message'];?></p><!--message-->
							<p class="dm">Message envoyé le <?php echo $date['jour'].'/'.$date['mois'].'/'.$date['annee'].' à '.$date['heure'].' heures '.$date['minute']; ?></p>
						<?php
					}

					

					if($donnees['id_user']=='aucun')
					{
						$rep_date=$bdd->query('SELECT DAY(date_envoi) AS jour, MONTH(date_envoi) AS mois, YEAR(date_envoi) AS annee, HOUR(date_envoi) AS heure, MINUTE(date_envoi) AS minute FROM contact WHERE id='.$id_sms);
						$date=$rep_date->fetch();
						// var_dump($date);

						?>
							<h1><?php echo"Visiteur"?></h1>
							<p class="sm"><?php echo "Sujet : ".$donnees['sujet'];?></p><!--sujet message-->
							<p class="lm"><?php echo $donnees['message'];?></p><!--message-->
							<p class="dm">Message envoyé le <?php echo $date['jour'].'/'.$date['mois'].'/'.$date['annee'].' à '.$date['heure'].' heures '.$date['minute']; ?></p>

						<?php
					}
					

				}
			?>
			</div>

		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

