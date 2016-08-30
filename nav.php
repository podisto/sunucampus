	<nav id="ancre_nav">
		<ul>
			<li><a href="index.php">SunuCampus</a></li>
			<li><a href="presentation.php">Présentation</a></li>
			<li><a href="news.php">News</a></li>

			<!--User Panel (only available when logged in users)-->
			<?php
				if( isset($_SESSION['role']))
					if($_SESSION['role']!='admin')
					{
						include('user_espace_dossier.php');
					}
				if(!isset($_SESSION['password']) && !isset($_SESSION['pseudo']))
					include('user_espace_dossier.php');
			?>

			<li><a href="forum.php">Forum</a></li>

			<?php
				if( isset($_SESSION['role']))
					if($_SESSION['role']!='admin')
					{
						echo '<li><a href="contact.php">Contact</a></li>';
					}

				if(!isset($_SESSION['password']) && !isset($_SESSION['pseudo']))
					echo '<li><a href="contact.php">Contact</a></li>';
			?>

			<!--Control Panel for admins-->
			<?php
				if( isset($_SESSION['role']))
					if($_SESSION['role']=='admin')
					{
						echo '<li><a href="gerer.php">Gestion</a></li>';
					}
			?>

			<!--Log in/log out link-->
			<a href="<?php
						if(isset($_SESSION['password']) && isset($_SESSION['pseudo']))
							{
								echo 'logout.php';
							}
						else
							echo "loginPage.php";

					 ?>" class="login">
					 <?php
					 	if(isset($_SESSION['password']) && isset($_SESSION['pseudo']))
					 		echo 'Déconnexion';
					 	else
					 		echo 'Connexion';
					 ?>
					 </a>
		</ul>
	</nav>

	<!-- Sweet Alert Plugin -->
	<script src="sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="sweetalert/dist/sweetalert.css">

	<?php if(isset($_SESSION['flash'])): ?>
		<?php foreach ($_SESSION['flash'] as $type => $message){
			echo '
			<script type=\'text/javascript\'>
				swal({   title: "Notification",
				text: "'.$message.'",
				timer: 2000,
				showConfirmButton: false });
			</script> ';
			}
			unset($_SESSION['flash']);
		?>
	<?php endif; ?>
