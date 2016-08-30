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



		<!--Management bar-->
		<?php include('aside_management_bar.php'); ?>

		<div style="height:910px;">
		<div class="pagebody_gestion_site">

			<form method="post" action="" class="form_news">
		
		<?php 

			$rq=$bdd->query('SELECT * FROM presentation');
			$donnees=$rq->fetch();
		?>

					<h1>Titre</h1>
					<input type="text" name="presentation_title" value=" <?php echo $donnees['titre']; ?>" >


					<h1>Présentation</h1>
					<textarea class="ckeditor" name="presentation"> </textarea>
<!-- 
					<h1>Charger une image</h1>
					<input type="file" name="image"></br> -->

					</br>
					<input type="submit" value="Mettre à jour">
			</form>
		</div>
		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

<?php

	//Verifiying the informations
	if(	isset($_POST['presentation_titles']) && !empty($_POST['presentation_title'])
	&&	isset($_POST['presentation']) && !empty($_POST['presentation'])
	)
	{
		$presentation_title		=addslashes(strip_tags($_POST['presentation_title']));
		$description    		=$_POST['description'];

		$rep=$bdd->prepare('UPDATE presentation SET titre=:title AND description=:descript');
		$rep->execute(array('title' => $presentation_title, 'descript' => $description));
		if($req!=false)
			echo"<script>alert('SUCCES')</script>";
		else
			echo"<script>alert('FAILURE')</script>";

	}
?>