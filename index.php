<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page D'accueil</title>
	<?php include('include_plugins.php'); ?>
	<?php include('db_connect.php');?>

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

		<!--Images loading-->

		<ul class="bxslider">
  			<li><img src="img/slide1.png"/></li>
 			<li><img src="img/slide2.png" /></li>
 			<li><img src="img/slide3.png" /></li>
		</ul>

	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>
	<!--Main page-->
	<div id="main">
		<!--First Section-->
		<section class="index_body">

			<!--Video-->
<!--
			<div id="Video">
				<h1 style="font-size:20px;">Video présentation</h1>
				<video src="video/spot.mp4" controls width="400"></video>
			</div>
			</div> -->

		<!-- Aside bloc -->
		<div style=" height: auto;width: 25%;float:right;margin-right: 0px;padding: 0px; ">
			<?php
			if(!empty($_SESSION['pseudo']) && !empty($_SESSION['password']) && isset($_SESSION['pseudo']) && isset($_SESSION['password']))
			{
				require_once('db_connect.php');
				$rep=$bdd->prepare('SELECT * FROM user WHERE pseudo=:username');
				$rep->execute(array('username' => $_SESSION['pseudo']));
				$donnees=$rep->fetch();
			?>
			<!-- Logged User Informations -->
			<div style=" background-color:rgba(0,128,128,0.4);width: 93%;margin: 20px  auto 20px auto;padding-top: 5px;border-radius: 5px;padding-bottom: 10px;clear: both;position: relative;box-shadow: 0 0 20px black  ">
				<!--Profile image-->
			<!--	<div style="width:200px;height:200px;overflow:hidden">-->
					<a href="profil.php">
						<img id="shadow_on_hover" src="img/<?php if($donnees['avatar']!=0 && !empty($donnees['avatar'])) echo "avatar/".$donnees['avatar'];else echo "default_profile.png"; ?>" style=" display: block;border-radius: 50%;width: 90px;margin: 10px auto 0px auto; ">
					</a>
					<style>
						#shadow_on_hover:hover{
						box-shadow: 0 0 10px black;
						}
					</style>
				<!--</div>-->
				<div style=" text-align: center; ">
					<p style="font-size: 25px;margin-top: 5px;margin-bottom: 0px;border: 3px solid teal;width: 80%;border-radius: 5px;background-color: rgba(255,255,255,0.6);margin-right: auto;margin-left: auto;padding: 5px;color: teal; "><?php echo $donnees['pseudo']; ?></p>
					<p style="font-size: 22px;margin-top:10px; "><?php echo $donnees['role']; ?></p>
					<a href="profil.php"><img src="img/settings.png" style="width:30px; float:right;position:absolute;bottom: 5px;right: 5px;  "></a>
				</div>
			</div>
			<?php
			}
			?>
			<div style=" width: 90%;background-color:rgba(0,128,128,0.8); ;padding: 5px;color: white; margin: auto;margin-top: 10px;text-align: justify;clear: both;margin-bottom: 10px; ">
				<img src="img/directeur.png" style=" width: 90px;margin: auto;box-shadow: 5px 5px 100px teal;float: left; "></br>
				<strong style=" margin-left: 70px;display: block;padding-top: 0px;font-size: 20px;text-align: center; ">Mot du </br>directeur</strong>
				<span style="clear: both;">
				<p style=" clear: both;padding: 5px;margin-top: 5px; ">
					Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino.
				</p>
			</div>
			<div style=" height: auto;background-color:rgba(0,128,128,0.8);width: 93%;margin: auto;  ">
				<h1 style=" display: block;border: 1px solid black;text-align: center;padding-top:10px;padding-bottom: 10px;background-color: teal;color: white; ">Nos Filières</h1>
				<ul style=" color: white;font-size: 18px; ">
					<?php require_once('db_connect.php');
						$list=$bdd->query('SELECT nom FROM filiere ORDER BY nombre_deleves DESC LIMIT 6');
						while($filieres=$list->fetch()){
					?>
						<li><?php echo $filieres['nom']; ;?></li>
					<?php
					}
					?>
				</ul>
				<a href="#" id="view_all">Voir la liste complète</a>
				<!-- Link personalization -->
				<style type="text/css">
					#view_all{
					display:block;
					text-decoration: none;
					color: white;
					text-align: center;
					font-style:italic;
					border: 1px solid black;
					padding-top:5px;
					padding-bottom: 5px;
					border-radius: 3px;
					}
					#view_all:hover{
						color: black;
						background-color: rgba(0,128,128,0.1);
					}
				</style>
			</div>
			<!--
			<div style=" height: 300px;background-color:rgba(0,128,128,0.8);width: 93%;margin: 20px  auto 20px auto;text-align: center;  ">

			</div>
			 -->
		</div><!-- Bloc Aside -->
		<?php
			$req=$bdd->query('SELECT * FROM news WHERE featured=1');
			$donnees_news=$req->fetch();
		?>
		<div style=" float:right;width: 70%;margin-right: 20px;margin-top:20px;">
			<div style=" width: 100%;height: 400px;border: 3px solid teal ;border-radius: 5px;margin-bottom: 20px;position: relative;background: url('img/news/<?php echo $donnees_news['file_name']; ?>');background-size: cover;opacity: 0.8; ">
			<div style="position: absolute;top: 0;left: 0;width: 100px;height: 25px;background-color: rgba(255,0,0,0.8);color: white;border-radius: 3px 0px 3px 0px;padding-top: 5px;padding-left: 5px;padding-right: 1px;border-right: 3px solid teal;border-bottom: 3px solid teal;font-weight: bold; ">A LA UNE</div>
			<div style=" width: 100%;margin-top: 0px;background-color: rgba(0,0,0,0.5);text-align: justify;position: absolute;bottom:70px; ">
				<h1 style="font-size: 50px;color: white;padding: 0px; margin: 0px; "><?php echo $donnees_news['title']; ?></h1>
				<p style=" font-size: 30px;color: white;padding-bottom: 20px; margin: 0; "><?php echo substr(strip_tags($donnees_news['news_text']), 0,150)."..."; ?></p>
			</div>
				<a href="news_lecture.php?param=<?php echo $donnees_news['id'];?>"><button style="position: absolute;right: 20px;bottom: 20px;width: 150px;height: 40px;background-color: rgba(0,0,0,0.8);border: 3px solid white;color: white;font-size: 15px;cursor: pointer;">Lire la suite</button></a>
			</div>

			<div style=" width: 100%;height: 400px;border-radius: 5px;margin-bottom: 20px;position: relative;overflow: hidden; ">
				<ul class="bxslider">
					<li><img src="img/filieres/1.jpg" style="width:100%;height: 400px; "></li>
					<li><img src="img/filieres/2.jpg" style="width:100%;"></li>
				</ul>
			</div>
		</div>
		</section>

		<div style=" width: 100%;height: 300px;clear: both; ">
			<a href="forum.php" style=" text-decoration: none;color: white;font-weight: bold; ">
			<div style="width: 100%;height: 100%;background:url('img/forum.jpg') no-repeat;background-size: 100%;background-position: 50%; " >
				<p style=" text-align: center;line-height: 300px;font-size: 100px;text-shadow: 0 0 30px black; ">Forum</p>
			</div></a>

		</div>

	</div>
	<!--Footer-->
	<?php include('footer.php'); ?>
</div>
</body>
</html>
