<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page D'accueil</title>
	<?php include('include_plugins.php'); ?>	
</head>
<body>
<div id="wrapper" >
	<!-- Header -->
	<header>
		<!--Include the page's head-->
		<?php include('PageHead.php');?>

		<!-- header image -->
		<img src="img/banners/accueil.png" width="100%" height="100%" alt="">
	</header>

	<!--Navigation links-->
	<?php include('nav.php'); 
		include('db_connect.php');
	?>

		<div style="min-height:600px;width: 100%;background-color: rgba(0,0,0,0.8);padding-top: 20px;position: relative;  " >
		<!-- Drop down menu -->
		<div style="width: 500px;height: 500px;position: absolute;top: 0;left: 0;z-index: 10; ">
			<style>
			.dropbtn {
				background-color: rgba(0,0,0,0);
			    background-image: url('img/forum/drop-down-round-button.png');
			    background-size: 30px;background-position: 0px 0px;
			    color: white;
			    font-size: 16px;
			    border: none;
			    cursor: pointer;
			    width: 30px;
			    height: 30px;
			}

			.dropdown {
			    position: relative;
			    display: inline-block;
			}

			.dropdown-content {
			    display: none;
			    position: absolute;
			    right: 0;
			    top: 35px;
			    background-color: #f9f9f9;
			    width: 100px;
			    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			    border-radius: 3px;
			}

			.dropdown-content a {
			    color: black;
			    padding: 10px;
			    text-decoration: none;
			    display: block;
			}

			.dropdown-content a:hover {background-color: #f1f1f1}

			.dropdown:hover .dropdown-content {
			    display: block;
			}

			.dropdown:hover .dropbtn {
			    background-color: rgba(0,0,0,0);
			}
			</style>

			<div class="dropdown" style="position: absolute;left: 5px;top: 5px; "; >
			  <button class="dropbtn"></button>
			  <div class="dropdown-content" style="left:0;">
			    <a href="forum.php">Accueuil</a>
			    <a href="forum_topics.php">Topics</a>
			  </div>
			</div>
		</div>

		<div class="animated fadeIn">
	<!-- AFFICHAGE DE LA PAGE -->
	<?php 
		if(empty($_GET)){
			echo "cette  page n'éxiste pas";
		} else{
			$id=( (int)($_GET['id']) );
			$req=$bdd->prepare('SELECT solved,edited,show_mail,id_user,id,title,content,DAY(publi_date) AS jour, MONTH(publi_date) AS mois, YEAR(publi_date) AS annee, HOUR(publi_date) AS heure,MINUTE(publi_date) AS minute FROM for_content WHERE id=:id_content ORDER BY publi_date DESC ');
			$req->execute(array('id_content' => $id));
			if($article=$req->fetch()){
				//COLLECTING USER INFOS
					$requete=$bdd->prepare('SELECT * FROM user WHERE id =:id_user');
					$requete->execute(array('id_user' => $article['id_user']));
					$infos_user=$requete->fetch();

					$reponse=$bdd->prepare('SELECT DAY(last_connexion) AS ljour, MONTH(last_connexion) AS lmois, YEAR(last_connexion) AS lannee, HOUR(last_connexion) AS lheure ,MINUTE(last_connexion) AS lminute, DAY(date_inscription) AS jour, MONTH(date_inscription) AS mois, YEAR(date_inscription) AS annee, HOUR(date_inscription) AS heure,MINUTE(date_inscription) AS minute FROM user WHERE id=:id_user');
					$reponse->execute(array('id_user' => $article['id_user']));
					$inscription_user=$reponse->fetch();
		?>	

			<style>
				.parent{
					width:100%;
				 	height: auto;
				  	display: table;
				  	position: relative;
				}

				.topic_content{
					display: table-cell;
					width:75%;
 					height:auto;
 					padding: 15px;
 					padding-bottom: 40px;
				}
				.user_informations{
					display: table-cell;
					width:25%;
 					height:auto;
  					border-right: 1px solid white;
  					text-align: center;
				}
			</style>

			<div style="width: 80%;padding: 10px;border:1px solid white;background-color: rgba(255,255,255,0.8);margin:auto;border-radius: 5px;position: relative;margin-top: 20px;margin-bottom: 20px; ">
				<img src="img/forum/topic.png" style="width: 30px;position: absolute;left: 20px;top: 5px; ">
				<span style="font-size: 20px;color: black;margin-left: 50px; " >Topic</span>
			</div>

			<!--TOPIC **************************************************************************************************************-->

			<!--TOPIC CONTENT AND USER INFOS-->
			<div style="width: 80%;border:solid 1px white;margin: auto;border-radius: 5px;color: white;background-color:rgba(0,0,0,0.3);margin-bottom: 20px;position: relative; ">
				<!--BLOC HEADER / DATE-->
				<div style="border-bottom: solid white 1px;width: 100%; " >
					<p style="text-align: left;font-size: 12px;margin-left: 20px; "> <?php echo "publié le ".$article['jour']."/".$article['mois']."/".$article['annee']." à ".$article['heure']." heures ".$article['minute']." "; if($article['edited']==1) echo "(modifié)";if($article['solved']==1) echo '<span style="color:yellow;font-size:13px; ">  [ RÉSOLU ]</span>'; ?> </p>

					<!--EDITING OPTIONS-->
					<!-- Check if it's the author or not-->
					<?php if($article['id_user']==$_SESSION['uid']):?>
						<!--Edit Topic-->
						<a href="forum_edit_topic.php?id=<?php echo $id;?> "><img src="img/forum/edit3.png" style="width: 25px;position: absolute;right: 40px;top: 5px;"></a>

						<!--Delete Topic-->
						<a href="forum_delete_topic_confirm.php?id=<?php echo $id; ?>#choice_box"><img src="img/forum/trash2.png" style="width: 25px;position: absolute;right: 10px;top: 5px;"></a>

						<!--Solved tag : Check if the topic has been solved or not-->
						<?php if($article['solved']!=1):?>
							<a href="forum_topic_solved.php?id=<?php echo $id; ?>"><img src="img/forum/solved.png" style="width: 25px;position: absolute;right: 70px;top: 5px;"></a>
						<?php endif;?>
					<?php endif; ?>
				</div>
				<!-- BLOC THAT CONTAINS THE TOPIC-->
				<div class="parent">
					<!--User informations -->
					<div class="user_informations">
						<p style="color: white;text-align: center;font-size: 20px;margin: 0px;margin-top: 5px; font-style: italic; "><?php echo $infos_user['pseudo']; ?></p>
						<img src="img/<?php if($infos_user['avatar']!=0 && !empty($infos_user['avatar'])) echo "avatar/".$infos_user['avatar'];else echo "default_profile.png"; ?>" style=" display: block;border-radius: 50%;width: 90px;margin: 10px auto 0px auto; ">
						<p style="font-size: 12px;text-align: center; "><!--<img src="img/forum/user.png" style="width: 20px;margin-right: 10px; ">--><em>Membre depuis le : </em><?php echo $inscription_user['jour']."/".$inscription_user['mois']."/".$inscription_user['annee']; ?></p>
						<?php if($article['show_mail']==1) echo '<p style="font-size: 13px;">'.$infos_user['mail'].'</p>'; ?>
					</div>
					<!--Topic content-->
					<div class="topic_content">
						<h1 style="text-align: left;margin: 0px;font-size: 25px; "><?php echo $article['title']; ?></h1>
						<p style="text-align: justify;line-height: 20px; "><?php echo $article['content'];?></p>
					</div>

					<div style="position: absolute;right: 20px;bottom: 20px;font-size: 13px; ">
						<?php echo "Dernière connexion : ".$inscription_user['ljour']."/".$inscription_user['lmois']."/".$inscription_user['lannee']." à ".$inscription_user['lheure']." heures ".$inscription_user['lminute']; ?>
					</div>
				</div>
			</div>

			<div style="margin-left: auto;margin-right: auto;margin-bottom: 80px;width: 80%;position: relative; ">
				<a href="#commenter"><button style="position: absolute;right: 0; ">Commenter</button></a>
			</div>
			
			<div style="height:80px;"></div>

			<div style="width: 80%;padding: 10px;border:1px solid white;background-color: rgba(255,255,255,0.8);margin:auto;border-radius: 5px;position: relative;">
				<img src="img/forum/chat.png" style="width: 30px;position: absolute;left: 20px;top: 5px; ">
				<span style="font-size: 20px;color: black;margin-left: 50px; " >Commentaires</span>
			</div>


		<?php
			}else{
				echo "cet article n'existe pas";
				exit();
			}

			if( empty($_SESSION['pseudo']) && empty($_SESSION['password']) ){
				if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['commentaire'])){
					$nom=$_POST['pseudo'];
					$email=$_POST['email'];
					$commentaire=$_POST['commentaire'];
					$pseudo=$_POST['pseudo'];

					if($_POST['show_mail']=='on')
						$show_mail=1;
					else
						$show_mail=0;

					// var_dump($commentaire);die;
					$rep0=$bdd->prepare('INSERT INTO for_messages SET message=:msg,publication_date=NOW() , id_content=:idarticle, show_mail=:smail,pseudo=:username,email=:mail');

					$rep0->execute(array('msg'=> $commentaire, 'idarticle' => $id, 'smail' =>$show_mail , 'username'=>$pseudo,'mail'=>$email));
					if($rep0)
						echo "commentaire posté avec succès";
					else
						echo "echec de post";

				}else{
					// echo "vérifiez que tous les champs sont corrects";
				}

			}else{
				if(!empty($_POST['commentaire']) && isset($_POST['commentaire'])){
					if(!empty($_POST['show_mail']) && isset($_POST['show_mail']))
						$show_mail=1;
					else
						$show_mail=0;

					$rep0=$bdd->prepare('INSERT INTO for_messages SET message=:msg, id_user=:iduser,publication_date=NOW() , id_content=:idarticle, show_mail=:smail,pseudo=:username,email=:mail');

					$rep1=$bdd->prepare('SELECT id FROM user WHERE pseudo=:username ');
					$rep1->execute(array('username' => $_SESSION['pseudo']));
					$inf_user=$rep1->fetch();
					$uid=$inf_user['id'];

					$rep0->execute(array('msg'=> $_POST['commentaire'], 'iduser' => $uid, 'idarticle' => $id, 'smail' =>$show_mail , 'username'=>$_SESSION['pseudo'],'mail'=>$_SESSION['email']));
					if($rep0){
						// $_SESSION['flash']['success']="Votre commentaire a été posté avec succès";
						// header('location:forum_read.php?id='.$article["id"]);
					}
					else{
						$_SESSION['flash']['failure']="Suite à une erreur, votre commentaire n'a pas pu être posté. Veuillez réessayer";
						// header('loaction:forum_read.php?id='.$article["id"]);
					}
				}
			}

			

			$requete=$bdd->prepare('SELECT MINUTE(publication_date) AS minute ,HOUR(publication_date) AS heure, DAY(publication_date) AS jour, MONTH(publication_date) AS mois, YEAR(publication_date) AS annee,pseudo,id,message,id_user,id_content,show_mail,email FROM for_messages WHERE id_content=:id_post ORDER BY publication_date DESC');
			$requete->execute(array('id_post'=>$id));
			
			// $commentaires=$requete->fetch();
			// var_dump($commentaires);die;

			while($commentaires=$requete->fetch()){
			
				if($commentaires['id_user']!=0){
				//COLLECTING USER INFOS
				$requete3=$bdd->prepare('SELECT * FROM user WHERE id =:id_user');
				$requete3->execute(array('id_user' => $commentaires['id_user']));
				$infos_user=$requete3->fetch();

				$reponse=$bdd->prepare('SELECT DAY(date_inscription) AS jour, MONTH(date_inscription) AS mois, YEAR(date_inscription) AS annee FROM user WHERE id=:id_user');
				$reponse->execute(array('id_user' => $commentaires['id_user']));
				$inscription_user=$reponse->fetch();?>

			<!-- USER COMMENT**************************************************************************************************************-->

			<!--COMMENT CONTENT AND USER INFOS-->
			<div style="width: 80%;border:solid 1px black;margin: auto;border-radius: 5px;color: white;background-color:rgba(255,255,255,0.1);margin-top: 20px;margin-bottom: 20px; ">
				<!--BLOC HEADER / DATE-->
				<div style="border-bottom: solid black 1px;width: 100%;position: relative; " >
					<p style="text-align: left;font-size: 12px;margin-left: 20px; "> <?php echo "publié le ".$commentaires['jour']."/".$commentaires['mois']."/".$commentaires['annee']." à ".$commentaires['heure']." heures ".$commentaires['minute'];?> </p>
					<?php if (isset($_SESSION['pseudo']) )if($commentaires['pseudo']==$_SESSION['pseudo']){ ?>
						<a href="forum_edit.php?id=<?php echo $commentaires['id']; ?>&page=<?php echo $id; ?>"><img src="img/forum/edit2.png"  style="width: 25px;position: absolute;right: 40px;top: -5px;"></a>
						<a href="forum_delete_comment.php?id=<?php echo $commentaires['id']; ?>&page=<?php echo $id; ?>"><img src="img/forum/trash.png"  style="width: 25px;position: absolute;right: 10px;top: -5px;"></a>
					<?php } ;?>
				</div>
				<!--RIGHT BLOC THAT CONTAINS THE TOPIC-->
				<div class="parent">
					<!--User informations -->
					<div class="user_informations" style="border-right: 1px solid black; ">
						<p style="color: white;text-align: center;font-size: 20px;margin: 0px; font-style: italic; "><?php echo $infos_user['pseudo']; ?></p>
						<img src="img/<?php if($infos_user['avatar']!=0 && !empty($infos_user['avatar'])) echo "avatar/".$infos_user['avatar'];else echo "default_profile.png"; ?>" style=" display: block;border-radius: 50%;width: 90px;margin: 10px auto 0px auto; ">
						<p style="font-size: 12px;text-align: center; "><!--<img src="img/forum/user.png" style="width: 20px;margin-right: 10px; ">--><em>Membre depuis le : </em><?php echo $inscription_user['jour']."/".$inscription_user['mois']."/".$inscription_user['annee']; ?></p>
						<?php if($commentaires['show_mail']==1) echo '<p style="font-size: 13px;">'.$infos_user['mail'].'</p>'; ?>
					</div>
					<!--Topic content-->
					<div class="topic_content">
						<p style="text-align: justify; "><?php echo $commentaires['message'];?></p>
					</div>

					<?php if($infos_user['role']=='admin'): ?>
						<div style="position: absolute;right: 10px;bottom: 10px;font-size: 18px;color: yellow; ">
							<?php echo "Admin" ?>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<?php
			 }else{
			?>

			<!--VISITOR COMMENT************************************************************************************************************** -->
			<!--COMMENT CONTENT AND USER INFOS (VISITOR)-->
			<div style="width: 80%;border:solid 1px black;margin: auto;border-radius: 5px;color: white;background-color:rgba(255,255,255,0.1);margin-top: 20px;margin-bottom: 20px; ">
				<!--BLOC HEADER / DATE-->
				<div style="border-bottom: solid black 1px;width: 100%; " >
					<p style="text-align: left;font-size: 12px;margin-left: 20px; "> <?php echo "publié le ".$commentaires['jour']."/".$commentaires['mois']."/".$commentaires['annee']." à ".$commentaires['heure']." heures ".$commentaires['minute'];?> </p>
				</div>
				<!--RIGHT BLOC THAT CONTAINS THE TOPIC-->
				<div class="parent">
					<!--User informations -->
					<div class="user_informations" style="border-right: 1px solid black; ">
						<p style="color: white;text-align: center;font-size: 20px;margin: 0px; font-style: italic;display: block;padding: 0px;"><?php echo "Visiteur : ".$commentaires['pseudo']; ?></p>

						<img src="img/default_profile.png" style=" display: block;border-radius: 50%;width: 90px;margin: 10px auto 0px auto; ">
						<p style="font-size: 12px;text-align: center; "><!--<img src="img/forum/user.png" style="width: 20px;margin-right: 10px; ">-->

						<?php if($commentaires['show_mail']==1) echo '<p style="font-size: 13px;">'.$commentaires['email'].'</p>'; ?>
					</div>
					<!--Topic content-->
					<div class="topic_content">
						<p style="text-align: justify; "><?php echo $commentaires['message'];?></p>
					</div>
				</div>
			</div>


			<?php
			 }
			}

		}
		?>

		<style type="text/css">
			input[type="text"],input[type="email"]{
				color: white;
				font-size: 15px;
				text-align: center;
				width: 300px;
				background-color: rgba(255,255,255,0.1);
				height: 35px;
				border-radius: 3px;
				outline: none;
				border: 1px solid white;
				margin-bottom:10px;
				transition: 0.5s all;
				-webkit-transition: 0.5s all;
				-moz-transition: 0.5s all;
			}

			input[type="text"]:hover,input[type="email"]:hover{
				background-color: rgba(255,255,255,0.2);
			}

			textarea{
				color: white;
				font-size: 15px;
				text-align: center;
				/*width: 295px;*/
				width: 500px;
				background-color: rgba(255,255,255,0.1);
				height: 30px;
				border-radius: 3px;
				outline: none;
				border: 1px solid white;
				margin-bottom:10px;
				transition: 0.5s all;
				-webkit-transition: 0.5s all;
				-moz-transition: 0.5s all;
				padding: 15px;
			}

			textarea:hover{
				background-color: rgba(255,255,255,0.2);
			}

			textarea:focus{
				background-color: white;
				color: black;
				height: 100px;
			}

			input[type="text"]:focus,input[type="email"]:focus{
				background-color: white;
				color: black;
			}

			::-webkit-input-placeholder:focus{
				/*color: black;*/
			}

			input[type="checkbox"]{
				width: 20px;
				height: 20px;
				position: absolute;
				left: 0px;top: -3px;
			}

			button{
				width: 150px;
				height: 35px;
				border: solid white 2px;
				color: white;
				background:rgba(255,255,255,0.1);
				font-size: 15px;
				border-radius: 3px;
				margin-bottom: 15px;
			}

			button:focus{
				background-color: white;
				color: black;
				outline: none;
			}

			button:hover{
				background-color: rgba(255,255,255,0.2);
			}

		</style>

			<div style="width: 80%;padding: 10px;border:1px solid white;background-color: rgba(255,255,255,0.8);margin:auto;border-radius: 5px;position: relative;margin-bottom: 20px;margin-top: 100px; ">
				<img src="img/forum/comment.png" style="width: 30px;position: absolute;left: 20px;top: 5px; ">
				<span style="font-size: 20px;color: black;margin-left: 50px; " >Votre Avis</span>
			</div>


			<div style="width: 80%;/*border: 1px solid white;*/margin:auto; ">
				<form method="post" action="" id="commenter">
				<?php if(!empty($_SESSION['pseudo']) && !empty($_SESSION['password']) )
					{ 
				?>
					<textarea name="commentaire" placeholder="Votre commentaire" required></textarea></br>
				<?php 
					}else{
				?>
					<!--Choississez un nom de visiteur</br>-->
					<input type="text" name="pseudo" placeholder="Pseudo visiteur" required></br>
					<!--Email</br>-->
					<input type="email" name="email" placeholder="Email" required></br>
					<!--Commentaire</br>-->
					<textarea name="commentaire" placeholder="Votre commentaire" required></textarea></br>
					<!--<input type="text" name="commentaire"></br>-->
				<?php 
					}
				?>
					<div style="font-size: 18px;color: white;position: relative;margin-bottom: 10px; ">
						<input type="checkbox" name="show_mail" value="on" id="show_m" checked><label for="show_m" style="margin-left: 30px;letter-spacing: 1px; ">Afficher mon adresse mail</label for="show_m"></br>
					</div>
					<button type="submit">Poster</button>
				</form>
			</div>
		</div>
		</div>
	<!--Footer-->
	<?php include('footer.php'); ?>
</div>

<!-- Scroll vers une ancre -->
<script type="text/javascript">
$(document).ready(function(){
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash,
	    $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});
});
</script>

</body>
</html>