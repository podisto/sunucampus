<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Espace Dossier</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
	<div id="wrapper">
		<!-- Header -->
		<header>
			<!--Include the page's head-->
			<?php include('PageHead.php');?>

			<!-- header image -->
			<img src="img/banners/depot_dossier.png" width="100%" height="100%" alt="">
		</header>

		<!--Navigation links-->
		<?php include('nav.php'); ?>

		<!--section-->
		<section>
			<center>
			<p class="form_dep_title">Formulaire de Création de dossier</p>
				<form method="post" action="dossier.php" enctype="multipart/form-data">
				<div id="form_dossier">

					<!--Champ Date de naissance-->
					<label for="birthdate">Date de naissance</label>
					<input type="date" name="birthdate" id="birthdate" required="required"></form> </br>

					<?php
						/*Connexion to database*/
						try 
						{
						 	$bdd= new PDO ('mysql:host=localhost;dbname=sunucampus','root','', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
						} 
						catch (PDOException $e) 
						{
						 	die('Erreur'.$e->getmessage());
						} 
					?>

					
					<!--Champs Ville de naissance-->
					<label for="pays">Pays d'origine</label>
					<select name="pays_id" id="pays" required="required">
					<?php 					
						/*Picking country list from data base*/
						$reponse=$bdd->query('SELECT id,nom_fr_fr from pays');
						while($donnees=$reponse->fetch())
						{
					?>
						<option value="<?php echo $donnees['id']; ?>"><!----><?php echo $donnees['nom_fr_fr'] ?><!---->
						</option>
					<?php
						}
						$reponse->closeCursor();
					?>
					</select>


					<!--Champ type de carte-->
					<label for="card_type">Type de carte</label>
						<select name="card_type" id="card_type" required="required">
							<option value="passport">Passport</option>
							<option value="id_card">Carte D'intentité</option>
						</select> </br>
					
					<!--Champ Numéro de carte-->
					<label for="card_number">Numéro de carte</label>
					<input type="number" name="card_number" id="card_number" required="required"> </br>

					<!--Champ Numéro de téléphone-->
					<label for="telephone">Numéro Téléphone</label>
					<input type="number" name="telephone" id="telephone" required="required"> </br>

					<!--Champ Filière-->
					--------------------------</br>
					<label>Choix de la filière</label></br>
						--------------------------
					</br>
						<!--CHOIX 1-->
						<label for="choix_1">1er choix</label>
						<select name="choix_1" id="choix_1" required="required">
						<?php
							$rep=$bdd->query('SELECT * FROM filiere');
							while($tableau=$rep->fetch())
							{
						?>
							<option value="<?php echo $tableau['id'] ?>"><?php echo $tableau['nom'];?></option>

						<?php 
							}
							$rep->closeCursor();
						?>
						</select> </br>

						<!--CHOIX 2-->
						<label for="choix_2">2ème choix</label>
						<select name="choix_2" id="choix_2" required="required">
						<?php
							$rep=$bdd->query('SELECT * FROM filiere');
							while($tableau=$rep->fetch())
							{
						?>
							<option value="<?php echo $tableau['id'] ?>"><?php echo $tableau['nom'];?></option>

						<?php 
							}
							$rep->closeCursor();
						?>
						</select> </br>

						<!--CHOIX 3-->
						<label for="choix_3">3ème choix</label>
						<select name="choix_3" id="choix_3" required="required">
						<?php
							$rep=$bdd->query('SELECT * FROM filiere');
							while($tableau=$rep->fetch())
							{
						?>
							<option value="<?php echo $tableau['id'] ?>"><?php echo $tableau['nom'];?></option>

						<?php 
							}
							$rep->closeCursor();
						?>
						</select> </br>

					<!--ANNEE DINTEGRATION-->
					<label for="annee_dintegration">En quelle année souhaitez vous intégrer l'université?</label>
					<select name="annee_dintegration" id="annee_dintegration" required="required">
						<option value="1">Première année</option>
						<option value="2">Deuxième année</option>
						<option value="3">Troisième année</option>
						<option value="4">Quatrième année</option>
						<option value="5">Cinquième année</option>
					</select>
					</br>

						<!--JUSTIFICATIFS-->
						<label>Justificatifs<br> (bulletins de note) </label>
						<input type="file" name="justif1">
						<input type="file" name="justif2">
						<input type="file" name="justif3">

						<input type="submit" value="Valider">

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
							
							/*var_dump($birthdate);
							var_dump($pays_id);
							var_dump($card_type);
							var_dump($card_number);
							var_dump($telephone);
							var_dump($choix_1);
							var_dump($choix_2);
							var_dump($choix_3);
							var_dump($annee_dintegration);die;*/

							$rep=$bdd->prepare('SELECT id FROM user WHERE pseudo=:username');
							$rep->execute(array('username' => $_SESSION['pseudo']));
							$donnees=$rep->fetch();
						/*	var_dump($donnees);die;*/

							///GESTION DES FICHIERS	
							if(isset($_FILES['justif1']) && !$_FILES['justif1']['error'])
							{
								if($_FILES['justif1']['size']<=3000000)
								{
									$infosficher		=pathinfo($_FILES['justif1']['name']);
									$extension_fichier	=$infosficher['extension'];
									$extension_autisees	=array('jpg','jpeg','png','gif');

									if (in_array($extension_fichier,$extension_autisees)) {
										move_uploaded_file($_FILES['justif1']['tmp_name'], 'img/uploads/'.$donnees['id'].'_01.png/');
										$chemin1=''.$donnees['id'].'_01.png';
									}
								}
							}

							if(isset($_FILES['justif2']) && !$_FILES['justif2']['error'])
							{
								if($_FILES['justif2']['size']<=3000000)
								{
									$infosficher		=pathinfo($_FILES['justif2']['name']);
									$extension_fichier	=$infosficher['extension'];
									$extension_autisees	=array('jpg','jpeg','png','gif');

									if (in_array($extension_fichier,$extension_autisees)) {
										move_uploaded_file($_FILES['justif2']['tmp_name'], 'img/uploads/'.$donnees['id'].'_02.png/');
										$chemin2=''.$donnees['id'].'_02.png';
									}
								}
							}

							if(isset($_FILES['justif3']) && !$_FILES['justif3']['error'])
							{
								if($_FILES['justif3']['size']<=3000000)
								{
									$infosficher		=pathinfo($_FILES['justif3']['name']);
									$extension_fichier	=$infosficher['extension'];
									$extension_autisees	=array('jpg','jpeg','png','gif');

									if (in_array($extension_fichier,$extension_autisees)) {
										move_uploaded_file($_FILES['justif3']['tmp_name'], 'img/uploads/'.$donnees['id'].'_03.png/');
										$chemin3=''.$donnees['id'].'_03.png';
									}
								}
							}


							$bdd->exec('INSERT INTO dossier(user_id,pays_id,birthdate,card_type,card_number,telephone,choix_1,choix_2,choix_3,annee_dintegration,chemin_justif1,chemin_justif2,chemin_justif3) VALUES (\''.$donnees['id'].'\',\''.$pays_id.'\',\''.$birthdate.'\',\''.$card_type.'\',\''.$card_number.'\',\''.$telephone.'\',\''.$choix_1.'\',\''.$choix_2.'\',\''.$choix_3.'\',\''.$annee_dintegration.'\',\''.$chemin1.'\',\''.$chemin2.'\',\''.$chemin3.'\')');

							echo ("<SCRIPT LANGUAGE='JavaScript'>
  									window.alert('Votre dossier a été créé avec succès')
								   	window.location.href='user_gestion_dossier.php';
								    </SCRIPT>");
						}	
					?>
				</div>
				</form>
			</center>
		</section>	

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

