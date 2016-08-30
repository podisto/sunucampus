<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page D'accueil</title>
	<?php include('include_plugins.php'); ?>
</head>
<body>
<div id="wrapper">
	<!-- Header -->
	<header>
		<!--Include the page's head-->
		<?php include('PageHead.php');?>

		<!-- header image -->
		<img src="img/banners/accueil.png" width="100%" height="100%" alt="">
	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>
	<!--Main page-->
	<div id="main">
		<!--First Section-->
		<section class="section_1">
		<?php 
			include('db_connect.php'); 
			$req=$bdd->query('SELECT * FROM news ORDER BY date_news DESC');
			while($tableau_news=$req->fetch())
			{
				$preview=substr($tableau_news['news_text'], 0,150).'...';
		?>

		<a href="news_lecture.php?param=<?php echo $tableau_news['id']; ?>">
		<article>
			<h1><?php echo $tableau_news['title'];?></h1>
			<div style=" ">
				<div style="background:url('img/news/<?php echo $tableau_news['file_name'] ;?>');height: 200px;background-size : 100% auto;background-position:50%; ">
					<div style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%; ">
						<p><?php echo strip_tags($preview);?></p>
						<button id="next_next" style="position: absolute;right: 10px;bottom: 10px;height: 30px;width: 100px;background-color: rgba(0,0,0,0);color: white;outline: none;border: 3px solid white;cursor: pointer; ">Lire la suite</button>
					</div>
				</div>
			</div>
		</article>		
		</a>

		<?php
			}
			$req->closeCursor();
		?>
		</section>

	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>
</body>
</html>