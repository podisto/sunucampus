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

	<!-- Font awesome integration -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
	
	<!-- Sweet Alert Plugin -->
	<script src="sweetalert/dist/sweetalert.min.js"></script> 
	<link rel="stylesheet" type="text/css" href="sweetalert/dist/sweetalert.css">

	<!-- Jquery Plugin -->
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
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

		<!--Body-->
		<div class="pagebody_gestion_site">
			<form method="post" action="">
			<table>
				<tr>
					<th>Numéro Dossier</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Date de naissance</th>
					<th>Pays d'origine</th>
					<th>Choix 1</th>
					<th>Année d'intégration</th>
					<th>Action</th>
				</tr>

				<?php 
					$req=$bdd->query('SELECT dossier.id AS id_dossier, dossier.annee_dintegration AS AD ,dossier.birthdate AS date_naissance , dossier.id AS dossier_id , dossier.validation AS validation, user.nom AS nom, user.prenom AS prenom , pays.nom_fr_fr AS pays ,filiere.nom AS filiere  FROM user, dossier, pays,filiere WHERE dossier.user_id=user.id AND pays.id=dossier.pays_id AND filiere.id=dossier.choix_1');




					while($donnees=$req->fetch())
					{
				?>
				<tr>
					<td><?php echo $donnees['dossier_id']; ?></td>
					<td><?php echo $donnees['nom']; ?></td>
					<td><?php echo $donnees['prenom']; ?></td>
					<td><?php echo $donnees['date_naissance']; ?></td>
					<td><?php echo $donnees['pays']; ?></td>
					<td><?php echo $donnees['filiere']; ?></td>
					<td><?php echo $donnees['AD']; ?></td>

					<td style=" white-space: nowrap;text-align:center;">
					<?php
						if($donnees['validation']!=1 && $donnees['validation']!=2)
						{
					?>
						<a href="gestion_site_dossier_action.php?param1=<?php echo $donnees['dossier_id']; ?>" style=" color:black;" ><i class="fa fa-check"></i></a>

						<a href="gestion_site_dossier_action.php?param2=<?php echo $donnees['dossier_id']; ?>" style=" color:black;"><i class="fa fa-times"></i></a>

						<a href="gestion_site_dossier_action.php?param3=<?php echo $donnees['dossier_id']; ?>" style=" color:black;"><i class="fa fa-trash-o"></i></a>
					<?php
						}

						else if($donnees['validation']==1)
							echo "Dossier validé";
						else
							echo "Dossier non validé";
					?>

					</td>

				</tr>

				<?php 
					}
				?>
				
			</table>
				<input type="submit" value="Enregistrer">
			</form>
		</div>

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>

<!-- <script type='text/javascript'>
	$('.delete').click(function () {
		// var id = $(this).data('id');
		
	swal({   title: "Etes de sur de vouloir supprimer ce fichier?",
	text: "Vous ne pourrez pas recupérer ce fichier une fois supprimé!",
	      type: "warning",
	         showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	               confirmButtonText: "Oui, supprimer!",
	                  cancelButtonText: "Non, annuler",
	                     closeOnConfirm: false,
	                        closeOnCancel: false },
	                         function(isConfirm){
	                           		 if (isConfirm) {
	                           		 				 
	                                   				 }
	                                     else {
	                                          swal("Annulé", "", "error");
	                                      		} 
	                                      	});
})	
</script> -->

</body>
</html>


		<?php
			if(!empty($_POST['etat_validation']) ) {

				$num=($_POST['etat_validation']);

			    foreach($num as $check) 
			    {
			        if ( (preg_match('#([0-9]+)#',$check)) && is_numeric($check) )
			        {
			        	$bdd->exec('UPDATE dossier SET validation=1 WHERE id='.$check);
			        }
			        /*
			        else if($check!='10_OFF')
			        {
			        	// var_dump($num);die;
			        	// var_dump($check);die;
			        	$check2=preg_replace('/\D/', '', $check);
			        	$bdd->exec('UPDATE dossier SET validation=0 WHERE id='.$check2);
			        }*/

			    }

			 header('location:gestion_site_dossier.php');
			}
		?>

<?php
if( isset($_GET['param1']) && !empty($_GET['param1']) && ($_GET['param1']==2 OR $_GET['param1']==1) )
	{	
		if($_GET['param1']==1)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "Dossier validé avec succès!",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}

		else if($_GET['param1']==2)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "La validation du dossier a échouée",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}
	} 

if( isset($_GET['param2']) && !empty($_GET['param2']) && ($_GET['param2']==2 OR $_GET['param2']==1) )
	{	
		if($_GET['param2']==1)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "Le dossier a été indexé \"non validé\" avec succès!",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}

		else if($_GET['param2']==2)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "L\'indexation a échouée. Veuillez réessayer",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}
	} 

if( isset($_GET['param3']) && !empty($_GET['param3']) && ($_GET['param3']==2 OR $_GET['param3']==1) )
	{	
		if($_GET['param3']==1)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "Le dossier a été supprimé avec succès!",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}

		else if($_GET['param3']==2)
		{
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",   
				text: "La supresion a échouée. Veuillez réessayer",   
				timer: 2000,   
				showConfirmButton: false });
			</script> ';
		}
	} 
?>
