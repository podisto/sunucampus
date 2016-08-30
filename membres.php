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
	<script type="text/javascript" src="ckeditor/ckeditor.js" ></script>
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

	<!-- Sweet Alert Plugin -->
	<script src="sweetalert/dist/sweetalert.min.js"></script> 
	<link rel="stylesheet" type="text/css" href="sweetalert/dist/sweetalert.css">
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
			//CONNEXION TO DB
			include('db_connect.php'); 

			//NON READ MESSAGES COUNTING
			$req=$bdd->query(	'SELECT COUNT(*) as nbMsg FROM contact WHERE etat=1');
			$donnees=$req->fetch();
			$req->closeCursor();
		?>

		<!--Management bar-->
		<?php include('aside_management_bar.php'); ?>

		<div class="pagebody_gestion_membres">
		<?php
			$req = $bdd -> query ('SELECT * FROM user WHERE password!=\'banni\' ');

			echo 
			"<table id=\"customers\">
				<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Mail</th>
				<th>Pseudo</th>
				<th>Role</th>
				<th>Date d'inscription</th>
				<th style= \"width:5px;\">Bannir</th>
			</tr>";

			while($donnees=$req->fetch())
			{
		?>
			<tr>
				<td><?php echo $donnees['nom']; ?></td>
				<td><?php echo $donnees['prenom']; ?></td>
				<td><?php echo $donnees['mail']; ?></td>
				<td><?php echo $donnees['pseudo']; ?></td>
				<td><?php echo $donnees['role']; ?></td>
				<td><?php echo $donnees['date_inscription']; ?></td>
				<td style="text-align: center; "><a href="gestion_site_dossier_action.php?param4=<?php echo $donnees['id']; ?>">X</a></td>
			</tr>
		<?php
			}
			echo "</table>";
		?>

		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

<?php

if( isset($_GET['param4']) && !empty($_GET['param4']) && ($_GET['param4']==2 OR $_GET['param4']==1) )
	{	
		if($_GET['param4']==1)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "Vous avez banni cet utilisateur avec succès!",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}

		else if($_GET['param4']==2)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "Le banissement a échoué. Veuillez réessayer",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}
	} 