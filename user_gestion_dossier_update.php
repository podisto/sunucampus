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

		<?php
			/*Connexion to database*/
			include('db_connect.php');
						
			$pseudo=$_SESSION['pseudo'];

			$req=$bdd->query('SELECT dossier.pays_id pays_id1, user.nom nom1, user.prenom prenom1, user.mail mail1, pays.nom_fr_fr pays1, dossier.birthdate date_naissance1,dossier.card_type card_type1, dossier.card_number card_number1,dossier.telephone telephone1,dossier.annee_dintegration annee_dintegration1 FROM pays,user,dossier WHERE user.id=dossier.user_id AND pays.id=dossier.pays_id AND user.pseudo="'.$pseudo.'"');

			$info_dossier=$req->fetch();
			// var_dump($info_dossier);die;

			$req->closeCursor();
			// var_dump($info_dossier['pays_id1']);die;
		?>

		<!--section-->
		<section>
			<center>
			<p class="form_dep_title">Formulaire de Création de dossier</p>
				<form method="post" action="user_gestion_dossier.php" enctype="multipart/form-data">
				<div id="form_dossier">

					<!--Champ Date de naissance-->
					<label for="birthdate">Date de naissance</label>
					<input type="date" name="birthdate" id="birthdate" required="required" value="<?php echo $info_dossier['date_naissance1']?>"></form> </br>
					
					<!--Champs Ville de naissance-->
					<label for="pays">Pays d'origine</label>
					<select name="pays_id" id="pays" required="required" value="2">
					<?php 					
						/*Picking country list from data base*/
						$reponse=$bdd->query('SELECT id,nom_fr_fr from pays');
						while($donnees=$reponse->fetch())
						{
							if($donnees['id']!=$info_dossier['pays_id1'])
							{
					?>
								<option value="<?php echo $donnees['id']; ?>"><!----><?php echo $donnees['nom_fr_fr'] ?><!---->
								</option>
					<?php
							}
							else
								echo "<option selected=\"selected\" value=".$info_dossier['pays_id1'].">".$donnees['nom_fr_fr']."</option>";
						}
						$reponse->closeCursor();
					?>
					</select>


					<!--Champ type de carte-->
					<label for="card_type">Type de carte</label>
						<select name="card_type" id="card_type" required="required">
						<?php
							if($donnees['card_type']!=$info_dossier['card_type1'])
							{
						?>
							<option value="passport">Passport</option>
							<option value="id_card">Carte D'intentité</option>
						<?php
							}
							else
								echo "<option selected=\"selected\" value=".$info_dossier['card_type1'].">".$info_dossier['card_type1']."</option>";
						?>
						</select> </br>
					
					<!--Champ Numéro de carte-->
					<label for="card_number">Numéro de carte</label>
					<input type="number" name="card_number" id="card_number" required="required" value="<?php echo $info_dossier['card_number1']; ?>"> </br>

					<!--Champ Numéro de téléphone-->
					<label for="telephone">Numéro Téléphone</label>
					<input type="number" name="telephone" id="telephone" required="required" value="<?php echo $info_dossier['telephone1']; ?>"> </br>

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
<!-- 						<label>Justificatifs<br> (bulletins de note) </label>
						<input type="file" name="justif1">
						<input type="file" name="justif2">
						<input type="file" name="justif3">

	 -->					<input type="submit" value="Valider">

				</div>
				</form>
			</center>
		</section>	

		<!--Footer-->
		<?php include('footer.php'); ?>
	</div>
</body>
</html>

