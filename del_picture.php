<?PHP
require_once("config/database.php");

$id_pic = $_POST['id'];
$user = $_SESSION['auth']['id'];

if ($_POST['id_user'] == $user)
{
  $PDO->query("DELETE FROM web_pictures WHERE id = '$id_pic' AND id_user = '$user' ");
  $PDO->query("DELETE FROM comments WHERE id_web_picture = '$id_pic'");
  echo 1;
}
?>
