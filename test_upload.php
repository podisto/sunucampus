<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="imagetest">
		<input type="submit" name="Envoyer">
	</form>
</body>
</html>

<?php
	include('db_connect.php');

	$id =15;

	if( isset($_FILES['imagetest']) && $_FILES['imagetest']['error']==0)
	{
		echo "modou";
		if($_FILES['imagetest']['size']<=3000000)
		{
			$infosficher		=pathinfo($_FILES['imagetest']['name']);
			$extension_fichier	=$infosficher['extension'];
			$extension_autisees	=array('jpg','jpeg','png','gif');

			if (in_array($extension_fichier,$extension_autisees)) {
				move_uploaded_file($_FILES['imagetest']['tmp_name'], 'img/uploads/'.$id.'.jpg/');
			}
		}
	}
?>