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

		<div class="pagebody_gestion_site">

			<section id="site_news">
				<h1>Infos & Nouveautés</h1>
				<a href="gestion_site_news.php"><img src="img/logo_site_news.png"></a>
				<!--<textarea class="ckeditor" name="editor"></textarea>-->
			</section>

<!-- 			<section id="site_presentation">
				<h1>Présentation du site</h1>
				<a href="gestion_site_presentation.php"><img src="img/logo_site_presentation.png"></a>
			</section> -->
		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>