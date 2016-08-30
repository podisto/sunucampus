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

		<div class="pagebody_gestion_site_filiere">
			<table style="width:100%; text-align: center; " id="customers">
				<tr>
					<th>id</th>
					<th>Nom</th>
					<th>Description</th>
					<th>Supprimer</th>
				</tr>
				<?php
					$rep=$bdd->query('SELECT * from filiere');

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
		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>

	</div>
</body>
</html>



