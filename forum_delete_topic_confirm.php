<?php session_start(); ?>

<?php 
	if(!empty($_GET['id']) && isset($_GET['id']) ){
		$id_topic=(int)($_GET['id']);

		require_once 'db_connect.php';

		// Verify if the persone who wanna edit the post is the one who posted it
		$verification=$bdd->prepare('SELECT id_user FROM for_content WHERE id=:id_comment');
		$verification->execute(array('id_comment' => $id_topic));
		$verif_result=$verification->fetch();

		if($verif_result['id_user']!=$_SESSION['uid']){
			$_SESSION['flash']['warning']="Il semble que vous avez tenté de modifier un contenu dont vous n'êtes pas le propriétaire. Votre action a été annulée";
			header('location:forum_topics.php');
			exit();
		}
	}
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

		<ul class="bxslider">
  			<!-- <li><img src="img/forum/slide1.png"/></li> -->
 			<li><img src="img/forum/slide2.png" /></li>
 			<li><img src="img/forum/slide3.png" /></li>
 			<li><img src="img/forum/slide4.png" /></li>
		</ul>

	</header>

	<!--Navigation links-->
	<?php include('nav.php'); ?>

	<!-- main container -->
	<div style="height: auto;min-height: 800px;background-color: rgba(0,0,0,0.8);padding-top: 30px;text-align: center;padding-top: 180px;position: relative; ">
		<!-- anchor -->
		<div style="position: absolute;top: 50px;" id="choice_box"></div>
		<!-- box container -->
		<div class="animated fadeIn " style="width: 700px;height: 500px;margin: auto;border-radius: 5px;padding: 20px;background-color: rgba(255,255,255,0.1);box-shadow: 0 0 10px white; " >
			<!-- top box  -->
			<div style="width: 100%;height: 350px;margin-bottom: 0px; " >
				<img src="img/forum/community.png" style="width: 200px; ">
				<!-- <p style="font-size: 40px;margin: 0;padding: 0;color: white;font-style: italic;margin-top: 20px;  ">Forum</p> -->
				<p style="color: white;font-size: 25px;margin: 10px 0 0 0;padding: 0; ">En laissant ce topic en ligne, vous offrez la chance à des milliers de personnes de profiter de celui-ci. Souhaitez-vous toujours supprimer ce topic?</p>
			</div>

			<!-- Options box -->
			<div style="height: 200px;width: 500px;margin: auto;text-align: center;position: relative; " >

				<div style="width: 45%;position: absolute;left: 0; border-radius: 5px;">
					<!-- <div style="height: 100%;width: 100%; "> -->
						<!-- <img src="img/forum/edit.png" style="height: 200px; "> -->
						<a href="forum_delete_topic.php?id=<?php echo $id_topic; ?>"><button class="forum_option1">Oui, supprimer</button></a>
					<!-- </div> -->
				</div>

				<div style="width: 45%;position: absolute;right: 0;border-radius: 5px; ">
					<!-- <img src="img/forum/read.png" style="height: 200px; "> -->
					<a href="forum_read.php?id=<?php echo $id_topic; ?>"><button class="forum_option2">Non, annuler</button></a>
				</div>

			<style type="text/css">
				.forum_option1{
					height: 60px;
					width: 250px;
					background-color: rgba(0,0,0,0);
					border: 2px solid white;
					border-radius: 5px;
					font-size: 20px;
					color: white;
					margin: auto;
					margin-top: 10px;
					cursor: pointer;
					transition: 0.5s all;
					-webkit-transition: 0.5s all;
					-moz-transition: 0.5s all;
					background-position: 10px 15px; 

				}

				.forum_option2{
					height: 60px;
					width: 250px;
					background-color: rgba(0,0,0,0);
					border: 2px solid white;
					border-radius: 5px;
					font-size: 20px;
					color: white;
					margin: auto;
					margin-top: 10px;
					cursor: pointer;
					transition: 0.5s all;
					-webkit-transition: 0.5s all;
					-moz-transition: 0.5s all;
  	  				background-position: 10px 10px; 
				}

				.forum_option1:hover{
					background-color: red;
					color: white;
					border:2px solid red;
					background-image: url('img/forum/dislike.png');
    				background-repeat: no-repeat;
    				background-size: 30px;
				}

				.forum_option2:hover{
					background-color: green;
					color: white;
					border: 2px solid green;
					background-image: url('img/forum/like.png');
    				background-repeat: no-repeat;
    				background-size: 30px;
				}


			</style>
			</div>
		</div>

	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

</body>
</html> 