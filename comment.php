<?php
require("config/database.php");
require("comment/Comment.class.php");

$arr = array();
$validates = Comment::valid($arr);
if ($validates)
{
	$com = addslashes(nl2br(htmlspecialchars($_POST['body'])));

	$PDO->query("INSERT INTO comments (id_web_picture, body) VALUES
	('" . $_POST['id_web_picture'] . "', '$com')");

	$name  = $PDO->query("SELECT users.username FROM users INNER JOIN web_pictures ON web_pictures.id_user = users.id WHERE web_pictures.id = " . $_POST['id_web_picture'])->fetchColumn();
	$email = $PDO->query("SELECT users.email FROM users INNER JOIN web_pictures ON web_pictures.id_user = users.id WHERE web_pictures.id = " . $_POST['id_web_picture'])->fetchColumn();


	$us_nm  = $name;
	$dest   = $email;
	$body   = "Hello $us_nm ! Your picture received a comment, come to Camagru and check it !";
	$sujet  = "Camagru: Picture had been commented";
	$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
	$header.= "Reply-to: \"Camagru\" <camagru@42.fr>" . "\r\n";
	$header.= "MIME-Version: 1.0" . "\r\n";
	$header.= 'X-Mailer: PHP/' . phpversion();

	mail($dest, $sujet, $body, $header);

	echo str_replace("<br />", PHP_EOL . PHP_EOL, $com);
}
?>
