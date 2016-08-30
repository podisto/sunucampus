		<?php
			include('db_connect.php'); 

			//NON READ MESSAGES COUNTING
			$req=$bdd->query(	'SELECT COUNT(*) as nbMsg FROM contact WHERE etat=1');
			$donnees=$req->fetch();
			$req->closeCursor();
		?>

		<div id="aside_bar" >
			<div class="bar_content">
			<img src="img/admin.png" class="admin_logo">
			<p>Bonjour <?php echo $_SESSION['pseudo']; ?> ! </p>
			<ul>
				<li><a href="admin_messages_box.php">Messages</a><a href="admin_messages_box.php<?php ?>"><div class="nombre_messages"><?php echo $donnees['nbMsg']; ?></div></a> </li>
				<li><a href="gestion_site.php">Gestion Site</a></li>
				<li><a href="membres.php">Membres</a></li>
				<li><a href="base.php">Filieres</a></li>
				<li><a href="gestion_site_dossier.php">Gestion Dossiers</a></li>
			</ul>
			</div>
		</div>