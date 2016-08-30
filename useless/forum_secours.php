<?php session_start(); ?>

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

		if(empty($errors)){
			$pseudo=$_SESSION['pseudo'];
			$requete=$bdd->prepare('SELECT id FROM user WHERE pseudo=:pseudo');
			$requete->execute(array('pseudo' => $pseudo));
			$donnees=$requete->fetch();

			$req=$bdd->prepare('INSERT INTO for_content SET title=:titre, content=:contenu,publi_date=NOW(), id_user = :iduser');
			$req->execute(array('titre' => $_POST['titre'] , 'contenu' => $_POST['contenu'], 'iduser' => $donnees['id'] ));
			if($req){
				echo "Article posté avec succès";
				header('location:forum.php');
			}
			else{
				echo "Echec lors de la publication";
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
  			<li><img src="img/forum/slide1.png"/></li>
 			<li><img src="img/forum/slide2.png" /></li>
 			<li><img src="img/forum/slide3.png" /></li>
 			<li><img src="img/forum/slide4.png" /></li>
		</ul>

	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>

	<div style="height: auto;min-height: 600px; ">
		<form method="post" action="">
			Titre du post</br>
			<input type="titre" name="titre"></br>
			contenu</br>
			<input type="contenu" name="contenu"></br>
			<input type="submit" value="Poster">
		</form>

	<div>
		<?php 
			$req=$bdd->query('SELECT id,title,content,DAY(publi_date) AS jour, MONTH(publi_date) AS mois, YEAR(publi_date) AS annee, HOUR(publi_date) AS heure,MINUTE(publi_date) AS minute FROM for_content ORDER BY publi_date DESC');

			while($article=$req->fetch()){
		?>	
		<a style="text-decoration: none;color: black; " href="forum_read.php?id=<?php echo $article['id']; ;?> " >
			<p style="border:solid 3px black;width: 300px;margin: 20px;padding: 5px;border-radius: 5px;background-color: white; " >
				Titre :<?php echo $article['title']; ?></br>
			<?php echo "publié le".$article['jour']."/".$article['mois']."/".$article['annee']." à ".$article['heure']." heures ".$article['minute'] ;?>

			</p>
		</a>
		<?php
			}
		?>
	</div>


	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

</body>
</html> 

<?php if($article['show_mail']) echo "Contact : ".$infos_user['mail']; ?>

						<div style="width: 30%;border: 3px solid white;height: 200px; ">
						sdfdfdf
					</div>
					<div style="width: 69%;border: 3px solid white;position: absolute;top: 0;right: 0; ">
						<h1 style="text-align: center;margin: 0px;font-size: 25px; "><?php echo $article['title']; ?></h1>
						<p style="text-align: justify; "><?php echo $article['content'];?></p>
						<p style="text-align: left; "> <?php echo "publié le ".$article['jour']."/".$article['mois']."/".$article['annee']." à ".$article['heure']." heures ".$article['minute']." par ".$infos_user['pseudo'] ;?> </p>
					</div>


					Titre :<?php echo $article['title']; ?></br>
					Contenu : <?php echo $article['content']; ?></br>
					<?php echo "publié le ".$article['jour']."/".$article['mois']."/".$article['annee']." à ".$article['heure']." heures ".$article['minute'] ;?>
				<?
					echo "<p>";
				if($commentaires['id_user']!=0)
					echo "Commentaire de ".$commentaires['pseudo']."</br>";
				else
					echo "Commentaire du visiteur : ".$commentaires['pseudo']."</br>";

				echo $commentaires['message'];
				echo "</p>";

?>
							<!--Edit Topic-->
								<a href="forum_edit_topic.php?id=<?php echo $id;?> "><img src="img/forum/edit3.png" style="width: 25px;position: absolute;right: 40px;top: 5px;"></a>

								<!--Delete Topic-->
								<a href="forum_delete_topic_confirm.php?id=<?php echo $id; ?>"><img src="img/forum/trash2.png" style="width: 25px;position: absolute;right: 10px;top: 5px;"></a>

								<!--Solved tag : Check if the topic has been solved or not-->
								<?php if($article['solved']!=1):?>
									<a href="forum_topic_solved.php?id=<?php echo $id; ?>"><img src="img/forum/solved.png" style="width: 25px;position: absolute;right: 70px;top: 5px;"></a>
								<?php endif;?>