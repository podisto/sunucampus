<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> SunuCampus </title>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		
		<!-- Jquery Plugin -->
		<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>

		<link rel="stylesheet" href="custom_uploader/style.css">


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

		<div style="width: 100%;min-height: 600px; ">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="input-file-container">  
				    <input class="input-file" id="my-file" type="file" name="avatar">
				    <label tabindex="0" for="my-file" class="input-file-trigger">Select a file...</label>
				</div>
				<p class="file-return"></p>
				<input type="submit" value="Enregistrer">
			</form>
		</div>
	<!--Footer-->
	<?php include('footer.php'); ?>

	</div> <!--End of the wrapper-->
	<script src="custom_uploader/index.js"></script>
	</body>
</html>

<?php require_once 'db_connect.php';
	$uid=$_SESSION['uid'];
	if(isset($_FILES['avatar']) && !$_FILES['avatar']['error'])
	{
		if($_FILES['avatar']['size']<=3000000)
		{
			$infosficher		=pathinfo($_FILES['avatar']['name']);
			$extension_fichier	=$infosficher['extension'];
			$extension_autisees	=array('jpg','jpeg','png','gif');

			if (in_array($extension_fichier,$extension_autisees)) {
				move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/avatar/'.$uid.'.png/');
				$chemin=''.$uid.'.png';
			}
		}

		$rep=$bdd->prepare('UPDATE user SET avatar=:chemin WHERE id=:uid');
		$rep->execute(array('chemin'=> $chemin,'uid'=> $uid));
		header('location:profil.php');
	}
	// var_dump($uid);var_dump($chemin);var_dump($rep);  die;
	echo "<script>Une erreur est survenu lors du chargement de votre photo de profil.Veuillez réessayer plus tard</script>";
	// $_SESSION['flash']['success']='Votre compte a été créé avec succès !';
	
	
?>