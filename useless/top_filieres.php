		<div>

		<style type="text/css">
			#bloc_filieres_index
			{
				text-align: center;
				/*border: solid black 3px;*/
			}

			.filieres_index
			{
				/*border: solid black 3px;*/
				width: 20%;
				margin: 5%;
				display: inline-block;
				height: 200px;
				border-radius: 15px 50px 30px;
				color: white;
				box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				background-color: teal;
				position: relative;
				padding: 0px;
			}

			.filieres_index:hover #description_filiere
			{
				/*background-color: black;
				opacity: 0.5;*/
				/*display: block;*/

			}

			.filieres_index #titre_filiere
			{
				font-size: 40px;
				margin-top: 30%;
				font-style: italic;
			}

			.filieres_index #description_filiere
			{
				display: none;
				position: absolute;
				background-color: gray;
				height: 160px;
				width: 160px;
				box-shadow:0px 8px 16px 0px rgba(0,0,0,0.2);
				z-index: 10;
				/*top: -15px;left: 210px;*/
				border-radius: 2px 50px 30px 2px ;
				padding: 10px;
				font-size: 25px;
			}

		</style>

		</div>

		<!--Second Section-->
		<section id="section_2">
			<h1>Filières ayant le plus d'éléves</h1>
			<div id="bloc_filieres_index">
		<?php
		
			$topf=$bdd->query('SELECT * FROM filiere ORDER BY nombre_deleves DESC LIMIT 3');

			while ($filiere=$topf->fetch()) 
				{ 
		?>
					<div class="filieres_index" >
						<p id="titre_filiere">
							<?php echo $filiere['nom'];?>
						</p>
						<p id="description_filiere">
							<?php echo $filiere['description'];?>
						</p>
					</div>
		<?php 
				}
		?>
			</div>
		</section>