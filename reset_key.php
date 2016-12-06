<?php
require ("config/database.php");

if (isset($_POST["ResetPasswordForm"]))
{
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $hash = $_POST["q"];
  if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $password))
  {
    header("Location: $url_path/auth.php?reset_2w=$hash");
    exit();
  }
  $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
  $resetkey = hash('sha512', $salt.$email);

  if ($resetkey == $hash)
  {
    if ($password == $confirmpassword)
    {
      $password = hash('sha512', $password);

      $req = $PDO->prepare('UPDATE users SET password = :password WHERE email = :email', array('password' => $password, 'email' => $email));
      $PDO = null;
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
      	border: solid 1px #cbc9c9;">Your password has been successfully reset.</DIV>';
    }
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
      	border: solid 1px #cbc9c9;">Your password do not match.</DIV>';
  }
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
    	border: solid 1px #cbc9c9;">Your password reset key is invalid.</DIV>';
}?>
