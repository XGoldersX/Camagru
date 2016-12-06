<LINK rel="stylesheet" type="text/css" href="css/auth.css">
<?PHP
require ("config.php");
require ("../connection/Connection.class.php");
require ("../header.php");

$PDO = new Connection($hostname, "", $username, $password, $log_request, $debug_req, $option);

$req1 = "CREATE DATABASE IF NOT EXISTS $db_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
$req2 = "

USE camagru;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_web_picture` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `log_request_sh`;
CREATE TABLE `log_request_sh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `request` text NOT NULL,
  `server_uri` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `log_request_wr`;
CREATE TABLE `log_request_wr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `request` text NOT NULL,
  `server_uri` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` longtext NOT NULL,
  `email` varchar(250) NOT NULL,
  `last_signin_date` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `web_pictures`;
CREATE TABLE `web_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nb_like` int(11) NOT NULL,
  `nb_unlike` int(11) NOT NULL,
  `img_encode` longtext NOT NULL,
  `user_mail` longtext NOT NULL,
  `creation_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET global sql_mode = '';

";

$one = $PDO->query($req1);
$two = $PDO->query($req2);
if ($one && $two)
  echo '<DIV style="
    text-align: center;
    margin: 20px auto;
  	width: 343px;
  	max-height:80%;
  	padding:4px;
  	font-size: 15px;
  	text-align: center;
  	-webkit-border-radius: 8px/7px;
  	-moz-border-radius: 8px/7px;
  	border-radius: 8px/7px;
  	background-color: #ebebeb;
  	-webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.31);
  	-moz-box-shadow: 1px 2px 5px rgba(0,0,0,.31);
  	box-shadow: 1px 2px 5px rgba(0,0,0,.31);
  	border: solid 1px #cbc9c9;">Database had successfully created !</DIV>'

?>
