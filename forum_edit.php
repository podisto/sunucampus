<?php session_start(); ?>

<?php 
	require_once('db_connect.php');

	if(!empty($_GET)){
		$id_commentaire=(int)($_GET['id']);
		$page=(int)($_GET['page']);
	}

	// Verify if the persone who wanna edit the post is the one who posted it
	$verification=$bdd->prepare('SELECT id_user FROM for_messages WHERE id=:id_comment');
	$verification->execute(array('id_comment' => $id_commentaire));
	$verif_result=$verification->fetch();

	if($verif_result['id_user']!=$_SESSION['uid']){
		$_SESSION['flash']['warning']="Il semble que vous avez tenté de modifier un contenu dont vous n'êtes pas le propriétaire. Votre action a été annulée";
		header('location:forum_topics.php');
		exit();
	}


	$action=$bdd->prepare('SELECT * FROM for_messages WHERE id=:idcomment');
	$action->execute(array('idcomment' => $id_commentaire));
	$commentaire=$action->fetch();
?>

<?php 
	if(!empty($_POST)){
		$errors=array();


		if(empty($_POST['contenu']) || !isset($_POST['contenu'])){
			$errors['contenu']='Votre commentaire n\'est pas valable. Veuillez renvoir la forme';
		}

		if(empty($errors)){


			$req=$bdd->prepare('UPDATE for_messages SET message=:comment WHERE id=:id_commentaire');
			$req->execute(array('id_commentaire' => $id_commentaire, 'comment' => $_POST['contenu']));
			if($req){
				$_SESSION['flash']['success']="Votre commentaire a été modifié avec succès";
				header('location:forum_read.php?id='.$page);
				exit();
			}
			else{
				$_SESSION['flash']['failure']="Suite à une erreur, votre commentaire n'a pas pu être modifié. Veuillez réessayer";
			}
			// var_dump($_POST['contenu']);var_dump($id_commentaire);var_dump($page); die;
		}
	}

?>

 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page D'accueil</title>
	<?php include('include_plugins.php'); ?>

	<!--JQuery Slider Plugin
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
	</style>

	<div style="height: auto;min-height: 700px;background-color: rgba(0,0,0,0.8); ">
		<div style="width: 500px;height:auto;min-height: 600px;margin: auto;text-align: center;">
			<img src="img/forum/marker.png" style="height: 150px;margin-top: 30px; ">
			<p style="color: white;font-size: 20px; ">Modification de commentaire</p>
			<div style="width: 70%;margin: auto;padding-top: 20px;padding-bottom: 20px;margin-top: 20px;background-color: rgba(0,0,0,0.1);border-radius: 5px;box-shadow: 0 0 5px white;  ">
				<form method="post" action="">
					<textarea name="contenu" required=><?php echo $commentaire['message'] ?></textarea></br>
					<input type="submit" value="Modifier">
				</form>
			</div>
		</div>
	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

</body>
</html>  -->