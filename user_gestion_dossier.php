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

			$pseudo=$_SESSION['pseudo'];

			$req=$bdd->query('SELECT user.nom nom, user.prenom prenom, user.mail mail, pays.nom_fr_fr pays, dossier.birthdate date_naissance,dossier.card_type card_type, dossier.card_number card_number,dossier.telephone telephone,dossier.annee_dintegration annee_dintegration FROM pays,user,dossier WHERE user.id=dossier.user_id AND pays.id=dossier.pays_id AND user.pseudo="'.$pseudo.'"');

			$info_dossier=$req->fetch();
			// var_dump($info_dossier);die;

			$req->closeCursor();
		
		?>

		<!--Body-->
		<div class="pagebody_user_gestion_dossier">
			<div class="user_dossier_view">
				<h1>Mon dossier</h1>
				<table>
					<tr>
						<td class="strong">Nom :</td>
						<td><?php echo $info_dossier['nom']?></td>
						<td class="strong">Prénom :</td>
						<td><?php echo $info_dossier['prenom']?></td>
					</tr>
					<tr>
						<td class="strong">Date de naissance :</td>
						<td ><?php echo $info_dossier['date_naissance']?></td>
						<td class="strong">Pays d'origine :</td>
						<td><?php echo $info_dossier['pays']?></td>
					</tr>
					<tr>
						<td class="strong">Type de piece :</td>
						<td><?php echo $info_dossier['card_type']?></td>
						<td class="strong">Numéro de piece :</td>
						<td><?php echo $info_dossier['card_number']?></td>
					</tr>					
					<tr>
						<td class="strong">Téléphone :</td>
						<td><?php echo $info_dossier['telephone']?></td>
						<td class="strong">Adresse Mail :</td>
						<td><?php echo $info_dossier['mail']?></td>
					</tr>
					<tr>
						<td class="strong">Choix 1 :</td>
						<td>
							<?php
								$req=$bdd->query('SELECT filiere.nom filiere FROM filiere,dossier WHERE filiere.id=dossier.choix_1');

								$choix1=$req->fetch();

								echo $choix1['filiere'];

								$req->closeCursor();
							?>
						</td>
						<td class="strong">Choix 2 :</td>
						<td>
							<?php
								$req=$bdd->query('SELECT filiere.nom filiere FROM filiere,dossier WHERE filiere.id=dossier.choix_2');

								$choix2=$req->fetch();

								echo $choix2['filiere'];

								$req->closeCursor();
							?>
						</td>
					</tr>
					<tr>
						<td class="strong">Choix 3 :</td>
						<td>
							<?php
								$req=$bdd->query('SELECT filiere.nom filiere FROM filiere,dossier,user WHERE filiere.id=dossier.choix_3 AND user.pseudo="'.$pseudo.'" ');

								$choix3=$req->fetch();

								echo $choix1['filiere'];

								$req->closeCursor();
							?>						
						</td>
						<td class="strong">Année d'intégration :</td>
						<td>
							<?php
								$annee=$info_dossier['annee_dintegration'];
								if($annee==1)
									echo $annee."<sup>ère</sup> année";
								else
									echo $annee."<sup>ème</sup> année";
							?>
						</td>
					</tr>
				</table>

				<div style="text-align: center; font-size: 1.5em; font-style: italic; padding: 10px; ">
					<?php 
						$rep=$bdd->query('SELECT dossier.validation validation FROM dossier,user WHERE dossier.user_id=user.id AND user.pseudo="'.$pseudo.'" ');

						$etat=$rep->fetch();
						// echo $etat['validation'];
						$req->closeCursor();

						if($etat['validation']==0){
							echo $pseudo.", votre Dossier n'a pas encore été validé";
						echo "<p>En cas de problème n'hésitez pas à nous contacter";
						}
						else if($etat['validation']==1){
							echo $pseudo.", votre dossier a été validé";
						}						
						else if($etat['validation']==2){
							echo $pseudo.", votre dossier a été rejeté";
						}
					?>
				</div>

				<?php
					if($etat['validation']!=1)
					{
				?>
				<div style="border:solid 3px black;background-color:gray;width:100px;border-radius:5px;padding:10px;float:right;margin-right:10%;	">
					<a href="user_gestion_dossier_update.php" style="text-decoration:none;color:white;font-size:1.2em;font-style:italic;"> Modifier</a>
				</div>
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

					<!--ECRITURE DANS LA BASE DE DONNEES-->
					<?php
						if(isset($_POST['birthdate'])  			&& !empty($_POST['birthdate'])
						&& isset($_POST['pays_id'])  			&& !empty($_POST['pays_id'])
						&& isset($_POST['card_type']) 			&& !empty($_POST['card_type'])
						&& isset($_POST['card_number']) 		&& !empty($_POST['card_number'])
						&& isset($_POST['telephone'])  			&& !empty($_POST['telephone'])
						&& isset($_POST['choix_1']) 			&& !empty($_POST['choix_1'])
						&& isset($_POST['choix_2']) 			&& !empty($_POST['choix_2'])
						&& isset($_POST['choix_3']) 			&& !empty($_POST['choix_3']
						&& isset($_POST['annee_dintegration']) 	&& !empty($_POST['annee_dintegration']))
						  )//Fermeture du if
							//DEBUT DES CONDITIONS
						{ 
							//SECURISATION DES INFORMATIONS
							$birthdate 			=$_POST['birthdate'];
							$pays_id			=$_POST['pays_id'];
							$card_type			=$_POST['card_type'];
							$card_number		=addslashes(strip_tags($_POST['card_number']));
							$telephone			=addslashes(strip_tags($_POST['telephone']));	
							$choix_1			=$_POST['choix_1'];
							$choix_2			=$_POST['choix_2'];
							$choix_3			=$_POST['choix_3'];
							$annee_dintegration	=$_POST['annee_dintegration'];

							// echo $birthdate; echo $telephone; echo $card_number;

							$rep=$bdd->prepare('SELECT id FROM user WHERE pseudo=:username');
							$rep->execute(array('username' => $_SESSION['pseudo']));
							$donnees=$rep->fetch();

							$userid=$donnees['id'];

					// echo $telephone." "; echo $userid;



					$rep=$bdd->prepare(' UPDATE dossier SET 
						telephone = 	:phonenumber,
						pays_id=		:nv_pays_id,
						birthdate=		:nv_birthate ,
						card_type=		:nv_card_type,
						card_number=	:nv_card_number WHERE user_id = :userid ');

					$t=array(
						'phonenumber' => $telephone,
						'userid' => $userid,
						'nv_pays_id' => $pays_id,
						'nv_birthate' => $birthdate,
						'nv_card_type' => $card_type,
						'nv_card_number' =>$card_number );

					 $resultat=$rep->execute($t);
					 // var_dump($resultat);die;

					if($resultat!=false)
					{
						echo '
							<script>
								swal({   
									 title: "Notification",   
									 text: "Votre dossier a été mis à jour avec succès !",   
									 timer: 2000,   
									 showConfirmButton: false 
								});						
							</script> ';
					}
					else
					{
						echo '
							<script>
								swal({   
									 title: "Notification",   
									 text: "La mise à jour de votre dossier a échouée. Veuillez réessayer plus tard !",   
									 timer: 2000,   
									 showConfirmButton: false 
								});						
							</script> ';
					}

/*
					$rep=$bdd->prepare('UPDATE dossier SET 
						pays_id=		:nv_pays_id,
						birthdate=		:nv_birthate ,
						card_type=		:nv_card_type,
						card_number=	:nv_card_number,
						telephone=		:nv_telephone WHERE user_id = "'.$userid.'" ');

					$rep->execute(array(
						'nv_pays_id' => $pays_id,
						'nv_birthate' => $birthdate,
						'nv_card_type' => $card_type,
						'nv_card_number' =>$card_number,
						'nv_telephone' => $telephone
						));

					*/

					// echo $birthdate; echo $telephone; echo $card_number; echo $username; echo $card_type;echo $pays_id;
					// var_dump($rep);die;
					

						}	
					?>