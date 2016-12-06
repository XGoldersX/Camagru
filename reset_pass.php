<?php
require ("config/database.php");
require ("header.php");

if (isset($_POST["ForgotPassword"]))
{
  // Mail checking.
  if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    $email = $_POST["email"];
  else
  {
    echo "email is not valid";
    exit;
  }

  $req = $PDO->prepare('SELECT email FROM users WHERE email = :email', array('email' => $email));
  $userExists = $req->fetch(PDO::FETCH_ASSOC);
  $PDO = null;

  // Request succed if the usermail is in the database.
  if ($email = $userExists["email"])
  {
    // Secure the password request.
    $secu = "498#2D83B631%3800EBD!801600D*7E3CC13";
    $password = hash('sha512', $secu.$userExists["email"]);
    $link = "http://localhost:8080/camagru/auth.php?reset_2=".$password;

    // Mail preparation.
    $body = "Hi friend ! It appears that you have requested a password reset for your Camagru account.\n\nTo reset your password, please click the link below.\n\n" . $link . "";
  	$sujet  = "Camagru: Password Reset";
  	$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
  	$header.= "Reply-to: \"Camagru\" <camagru@42.fr>" . "\r\n";
  	$header.= "MIME-Version: 1.0" . "\r\n";
  	$header.= 'X-Mailer: PHP/' . phpversion();
  	mail($email, $sujet, $body, $header);

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
    	border: solid 1px #cbc9c9;">Your password recovery key has been sent to your e-mail address.</DIV>';
  }
  // Error case of non valid email.
  else
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
    	border: solid 1px #cbc9c9;">No user with that e-mail address exists.</DIV>';
}
?>
