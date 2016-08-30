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
		?>		

		<div style=" height: auto;min-height: 600px; " >

			<div id="lecture_news" class="animated pulse" style=" margin-bottom:50px;  ">
			<?php
				// $id=addslashes(strip_tags($_GET['param']));

				if( isset($_GET['param']) && !empty($_GET['param']) && preg_match('#([0-9]+)#',$_GET['param']) && is_numeric($_GET['param']) )
				{	
					$id_news=$_GET['param'];
					$rep=$bdd->query('SELECT * FROM news WHERE id='.$id_news);

					$resultat=$donnees=$rep->fetch();
					if($resultat)
					{

					$rep_date=$bdd->query('SELECT DAY(date_news) AS jour, MONTH(date_news) AS mois, YEAR(date_news) AS annee, HOUR(date_news) AS heure, MINUTE(date_news) AS minute FROM news WHERE id='.$id_news);
					$date=$rep_date->fetch();

					$rep2=$bdd->query('SELECT categorie FROM news_categories WHERE id='.$donnees['categorie_id']);
					$donnees2=$rep2->fetch();

						?>
							<h1><?php echo $donnees['title'] ?></h1>
							<p class="sm"><?php echo "Catégorie : ".$donnees2['categorie'];?></p><!--sujet message-->
							<p class="lm2"><?php echo $donnees['news_text'];?></p>
							<p class="dm">Publiée le <?php echo $date['jour'].'/'.$date['mois'].'/'.$date['annee'].' à '.$date['heure'].' heures '.$date['minute']; ?></p>

						<?php
					}
					else
						echo "Cette news n'existe pas";

				}
			?>
			</div>

		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

