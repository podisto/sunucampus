<?php session_start(); ?>

	<?php
		if( !isset($_SESSION['role']) && !isset($_SESSION['password']) && !isset($_SESSION['pseudo']) &&
		   	 empty($_SESSION['role']) && empty($_SESSION['password']) && empty($_SESSION['pseudo']) )
				{
					header("location:loginPage.php");
				}
	?>

<?php
	require_once('db_connect.php');

	if(!empty($_GET)){
		$id_topic=(int)(strip_tags($_GET['id']));
	}

	// Verify if the persone who wanna edit the post is the one who posted it
	$verification=$bdd->prepare('SELECT id_user FROM for_content WHERE id=:id_topic');
	$verification->execute(array('id_topic' => $id_topic));
	$verif_result=$verification->fetch();

	if($verif_result['id_user']!=$_SESSION['uid']){
		$_SESSION['flash']['warning']="Il semble que vous avez tenté de modifier un contenu dont vous n'êtes pas le propriétaire. Votre action a été annulée";
		header('location:forum_topics.php');
		exit();
	}
?>

<?php 

	// Verifying the new datas before adding them to the database
	if(!empty($_POST)){
		$errors=array();

		if(empty($_POST['titre']) || !isset($_POST['titre'])){
			$errors['titre']='Veuillez rentrer un titre valable';
		}

		if(empty($_POST['contenu']) || !isset($_POST['contenu'])){
			$errors['contenu']='Veuillez rentrer un contenu valable';
		}

		if(!empty($_POST['show_mail']) && $_POST['show_mail']=='yes'){
			$show_mail=1;
		}else{
			$show_mail=0;
		}

		if(empty($errors)){
		// var_dump($_POST);die;
			// Updating the topic
			$req=$bdd->prepare('UPDATE for_content SET title=:titre, content=:contenu,edit_date=NOW(), show_mail=:show, edited=1 WHERE id=:id_topic');
			$req->execute(array('titre' => $_POST['titre'] , 'contenu' => $_POST['contenu'], 'show' => $show_mail,'id_topic' => $id_topic));
			if($req){
				$_SESSION['flash']['success']="Votre topic a été modifié avec succès";
				header('location:forum_read.php?id='.$id_topic);
				exit();
			}
			else{
				$_SESSION['flash']['failure']="Votre topic n'a pas pu être modifié";
			}
		}
	}

?>

<?php 

	// Collecting all the informations related to the topic
	$collecte=$bdd->prepare('SELECT * FROM for_content WHERE id=:id_topic');
	$collecte->execute(array('id_topic' => $id_topic));
	$infos_topic=$collecte->fetch();
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
  			<!-- <li><img src="img/forum/slide1.png"/></li> -->
 			<li><img src="img/forum/slide2.png" /></li>
 			<li><img src="img/forum/slide3.png" /></li>
 			<li><img src="img/forum/slide4.png" /></li>
		</ul>

	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>
	<style type="text/css">
		input[type="text"]{
			width: 240px;
			height: 35px;
			border-radius: 3px;
			color: white;
			background-color: rgba(255,255,255,0.1);
			border: 1px rgba(255,255,255,0.5) solid;
			margin: 10px;
			-webkit-transition: 0.5s;
			-moz-transition: 0.5s;
			transition: 0.5s;
			text-align: center;
		}

		textarea{
			width: 240px;
			height: auto;
			min-height: 150px;
			border-radius: 3px;
			color: white;
			background-color: rgba(255,255,255,0.1);
			border: 1px rgba(255,255,255,0.5) solid;
			margin: 10px;
			-webkit-transition: 0.5s;
			-moz-transition: 0.5s;
			transition: 0.5s;
			text-align: center;
			font-size: 15px;
			padding: 5px;
		}

		input[type="submit"]{
			width: 240px;
			height: 35px;
			border: 2px solid white;
			background-color: rgba(0,0,0,0);
			border-radius: 3px;
			color: white;
			font-size: 15px;
			letter-spacing: 1px;
		}

		input[type="submit"]:hover{
			background-color: white;
			color: black;
			cursor: pointer;
		}

		input[type="text"]:focus,textarea:focus{
			/*width: 280px;*/
			background-color: white;
			color: black;
			/*text-align: center;*/
			font-size: 15px;
			border: 1px rgba(255,255,255,0.5) solid;
			outline: none;
			box-shadow: 0 0 5px white;
		}

		::-webkit-input-placeholder{
			font-size: 15px;
		}

		input[type="checkbox"]{
			width: 20px;
			height: 20px;
			border-radius: 5px;
		}

		span{
			color: white;
			font-size: 15px;
			letter-spacing: 1px;
		}
	</style>

	<div style="height: auto;min-height: 700px;background-color: rgba(0,0,0,0.8); ">
		<div style="width: 600px;height:auto;min-height: 600px;margin: auto;text-align: center;">
			<img src="img/forum/marker.png" style="height: 150px;margin-top: 30px; ">
			<!-- <p style="color: white;font-size: 20px; ">Editeur de topics</p> -->
			<div style="width: 70%;margin: auto;padding-top: 20px;padding-bottom: 20px;margin-top: 20px;background-color: rgba(0,0,0,0.1);border-radius: 5px;box-shadow: 0 0 5px white;  ">
				<form method="post" action="">
					<span>Votre Nouveau titre</span></br>
					<textarea name="titre" required="required" style="height:auto;min-height: 30px;"><?php echo $infos_topic['title'];?></textarea></br>
					<!-- <input type="text"  value="" required></br> -->
					<span>Votre nouveau topic</span></br>
					<textarea name="contenu" required> <?php echo $infos_topic['content'];?> </textarea></br>
					<div style="font-size: 16px;margin: -4px auto 10px auto;color: white; "><input type="checkbox" name="show_mail" <?php if($infos_topic['show_mail']==1) echo "checked";?> value="yes">Afficher mon adresse mail</br></div>
					<input type="submit" value="Mettre à jour">
				</form>
			</div>
		</div>
	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

</body>
</html> 