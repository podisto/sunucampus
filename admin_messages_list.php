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
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
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
			try
			{
				$bdd=new PDO ('mysql:host=localhost;dbname=sunucampus','root','');
			}
			catch(PDOexeption $e)
			{
				die('Erreur'.$e->getmessage());
			}

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

		<!--General View-->
		<section class="section_messages_admin_list">
			<?php 

				$rep=$bdd->query('SELECT user.nom AS user_nom, user.prenom AS user_prenom,contact.id AS id_sms, contact.sujet AS envoyeur_sujet, contact.message AS envoyeur_message,contact.role AS envoyeur_role, contact.date_envoi AS envoyeur_message_date FROM user,contact WHERE contact.id_user=user.id AND contact.etat=1 ORDER BY envoyeur_message_date DESC');

				$rep2=$bdd->query('SELECT * FROM contact WHERE role="visiteur " AND etat=1 ORDER BY date_envoi DESC ');
	
				echo "<table id='customers'> 
						<tr>
							<th style=\"white-space: nowrap;\">Nom & Prénom</th>
							<th>Sujet</th>
							<th>Message</th>
							<th></th>
							<th></th>
						</tr>";

				while( $donnees = $rep -> fetch())
				{	
			?>
							
							<tr>
								<td><?php echo $donnees["user_prenom"]; echo " ".$donnees["user_nom"]; ?></td>
								<td><?php echo $donnees["envoyeur_sujet"]; ?></td>
								<td class="list_messages"><?php echo mb_strimwidth($donnees["envoyeur_message"], 0,30,"..."); ?></td>
								<td><a href="deleting_message2.php?param=<?php echo $donnees['id_sms']; ?> "><i class="fa fa-archive "></i></a></td>
								<td><a href="admin_messages_list_lecture.php?param=<?php echo $donnees['id_sms']; ?>"><i class="fa fa-commenting-o " title="Lire la suite"></i></a></td>
							</tr>

							
			<?php
				}


				/*Messages Envoyés par les visiteur*/				
				while ($donnees = $rep2 -> fetch()) 
				{
			?>
					<tr>
						<td>Visiteur</td>
						<td><?php echo $donnees["sujet"]; ?></td>
						<td class="list_messages"><?php echo mb_strimwidth($donnees["message"], 0,30,"..."); ?></td>
						<td><a href="deleting_message2.php?param=<?php echo $donnees['id']; ?> "><i class="fa fa-archive "></i></a></td>
						<td><a href="admin_messages_list_lecture.php?param=<?php echo $donnees['id']; ?>"><i class="fa fa-commenting-o " title="Lire la suite"></i></a></td>
					</tr>	
						
			<?php
				}
				echo "</table>";
			?>

		</section>
		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

<?php
/*if( isset($_GET['param']) && !empty($_GET['param']) && ($_GET['param']==2 OR $_GET['param']==1) )
	{	
		if($_GET['param']==1)
		{
			echo "
			<script type='text/javascript'>
				$(function(){
					 new PNotify({
						title: 'Notification',
						text: 'Le message a été archivé avec succès !',
		    			icon: 'fa fa-commenting-o',
		    			type: 'success'
								});
				});
			</script> ";
		}

		else if($_GET['param']==2)
		{
			echo "
			<script type='text/javascript'>
				$(function(){

					 new PNotify({
						title: 'Notification',
						text: 'L\'archivage du message a échoué',
		    			icon: 'fa fa-commenting-o',
		    			type: 'error'
								});
				});
			</script> ";
		}
	} */
?>