<?php session_start(); ?>

<?php 
	include('db_connect.php');

	if( isset($_GET['param1']) && !empty($_GET['param1']))
	{	
		$id_dossier=addslashes(strip_tags($_GET['param1']));
		$req=$bdd->prepare('UPDATE dossier SET validation=1 WHERE id=:id_user');
		$req->execute(array('id_user'=> $id_dossier ));
		if($req!=false){
			// var_dump($id);die;
			$instruc=$bdd->query('SELECT choix_1 AS id_filiere FROM dossier WHERE id='.$id_dossier);

			if($dfiliere=$instruc->fetch()){
				$filiere_id=$dfiliere["id_filiere"];

				$compt=$bdd->query('SELECT nombre_deleves FROM filiere WHERE id='.$filiere_id);
				
				$comptage=$compt->fetch();

				$nv_nombre=$comptage['nombre_deleves']+1;

				$resultat=$bdd->exec('UPDATE filiere SET nombre_deleves="'.$nv_nombre.'" WHERE id="'.$filiere_id.'"  ');

				if($resultat!=false){
					$_SESSION['flash']['success']='Le dossier a été validé avec succès !';
					header('location:gestion_site_dossier.php#ancre_nav');		
				}
				else{
					$_SESSION['flash']['failure']='La mise à jour du nombre d\'inscrits dans cette filière a échouée !';
					header('location:index.php');
				}


			}

			
		}
		else{
			$_SESSION['flash']['failure']='La validation du dossier a échouée !';
			header('location:gestion_site_dossier.php#ancre_nav') ;
		}

	}

	if( isset($_GET['param2']) && !empty($_GET['param2']))
	{	
		$id=addslashes(strip_tags($_GET['param2']));
		$req=$bdd->prepare('UPDATE dossier SET validation=2 WHERE id=:id_message');
		$req->execute(array('id_message'=> $id ));
		if($req!=false){
			$_SESSION['flash']['success']='L\'indexation s\'est effectuée avec succès';
			header('location:gestion_site_dossier.php#ancre_nav');
		}
		else{
			$_SESSION['flash']['failure']= 'L\'indexation a échouée. Le doissier est toujours en attente !';
			header('location:gestion_site_dossier.php#ancre_nav') ;
		}
	}

	if( isset($_GET['param3']) && !empty($_GET['param3']))
	{	
		$id=addslashes(strip_tags($_GET['param3']));
		$req=$bdd->prepare('DELETE FROM dossier WHERE id=:id_message');
		$req->execute(array('id_message'=> $id ));
		if($req!=false){
			$_SESSION['flash']['success']='Le dossier a bien été supprimé !';
			header('location:gestion_site_dossier.php?param3=1#ancre_nav');
		}
		else{
			$_SESSION['flash']['success']='La suppression du dossier a échouée !';
			header('location:gestion_site_dossier.php?param3=2#ancre_nav') ;
		}
	}	

	if( isset($_GET['param4']) && !empty($_GET['param4']))
	{
		$id=addslashes(strip_tags($_GET['param4']));
		$req=$bdd->prepare('UPDATE user SET password=\'banni\' WHERE id=:userid');
		$req->execute(array('userid' => $id));
		if($req!=false)
		{
			// echo "ok";die();
			header('location:membres.php?param4=1#ancre_nav');
		}
		else
			header('location:membres.php?param4=2#ancre_nav') ;
	}

	echo "Une erreur s'est produite. Veuillez réessayer";
?>

