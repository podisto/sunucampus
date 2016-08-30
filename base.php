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

	<!-- Font awesome integration -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">


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
			<table style="width:100%; text-align: center; " id="customers">
				<tr>
					<th>id</th>
					<th>Nom</th>
					<th>Description</th>
					<th>Supprimer</th>
				</tr>
				<?php
					$rep=$bdd->query('SELECT * from filiere LIMIT 5');

					while($filieres=$rep->fetch())
					{
				?>
					<tr>
						<td><?php echo $filieres['id'];?></td>
						<td><?php echo $filieres['nom'];?></td>
						<td><?php echo $filieres['description'];?></td>
						<td><a href="gestion_filiere_delete.php?param=<?php echo $filieres['id']; ?>" style=" color:black;"><i class="fa fa-trash-o"></i></a></td>
					</tr>
				<?php
					}
				?>
			</table>
				<div style=" margin: 10px;font-size: 18px;text-align: center; "><a style=" text-decoration: none;font-style: italic;margin: 5px;color: teal; " href="gestion_filiere_liste.php" >Voir la liste complète </a></div>	

			<form method="post" action="base.php"> 
			<fieldset class="ajout_filiere">
				<h1>Ajouter une filère</h1>
<!-- 				<p style=" display: inline-block; ">
					Filiere <input type="checkbox" name="filiere">
					Catégorie News<input type="checkbox" name="news_category"> -->
				</p>
				<input type="text" name="nom" id="nom" placeholder="Nom de la filière" required="required">
				<textarea name="description" cols="50%" rows="5" placeholder="Description de la filière" required="required"></textarea>
				<input type="submit" value="Ajouter">
			</fieldset>
			</form>
		</div>

	<?php
		

		if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['description']) && !empty($_POST['description']))
		{
			$nom=addslashes(strip_tags($_POST['nom']));
			$description=addslashes(strip_tags($_POST['description']));

			// var_dump($nom);var_dump($description);die;

			$req=$bdd->exec('INSERT INTO filiere(nom,description) VALUES (\''.$nom.'\',\''.$description.'\') ');
			if($req!=false){
				$_SESSION['flash']['success']='La filière '.$nom.' a été crée avec succès !';
				header('location:base.php');
			}
			else{
				$_SESSION['flash']['failure']='L\'ajout de la filière '.$nom.' a échouée !';
				header('location:base.php');
			}

		}
?>
		<!--Footer-->
		<?php include('footer.php'); ?>

	</div>
</body>
</html>



