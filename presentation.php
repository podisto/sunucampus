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
		<img src="img/banners/presentation.png" width="100%" height="100%" alt="">
	</header>

	<!--Navigation links-->
	<?php include('nav.php'); 
		include('db_connect.php');
		$req=$bdd->query('SELECT * FROM presentation');
		$donnees=$req->fetch();

	?>
	<!--Main page-->
	<div id="main" style=" text-align: center;height: auto;min-height: 600px;" class="animated bounceIn">
		<!-- <div style=" height: auto;padding: 10px;background-color: teal;border-radius: 5px; "> -->
			<h1 style=" font-style:italic;color:white;font-size: 3em;margin: 30px auto 0px auto;padding:10px;background-color: rgba(0,128,128,0.5);width: 90%;border-radius: 15px; "><?php echo $donnees['titre']; ?></h1>
			<img src="img/slide3.png" style=" width:80%;border-radius: 0px 0px 30px 30px;box-shadow: 10px 10px 20px silver; ">
			<p style=" text-align: justify;width: 60%;margin: -5px auto 100px auto;font-style: italic;font-size: 20px;background-color: rgba(0,128,128,0.5);padding:30px;border-radius: 0px 0px 15px 15px;box-shadow: 10px 10px 20px silver;color: white; "><?php echo $donnees['presentation']; ?></p>		</div>

		<!-- </div> -->

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>
</body>
</html>