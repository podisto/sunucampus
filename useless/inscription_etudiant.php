<?php mb_internal_encoding('UTF-8') ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> SunuCampus </title>
		<link rel="stylesheet" type="text/css" href="register_style.css">
	</head>
	<body>
		<div id="wrapper">
		<h1> Inscription </h1>
		<p> Veuillez compléter le formulaire suivant</p>
		
		<form action="inscription_etudiant.php" method="post">
		
		<tr> <td> <h2> <u> Identité </u> </h2> </td> </tr>
		
		<table>
			<tr>
				<td>  Nom  </td> 
				<td> * <input type="text" name="nom" required> </input> </td> 
				
				<td>  Prénom </td>
				<td> * <input type="text" name="prenom" required> </input> </td> 
			</tr>
			<tr>
				<td>  Date de naissance </td>
				<td> * <input type="date" name="date_naissance" required> </input> </td>
				
				<td>  Pays d'origine </td>
				<td> * <input type="text" name="pays" required> </input> </td> 
				<td><input type="text" name="pays"></input></td>

			</tr>
			<tr>
				<td> Type de Piece </td>
					<td> *
					<select name="id_type" >
						<option value="passport"> Passport </option>
						<option value="id_card"> Carte d'intentité </option>
						<option value="student_card"> Carte d'étudiant </option>
					</select>
					 </td>
				<td>  Numéro de piece </td>
				<td>* <input type="text" name="id_number" required> </input> </td>
			</tr>
			<tr>
				<td> Sexe </td>
				<td> *<select name="sexe">
					<option value=""> </option>
					<option value="masculin"> Masculin </option>
					<option value="feminin"> Féminin </option>
					</select>
				</td>
			</tr>
		
		
			<tr> <td> <h2> <u> Contact </u> </h2> </td> </tr>
		
			<tr>
				<td> Adresse </td>
				<td> *<input type="texte" name="adresse"> </input> </td>
				
				<td> Ville </td>
				<td> *<input type="text" name="ville"> </input> </td>
			</tr>
			<tr>
				<td> Email </td>
				<td>* <input type="email" name="email" required> </input> </td>
				
				<td> Téléphone </td>
				<td>*<input type="number" name="telephone" required> </input> </td> 
			</tr>
		
		<tr> <td> <h2> <u> Identification </u> </h2> </td> </tr>
		
			<tr>
				<td> Pseudo </td>
				<td> * <input type="text" name="pseudo" required> </input> </td>
				<td> Mot de passe </td>
				<td> * <input type="password" name="password" required> </input> </td>
			</tr>
		</table>
		
		<p> (*) Champs <em> obligatoires </em> </p>
			
		<p> <input type="submit" value="Valider"> </input> </p>
		</form>

		<?php
			if( isset($_POST['pseudo']) && isset($_POST['password']) )
			{
				try
				{
				$bdd = new PDO ('mysql:host=localhost;dbname=sunucampus','root','');
				
				}
				catch(PDOExeption $e)
				{
				die ('Erreur'. $e->getMessage());
				}
			
				$nom			=$_POST['nom'];
				$prenom			=$_POST['prenom'];
				$birthday		=$_POST['date_naissance'];
				$pays_dorigine	=$_POST['pays'];
				$id_type		=$_POST['id_type'];
				$id_number		=$_POST['id_number'];
				$adresse		=$_POST['adresse'];
				$ville			=$_POST['ville'];
				$email			=$_POST['email'];
				$telephone		=$_POST['telephone'];
				$pseudo			=$_POST['pseudo'];
				$password		=$_POST['password'];
				$sexe			=$_POST['sexe'];
			
				$req=$bdd->prepare('SELECT pseudo FROM user_info WHERE pseudo= :username');
				$req->execute(array('username' => $pseudo));
			
				if($donnees=$req->fetch())
					echo 'Ce pseudo <em>existe déjà</em>. Veuillez en choisir <em> un autre </em>';
				else
				{
					$bdd->exec('INSERT INTO user_info(nom,prenom,birthday,pays_dorigine,id_type,id_number,adresse,ville,email,telephone,pseudo,password,sexe,role)
								VALUES(\''.$nom.' \',\''.$prenom.' \',\''.$birthday.' \',\''.$pays_dorigine.' \',\''.$id_type.' \',\''.$id_number.'\',\''.$adresse.' \',
								\''.$ville.' \',\''.$email.' \',\''.$telephone.'\',\''.$pseudo.' \',\''.$password.' \',\''.$sexe.' \',\'etudiant\') ');
					header('location:inscription_etudiant_succes.php');
				}
			}
		?>
	</div>
	</body>
</html>