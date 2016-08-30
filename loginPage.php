<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> SunuCampus </title>
		<link rel="stylesheet" type="text/css" href="styles/style.css">

		<!-- Jquery Plugin -->
		<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>

		<script type="text/javascript">
			if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
			    $(window).load(function(){
			        $('input:-webkit-autofill').each(function(){
			            var text = $(this).val();
			            var name = $(this).attr('name');
			            $(this).after(this.outerHTML).remove();
			            $('input[name=' + name + ']').val(text);
			        });
			    });
			}
		</script>

	</head>
	<body>
	<div id="wrapper">
		<!-- Header -->
		<header>
			<!--Include the page's head-->
			<?php include('PageHead.php');?>

			<!-- header image -->
			<img src="img/banners/connexion.png" width="100%" height="100%" alt="">
		</header>

		<!--Navigation links-->
		<?php include('nav.php'); ?>

		<!--Section-->
		<section>
			<center>
			<p> Veuillez vous connecter avant d'accéder au site
			</p>

			<!--PHP section-->
			<?php

				try
				{
				$bdd= new PDO ('mysql:host=localhost;dbname=sunucampus','sunucampus','sunucampus@2016');
				}
				catch(PDOExeption $e)
				{
				die ('Erreur'. $e->getMessage());
				}

			if( isset($_POST['pseudo']) && isset($_POST['password']) )
			{

			$req=$bdd->prepare('SELECT * FROM user WHERE pseudo = :username AND password=:pass');
			$req->execute(array('username' => $_POST['pseudo'], 'pass' => sha1($_POST['password']) ) );

			if($donnees=$req->fetch())
			{
				$_SESSION['pseudo']=$_POST['pseudo'];
				$_SESSION['password']=$_POST['password'];
				$_SESSION['role']=$donnees['role'];
				$_SESSION['email']=$donnees['mail'];
				$_SESSION['uid']=$donnees['id'];
				$_SESSION['flash']['success']='Bienvenue '.$_SESSION['pseudo'].' !';
				header('location:index.php');
			}
			else
				echo '<em class="wrong_informations">Pseudo ou mot de passe incorrect</em>';
			}
		?>
			<fieldset class="loginfield" >
			<form action="LoginPage.php" method="post" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
			<input type="text" name="pseudo" required placeholder="Pseudo"> </input></br>
			<input type="password" name="password" required placeholder="Mot de passe"> </input></br>
			<input type="submit" value="Se Connecter"> </input>
			</form>
			</fieldset style="width:270px">

			<p> Vous n'êtes pas encore inscrit? Cliquez <a href="register.php" title="inscription"> ici </a> </p>
	</center>
	</section>

	<!--Footer-->
	<?php include('footer.php'); ?>

	</div> <!--End of the wrapper-->
	</body>
</html>
