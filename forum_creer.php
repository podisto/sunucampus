<?php session_start(); ?>

	<?php
		if( !isset($_SESSION['role']) && !isset($_SESSION['password']) && !isset($_SESSION['pseudo']) &&
		   	 empty($_SESSION['role']) && empty($_SESSION['password']) && empty($_SESSION['pseudo']) )
				{
					header("location:loginPage.php");
				}
	?>

<?php 
	require_once('db_connect.php');
	if(!empty($_POST)){
		$errors=array();

		if(empty($_POST['titre']) || !isset($_POST['titre'])){
			$errors['titre']='Veuillez rentrer un titre valable';
		}

		if(empty($_POST['contenu']) || !isset($_POST['contenu'])){
			$errors['contenu']='Veuillez rentrer un contenu valable';
		}

		if(!empty($_POST['show_mail']) && $_POST['show_mail']=='yes'){
			$show_mail=1;
		}else{
			$show_mail=0;
		}

		if(empty($errors)){
			$pseudo=$_SESSION['pseudo'];
			$requete=$bdd->prepare('SELECT id FROM user WHERE pseudo=:pseudo');
			$requete->execute(array('pseudo' => $pseudo));
			$donnees=$requete->fetch();

			$req=$bdd->prepare('INSERT INTO for_content SET title=:titre, content=:contenu,publi_date=NOW(), id_user = :iduser , show_mail=:show');
			$req->execute(array('titre' => $_POST['titre'] , 'contenu' => $_POST['contenu'], 'iduser' => $donnees['id'], 'show' => $show_mail ));
			if($req){
				$_SESSION['flash']['success']="Votre topic a été publié avec succès";
				header('location:forum_topics.php?id=0');
				exit();
			}
			else{
				$_SESSION['flash']['failure']="La publication de votre topic a echouée";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page D'accueil</title>
	<?php include('include_plugins.php'); ?>

	<!--JQuery Slider Plugin-->
		<!-- jQuery library (served from Google) -->
		<script src="js/jquery.min.js"></script>
		<!-- bxSlider Javascript file -->
		<script src="js/slider/jquery.bxslider.min.js"></script>
		<!-- bxSlider CSS file -->
		<link href="js/slider/jquery.bxslider.css" rel="stylesheet" />

		<!--Call of the script-->
		<script type="text/javascript">
            $(document).ready(function(){
            	$('.bxslider').bxSlider({
            		auto: true,
            		pager: false
            	});
            });
      	</script>
</head>
<body>
<div id="wrapper">
	<!-- Header -->
	<header>
		<!--Include the page's head-->
		<?php include('PageHead.php');?>

		<!-- header image -->
		<!-- <img src="img/banners/accueil.png" width="100%" height="100%" alt=""> -->

		<ul class="bxslider">
  			<!-- <li><img src="img/forum/slide1.png"/></li> -->
 			<li><img src="img/forum/slide2.png" /></li>
 			<li><img src="img/forum/slide3.png" /></li>
 			<li><img src="img/forum/slide4.png" /></li>
		</ul>

	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>
	<style type="text/css">
		input[type="text"]{
			width: 240px;
			height: 35px;
			border-radius: 3px;
			color: white;
			background-color: rgba(255,255,255,0.1);
			border: 1px rgba(255,255,255,0.5) solid;
			margin: 10px;
			-webkit-transition: 0.5s;
			-moz-transition: 0.5s;
			transition: 0.5s;
			text-align: center;
		}

		textarea{
			width: 240px;
			height: auto;
			min-height: 150px;
			border-radius: 3px;
			color: white;
			background-color: rgba(255,255,255,0.1);
			border: 1px rgba(255,255,255,0.5) solid;
			margin: 10px;
			-webkit-transition: 0.5s;
			-moz-transition: 0.5s;
			transition: 0.5s;
			text-align: center;
		}

		input[type="submit"]{
			width: 240px;
			height: 35px;
			border: 2px solid white;
			background-color: rgba(0,0,0,0);
			border-radius: 3px;
			color: white;
			font-size: 15px;
			letter-spacing: 1px;
		}

		input[type="submit"]:hover{
			background-color: white;
			color: black;
			cursor: pointer;
		}

		input[type="text"]:focus,textarea:focus{
			/*width: 280px;*/
			background-color: white;
			color: black;
			/*text-align: center;*/
			font-size: 15px;
			border: 1px rgba(255,255,255,0.5) solid;
			outline: none;
			box-shadow: 0 0 5px white;
		}

		::-webkit-input-placeholder{
			font-size: 15px;
		}

		input[type="checkbox"]{
			width: 20px;
			height: 20px;
			border-radius: 5px;
		}
	</style>

	<div style="height: auto;min-height: 700px;background-color: rgba(0,0,0,0.8); ">
		<div style="width: 500px;height:auto;min-height: 600px;margin: auto;text-align: center;">
			<img src="img/forum/marker.png" style="height: 150px;margin-top: 30px; ">
			<p style="color: white;font-size: 20px; ">Ne laissez plus vos questions en suspend ! Posez les directement sur le forum et attendez que les autres utilisateurs vous répondent</p>
			<div style="width: 70%;margin: auto;padding-top: 20px;padding-bottom: 20px;margin-top: 20px;background-color: rgba(0,0,0,0.1);border-radius: 5px;box-shadow: 0 0 5px white;  ">
				<form method="post" action="">
					<input type="text" name="titre" placeholder="Titre de votre Topic" required></br>
					<textarea name="contenu" placeholder="Ecrivez votre topic ici" required=></textarea></br>
					<div style="font-size: 16px;margin: -4px auto 10px auto;color: white; "><input type="checkbox" name="show_mail" checked="checked" value="yes">Afficher mon adresse mail</br></div>
					<input type="submit" value="Poster">
				</form>
			</div>
		</div>
	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

</body>
</html> 