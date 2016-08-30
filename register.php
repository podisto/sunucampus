<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
 	<link rel="stylesheet" href="/resources/demos/style.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  	<script src="js/jquery-3.1.0.min.js"></script>
<!-- 
  	<link rel="stylesheet" type="text/css" href="styles/file_uploader.css">
  	<script type="text/javascript" src="js/file_uploader.js"></script> -->

  	<script type="text/javascript" src="pnotify/pnotify.custom.min.js"></script>
	<link href="pnotify/pnotify.custom.min.css" media="all" rel="stylesheet" type="text/css" />

  	<script>
		  $( function() {
		    $( "#dialog" ).dialog();
		  } );
  </script>

</head>
<body>
	<div id="wrapper">
		<!-- Header -->
		<header>
			<!--Include the page's head-->
			<?php include('PageHead.php');?>

			<!-- header image -->
			<img src="img/banners/inscription.png" width="100%" height="100%" alt="">
		</header>

		<!--Navigation links-->
		<?php include('nav.php'); ?>

		<section>
		<center>
		<!--Main title-->
		<h1>Formulaire d'inscription</h1>

		<!--Formular-->
		<fieldset class="registerfield">
		<form method="post" action="Register.php" enctype="multipart/form-data">
			<!--Fields-->
			<input type="text" name="nom" placeholder="Nom" required="required">
			
			<input type="text" name="prenom" placeholder="Prénom" required="required"></br>

			<input type="email" name="mail" placeholder="E-mail" required="required">

			<input type="text" name="pseudo" placeholder="Pseudo" required="required"></br>

			<input type="password" name="password" placeholder="Mot de passe" required="required">
			<input type="password" name="password_confirm" placeholder="Confimer mot de passe" required="required" ></br>

			<input type="file" name="avatar"></br>
<!-- 
			<div class="input-file-container">
			  <input class="input-file" id="my-file" type="file" name="avatar">
			  <label for="my-file" class="input-file-trigger" tabindex="0">Select a file...</label>
			</div>
			<p class="file-return"></p>
 -->
			<input type="submit" value="Valider">


		</form>
		</fieldset>
		<?php
			//Check if the $_POST array has received the variables
			if(
				isset($_POST['nom']) 		&& !empty($_POST['nom'])
			 && isset($_POST['prenom']) 	&& !empty($_POST['prenom'])
			 && isset($_POST['mail']) 		&& !empty($_POST['mail']) 
			 && isset($_POST['pseudo']) 	&& !empty($_POST['pseudo'])
			 && isset($_POST['password']) 	&& !empty($_POST['password'])
			 && isset($_POST['password_confirm']) 	&& !empty($_POST['password_confirm']) )
			{
				//Connection to database
				try
				{
					$bdd=new PDO ('mysql:host=localhost;dbname=sunucampus','root','');
				}
				catch(PDOexeption $e)
				{
					die('Erreur'.$e->getmessage());
				}

				$nom=		addslashes(strip_tags($_POST['nom']));
				$prenom=	addslashes(strip_tags($_POST['prenom']));
				$mail=		strip_tags($_POST['mail']);
				$pseudo=	addslashes(strip_tags($_POST['pseudo']));
				$password=	sha1($_POST['password']);

				$req=$bdd->prepare('SELECT pseudo from user WHERE pseudo=:username');
				$req->execute(array('username' => $pseudo));

				$req2=$bdd->prepare('SELECT mail from user WHERE mail=:email');
				$req2->execute(array('email' => $mail));

				if($donnees=$req->fetch())
					echo "<script>alert('Ce Pseudo éxiste déjà. Veuillez en choisir un autre');</script>";

				else if($donnees2=$req2->fetch())
					echo "<script>alert('Cette adresse mail est déjà utilisée. Veuillez en choisir une autre');</script>";

				else if($_POST['password']!=$_POST['password_confirm']){
					echo "<script>alert('Vous devez entrer les mêmes mot de passe');</script>";
				}

				else
				{

					 $req=$bdd->exec('INSERT INTO user(nom,prenom,mail,pseudo,password,role,date_inscription) VALUES (\''.$nom.'\',\''.$prenom.'\',\''.$mail.'\',\''.$pseudo.'\',\''.$password.'\',\'etudiant\' , NOW()) ');
					 if($req!=false)
					{

					$uid=$bdd->LastInsertId();

					if(isset($_FILES['avatar']) && !$_FILES['avatar']['error'])
						{
							if($_FILES['avatar']['size']<=3000000)
							{
								$infosficher		=pathinfo($_FILES['avatar']['name']);
								$extension_fichier	=$infosficher['extension'];
								$extension_autisees	=array('jpg','jpeg','png','gif');

								if (in_array($extension_fichier,$extension_autisees)) { var_dump('3 ok');
									move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/avatar/'.$uid.'.png/');
									$chemin=''.$uid.'.png';
								}
							}

							$rep=$bdd->prepare('UPDATE user SET avatar=:chemin WHERE id=:uid');
							$rep->execute(array('chemin'=> $chemin,'uid'=> $uid));
						}
						// var_dump($uid);var_dump($chemin);var_dump($rep);  die;
						echo "<script>Une erreur est survenu lors du chargement de votre photo de profil.Veuillez réessayer plus tard</script>";
						$_SESSION['flash']['success']='Votre compte a été créé avec succès !';
						header('location:loginPage.php');
					}
					

					else
						echo '<div id="dialog" title="Erreur">
								<p>Une erreur sest produite durant votre inscription. Veuillez réessayer</p>
							</div>';
					/*	{
						 echo "<script>
									alert('Une erreur sest produite durant votre inscription. Veuillez réessayer');
									window.location = 'Register.php';
							</script>";
						}*/


					

					//header('location:register_ok.php');
				}
			}
		?>
		</center>
		</section>

	<!--Footer-->
	<?php include('footer.php'); ?>

	</div><!--End of the wrapper-->
</body>
</html>