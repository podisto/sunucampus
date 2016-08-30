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

<?php 
	require_once('inc/functions.php');
	$erros=array();
/*
	if(!isset($_POST['news_title']))
		$errors['titre_news']='Ce titre n\'est pas défini';

	if(empty($_POST['news_title']))
		$errors['titre_news2']="Le champ titre est vide";

	if( !isset($_POST['news_text']) )
		$erros['news_text']="Champs non défini";

	if(empty($_POST['news_text']))
		$erros['news_text2']="Champ vide";

	if(!isset($_POST['description']))
		$erros['description']="Champ non défini";

	if(empty($_POST['description']))
		$erros['description2']="Champ vide";

	if(!isset($_POST['categorie_id']))
		$erros['categorie_id']="Champ non défini";

	if(empty($_POST['categorie_id']))
		$erros['categorie_id2']="Champ vide";*/

		if(isset($_FILES['image']) && !$_FILES['image']['error'])
		{
			$errors['chargement']="L'image a bien été chargée";
			if($_FILES['image']['size']<=5000000)
			{
				$erros['taille']="Limage respecte la bonne taille";
				$infosficher		=pathinfo($_FILES['image']['name']);
				$extension_fichier	=$infosficher['extension'];
				$extension_autisees	=array('jpg','jpeg','png');

				if (in_array($extension_fichier,$extension_autisees)) {
					$erros['extension']="Lextension convient";
				}
				else
				$erros['extension']="L'extension du fichier ne convient pas";
			}
			else
				$erros['taille']="limage ne respecte pas la bonne taille";
		}
		else
		$erros['chargement']="L'image n'a pas encore été chargée";
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

		<!--<div style="display: block;position: absolute;margin-left: 250px;top:200px;width: 54%;background-color: red;color: white;padding: 5px;  ">-->
			<?php //debug($erros);?>
			<?php //debug($_FILES);?>
		<!--</div>-->

		<div class="pagebody_gestion_site">

			<form method="post" action="" class="form_news" enctype="multipart/form-data">

					<h1>Titre</h1>
					<input type="text" name="news_title" required>

					<h1>Contenu</h1>
					<textarea class="ckeditor" name="news_text" id="news_text" required></textarea >

					<h1>Description</h1>
					<textarea name="description" cols="50%" rows="5" required> </textarea></br>

					<h1>Catégorie</h1>
					<select name="categorie_id">
					<?php 
						$rep=$bdd->query('SELECT * FROM news_categories');
						while($donnees=$rep->fetch())
						{
					?>
						<option value="<?php echo $donnees['id'];?> "><!----><?php echo $donnees['categorie']; ?><!----></option>
					<?php 
						}
					$rep->closeCursor();
					?>
					</select></br>

					<h1>Charger une image</h1>
					<input type="file" name="image"></br>

					<div style="display:inline-block;width: 200px;margin-left: 250px;position: relative;margin-top: 8px;margin-bottom: 8px; ">
						<input type="checkbox" name="une" value="oui" style="width: 20px;padding: 0px;margin: 0px; "><div style="position: absolute;top: 6px;left: 30px; ">Mettre à la une</div>
					</div>

					</br>
					<input type="submit" value="Poster">
			</form>
		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

<?php
	//Verifiying the informations
	if(	isset($_POST['news_title']) && !empty($_POST['news_title'])
	&&	isset($_POST['news_text']) && !empty($_POST['news_text'])
	&&	isset($_POST['description']) && !empty($_POST['description'])
	&&	isset($_POST['categorie_id']) && !empty($_POST['categorie_id'])
	)
	{
		// echo "<script>alert('NIKEL');</script>";die;
		$news_title		=addslashes(strip_tags($_POST['news_title']));
		$description    =addslashes(strip_tags($_POST['description']));
		$news_text		=$_POST['news_text'];
		$categorie_id	=$_POST['categorie_id'];

		//IF HE HAS CHOOSEN THE FEATURED CATEGORY
		if(!empty($_POST['une'])){
			if($_POST['une']=='oui')
				$une=1;
			else
				$une=0;

			$action=$bdd->exec('UPDATE news SET featured=0');

			$resultat=$bdd->exec('INSERT INTO news(title,description,news_text,categorie_id,date_news,featured) VALUES (\''.$news_title.'\',\''.$description.'\',\''.$news_text.'\',\''.$categorie_id.'\',NOW(),\''.$une.'\' ) ');

			//IF HE DIDNT CHOOSE THE FEATURED CATEGORY
			}else{
			$resultat=$bdd->exec('INSERT INTO news(title,description,news_text,categorie_id,date_news) VALUES (\''.$news_title.'\',\''.$description.'\',\''.$news_text.'\',\''.$categorie_id.'\',NOW() ) ');
		}

		$news_id=$bdd->LastInsertId();
		///GESTION DES FICHIERS	
		if(isset($_FILES['image']) && !$_FILES['image']['error'])
		{
			if($_FILES['image']['size']<=5000000)
			{
				$infosficher		=pathinfo($_FILES['image']['name']);
				$extension_fichier	=$infosficher['extension'];
				$extension_autisees	=array('jpg','jpeg','png');

				if (in_array($extension_fichier,$extension_autisees)) {
					move_uploaded_file($_FILES['image']['tmp_name'], 'img/news/'.$news_id.'.png/');
					$chemin1=''.$news_id.'.png';
				}
			}
		}

		$reponse=$bdd->prepare('UPDATE news SET file_name=:filepath WHERE id=:id_news');
		$reponse->execute(array('filepath' => $chemin1, 'id_news' => $news_id));
			 
		if($resultat){
			$_SESSION['flash']['success']='Votre news est maintenant en ligne !';
			header('location:gestion_site_news.php');
		}
		else{
			$_SESSION['flash']['success']='La publication de votre news a échouée !';
			header('location:gestion_site_news.php');
		}

	}else{
		echo "<script>alert('Une erreur s\'est produite. Il semble que le format normal n\'a pas été respecté. Revoyez votre formulaire')</script>";
	}
?>