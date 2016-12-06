<?php
require("config/database.php");

// Check if a POST is set
if (isset($_POST['id']))
{
	if (isset($_POST['like']))
	{
		if ($PDO->prepare("UPDATE web_pictures SET nb_like = :nb_like WHERE id = :id",
		array("nb_like" => $_POST['nb_like'] + 1, "id" => $_POST['id'])))
			echo $_POST['nb_like'] + 1;
		else
			echo "ERR";
	}
	else if (isset($_POST['unlike']))
	{
		if ($PDO->prepare("UPDATE web_pictures SET nb_unlike = :nb_unlike WHERE id = :id",
				array("nb_unlike" => $_POST['nb_unlike'] + 1, "id" => $_POST['id'])))
			echo $_POST['nb_unlike'] + 1;
		else
			echo "ERR";
	}
}
else
	echo "no ID";

?>
