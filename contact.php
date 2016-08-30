<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<?php include('include_plugins.php'); ?>
<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css"> -->
<!-- 	<link rel="stylesheet" href="pnotify/font-awesome-4.6.3/css/font-awesome.min.css">
 -->
</head>
<body>
	<div id="wrapper">
		<!-- Header -->
		<header>
			<!--Include the page's head-->
			<?php include('PageHead.php');?>

			<!-- header image -->
			<img src="img/banners/contact.png" width="100%" height="100%" alt="">
		</header>

		<!--Navigation links-->
		<?php include('nav.php'); ?>

		<center>
		<section class="contact_section1">
			<h1>Nous Contacter</h1>
			<fieldset class="messagefield">
				<form method="post" action="contact.php">
					<p>	<input type="text" name="sujet" placeholder="Sujet" required="required"></p>
					<p>	<input type="email" name="mail" placeholder="Adresse Mail" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">		</p>
					<p>	<textarea name="message" cols="50%" rows="10" placeholder="Tapez votre message ici" required="required"></textarea>	</p>
					<p>	<input type="submit" value="Envoyer"></p>
				</form>
			</fieldset>
		</section>
		</center>
		<?php 
// var_dump('INSERT INTO contact(role,sujet,email,message,id_user,date_envoi,etat) VALUES (\'membre\',\'Salut\',\'ibson@gmail.com\',\'Salut. Franchment votre site est pratique\','47',NOW(),'1' )');die;
			//Connexion to DataBase
			// try
			// {
			// 	$bdd=new PDO('mysql:host=localhost;dbname=sunucampus','root','');
			// }
			// catch(PDOexeption $e)
			// {
			// 	die('Erreur'.$e->getmessage());
			// }

			if(isset($_POST['sujet']) && isset($_POST['mail']) && isset($_POST['message'])
			&& !empty($_POST['sujet']) && !empty($_POST['mail']) && !empty($_POST['message']))
			{
				if(isset($_SESSION['pseudo']) && $_SESSION['password'])
				{
					//If the person has already signed in, collect his id 
					$req=$bdd->prepare('SELECT id FROM user WHERE pseudo=:username');
					$req->execute(array('username' => $_SESSION['pseudo']));

					//
					$donnees=$req->fetch();

					//Add his message to the database
					$rep=$bdd->exec('INSERT INTO contact(role,sujet,email,message,id_user,date_envoi,etat) VALUES (\'membre\',\''.$_POST['sujet'].'\',\''.$_POST['mail'].'\',\''.$_POST['message'].'\',\''.$donnees['id'].'\',NOW(),\'1\' )');
					if($rep!=false)
					{
						echo '
							<script>
								swal({   
									 title: "Notification",   
									 text: "Votre message a été envoyé avec succès",   
									 timer: 2000,   
									 showConfirmButton: false 
								});						
							</script> ';	
					}
					else
					{
						echo '
							<script>
								swal({   
									 title: "Notification",   
									 text: "Une erreur s\'est produite. Votre message n\'a pas pu être envoyé. Veuillez réessayer",   
									 timer: 2000,   
									 showConfirmButton: false 
								});						
							</script> ';
					}
				}

				else
				{
					$req2=$bdd->exec('INSERT INTO contact(role,sujet,email,message,id_user,date_envoi,etat) VALUES (\'visiteur\',\''.$_POST['sujet'].'\',\''.$_POST['mail'].'\',\''.$_POST['message'].'\',\'aucun\',NOW(),\'1\' )');

					if($req2!=false)
					{
						echo '
							<script>
							swal({   
									 title: "Notification",   
									 text: "Votre message a été envoyé avec succès",   
									 timer: 2000,   
									 showConfirmButton: false 
								});
							</script>';	
					}
					else
					{
						echo '
							<script>
								swal({   
									 title: "Notification",   
									 text: "Une erreur s\'est produite. Votre message n\'a pas pu être envoyé. Veuillez réessayer",   
									 timer: 2000,   
									 showConfirmButton: false 
								});						
							</script> ';
					}
				}
			}
		?>
		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

