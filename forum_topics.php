<?php session_start(); ?>

<?php 
	if(!empty($_GET)){
		$page=(int)($_GET['id']);
	}else{
		$page=0;
	}
?>

<?php
	// function div($nombre,$diviseur){
	// 	$resultat=0;
	// 	while($nombre>=$diviseur){
	// 		$nombre-=$diviseur;
	// 		$resultat++;
	// 	}
	// 	return $resultat;
	// }
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


	<div style="height: auto;min-height: 600px;border:rgba(0,0,0,0) 1px solid;background-color: rgba(0,0,0,0.8);text-align: center; ">
		<div>
			<?php 
				require_once'db_connect.php';
				$comptage=$bdd->query('SELECT COUNT(*) FROM for_content');
				$topics_postes=$comptage->fetch();

				$nb_pages=(int)($topics_postes['0']/5);
				if($topics_postes%5!=0)
					$nb_pages++;

				$start= $page*5;
				//COLLECTING TOPIC INFOS
				/*$req=$bdd->query('SELECT show_mail,id_user,id,title,content,DAY(publi_date) AS jour, MONTH(publi_date) AS mois, YEAR(publi_date) AS annee, HOUR(publi_date) AS heure,MINUTE(publi_date) AS minute FROM for_content ORDER BY publi_date DESC LIMIT '.$start.' ,5');*/
				$req=$bdd->query('SELECT solved,edited,show_mail,id_user,id,title,content,DAY(publi_date) AS jour, MONTH(publi_date) AS mois, YEAR(publi_date) AS annee, HOUR(publi_date) AS heure,MINUTE(publi_date) AS minute FROM for_content ORDER BY publi_date DESC LIMIT '.$start.' ,5 ');

				while($article=$req->fetch()){
					//COLLECTING USER INFOS
					$requete=$bdd->prepare('SELECT * FROM user WHERE id =:id_user');
					$requete->execute(array('id_user' => $article['id_user']));
					$infos_user=$requete->fetch();

					$reponse=$bdd->prepare('SELECT DAY(date_inscription) AS jour, MONTH(date_inscription) AS mois, YEAR(date_inscription) AS annee, HOUR(date_inscription) AS heure,MINUTE(date_inscription) AS minute FROM user WHERE id=:id_user');
					$reponse->execute(array('id_user' => $article['id_user']));
					$inscription_user=$reponse->fetch();

					$requete2=$bdd->prepare('SELECT COUNT(*) FROM for_messages WHERE id_content=:id_topic');
					$requete2->execute(array('id_topic' => $article['id']));
					$commentaires=$requete2->fetch();

					// var_dump($commentaires);
					// var_dump($commentaires[0]);
			?>	
			<style>
				#topic{
					color: white;
					width: 80%;
					margin: auto;
					margin-top: 20px;
					margin-bottom: 20px;
					position: relative;
				}

				#topic:hover{
					background-color: rgba(0,0,0,0.35);
				}
			</style>

			<!--Display the topic and infos-->
			
				<!--<p style="border:solid 3px black;width: 300px;margin: 20px;padding: 5px;border-radius: 5px;background-color: white; " >-->
			<div id="topic" class="animated fadeIn ">
			<a style="text-decoration: none;color: white " href="forum_read.php?id=<?php echo $article['id']; ;?> " >
				<div style="border: solid 1px white;border-radius: 5px;background-color:rgba(0,0,0,0.3); ">
					<!--BLOC HEADER / DATE-->
					<div style="width: 100%;float: right;border-bottom:white solid 1px; ">

						<p style="text-align: left;font-size: 12px;margin-left: 20px; "> <?php echo "publié le ".$article['jour']."/".$article['mois']."/".$article['annee']." à ".$article['heure']." heures ".$article['minute']." "; if($article['edited']==1) echo "(modifié)";if($article['solved']==1) echo '<span style="color:yellow;font-size:13px; ">  [ RÉSOLU ]</span>'; ?> </p>

					</div>


					<div style="float: right;width: 70%;padding: 20px;margin: 0px;position: relative; " >
						<h1 style="text-align: left;margin: 0px;font-size: 25px; "><?php echo $article['title']; ?></h1>
						<p style="text-align: justify; "><?php echo substr($article['content'],0,140)."...";?></p>
					</div>

					<div style="float: right;width: 23.8%;border-right: solid 1px white; " >
						<p style="color: white;text-align: center;font-size: 20px;margin: 0px;margin-top: 5px; font-style: italic; "><?php echo $infos_user['pseudo']; ?></p>
						<img src="img/<?php if($infos_user['avatar']!=0 && !empty($infos_user['avatar'])) echo "avatar/".$infos_user['avatar'];else echo "default_profile.png"; ?>" style=" display: block;border-radius: 50%;width: 90px;margin: 10px auto 0px auto; ">
						<p style="font-size: 12px;text-align: center; "><!--<img src="img/forum/user.png" style="width: 20px;margin-right: 10px; ">--><em>Membre depuis le : </em><?php echo $inscription_user['jour']."/".$inscription_user['mois']."/".$inscription_user['annee']; ?></p>
					</div>

					<div style="clear: both;width:100%;height: 0.5px;"></div>

					<!--Number of comments-->
					<p style="position: absolute;bottom: 0px;right: 20px; "><?php echo $commentaires[0]." ";if($commentaires[0]!=1)echo "commentaires";else echo "commentaire"; ?></p>
				</div>
				</a>

			</div>
				<!--</p>-->
			

				<?php
					}
				?>
				<style type="text/css">
					#for_page_nav a{
						color: white;
						text-decoration: none;
						display: inline-block;
						margin-left: 3px;
						margin-right: 3px;
					}

					#current_link a{
						color: teal;
						text-decoration: underline;
					}
				</style>
				<div style="padding: 10px; " id="for_page_nav">

				<!-- Page précédente -->
				<?php if($page>0){?>
					<a href="forum_topics.php?id=<?php echo $page-1; ?>"> << </a>
				<?php } else echo "<<";; ?>
				
				<!-- Navigation entre pages -->
				<?php if($nb_pages>=2): 
				// var_dump('ok');
					for($i=0;$i<$nb_pages;$i++){
				?>	
					<span <?php if($i==$page) echo ' id="current_link" ';?> >
						<a href="forum_topics.php?id=<?php echo $i;?>" ><!----><?php echo $i;?><!----></a>
					</span>
				<?php 
						}
					endif; 
				?>
				<!-- page suivante -->
				<?php if($page<$nb_pages-1){ ?>
					<a href="forum_topics.php?id=<?php echo $page+1; ?>"> >> </a>
				<?php } else echo ">>";; ?>
			</div>
			
		</div>
	</div>

	<!--Footer-->
	<?php include('footer.php'); ?>
</div>
</body>
</html> 