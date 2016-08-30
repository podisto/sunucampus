<?php session_start(); ?>

<?php 
	// require_once('db_connect.php');
	// if(!empty($_POST)){
	// 	$errors=array();

	// 	if(empty($_POST['titre']) || !isset($_POST['titre'])){
	// 		$errors['titre']='Veuillez rentrer un titre valable';
	// 	}

	// 	if(empty($_POST['contenu']) || !isset($_POST['contenu'])){
	// 		$errors['contenu']='Veuillez rentrer un contenu valable';
	// 	}

	// 	if(empty($errors)){
	// 		$pseudo=$_SESSION['pseudo'];
	// 		$requete=$bdd->prepare('SELECT id FROM user WHERE pseudo=:pseudo');
	// 		$requete->execute(array('pseudo' => $pseudo));
	// 		$donnees=$requete->fetch();

	// 		$req=$bdd->prepare('INSERT INTO for_content SET title=:titre, content=:contenu,publi_date=NOW(), id_user = :iduser');
	// 		$req->execute(array('titre' => $_POST['titre'] , 'contenu' => $_POST['contenu'], 'iduser' => $donnees['id'] ));
	// 		if($req){
	// 			echo "Article posté avec succès";
	// 			header('location:forum.php');
	// 		}
	// 		else{
	// 			echo "Echec lors de la publication";
	// 		}
	// 	}
	// }

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
	<!-- main container -->
	<div style="height: auto;min-height: 800px;background-color: rgba(0,0,0,0.8);padding-top: 30px;text-align: center; ">
		<!-- box container -->
		<div style="width: 700px;height: 700px;margin: auto;border-radius: 5px;padding: 20px;background-color: rgba(255,255,255,0.1);box-shadow: 0 0 10px white; ">
			<!-- top box  -->
			<div style="width: 100%;height: 400px;margin-bottom: 20px; ">
				<img src="img/forum/computer.png" style="width: 200px; ">
				<p style="font-size: 40px;margin: 0;padding: 0;color: white;font-style: italic;margin-top: 20px;  ">Forum</p>
				<p style="color: white;font-size: 25px;margin: 10px 0 0 0;padding: 0; ">Bienvenue dans le forum du site, dans cette partie vous pourrez interagir avec les autres membres via différents topics. Pour continuer veuillez choisir une action</p>
			</div>
			<!-- Options box -->
			<div style="height: 200px;width: 500px;margin: auto;text-align: center;position: relative; ">
				<div style="height: 280px;width: 45%;position: absolute;left: 0; border-radius: 5px;">
					<!-- <div style="height: 100%;width: 100%; "> -->
						<img src="img/forum/edit.png" style="height: 200px; ">
						<a href="forum_creer.php"><button class="forum_options">Créer Topic</button></a>
					<!-- </div> -->
				</div>
				<div style="height: 280px;width: 45%;position: absolute;right: 0;border-radius: 5px; ">
					<img src="img/forum/read.png" style="height: 200px; ">
					<a href="forum_topics.php?id=0"><button class="forum_options">Voir Topics</button></a>
				</div>
			<style type="text/css">
				.forum_options{
					height: 50px;
					width: 180px;
					background-color: rgba(0,0,0,0);
					border: 2px solid white;
					border-radius: 5px;
					font-size: 20px;
					color: white;
					margin: auto;
					margin-top: 10px;
					cursor: pointer;
					transition: 0.5s all;
					-webkit-transition: 0.5s all;
					-moz-transition: 0.5s all;
				}

				.forum_options:hover{
					background-color: white;
					color: black;
				}
			</style>
			</div>
		<!-- 	<div style="height: auto;width: 700px;margin: auto;text-align: center;position: relative;border: white solid 3px; ">
				<button class="forum_options">Créer Topic</button>
				<button class="forum_options">Voir Topics</button>
			</div> -->
		</div>

	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

</body>
</html> 