<?PHP
require_once("config/database.php");
require_once("header.php");
?>

<LINK rel="stylesheet" type="text/css" href="css/auth.css">
<LINK rel="stylesheet" type="text/css" href="css/header.css">
<LINK href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">


<!--  Here are the 'signup' version of the page auth.php -->

<?PHP ob_start();?>

<DIV class="signup">
	<H1>Registration</H1>

	<FORM name="signup" method="POST" action="<?PHP echo $url_path;?>/index.php">
		<HR>
	<LABEL id="icon" for="name"><I class="icon-envelope "></I></LABEL>
	<INPUT type="text" name="email" id="email" placeholder="Email" required/>
	<LABEL id="icon" for="name"><I class="icon-user"></I></LABEL>
	<INPUT type="text" name="username" id="name" placeholder="Username" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="password" placeholder="Password" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="retry_password" id="name" placeholder="Confirm Password" required/>
	<BR><BR>
	<BUTTON name="signup" style="float:left"  class="button" onclick="document.location.href='camagru.php'" type="submit" >Register</BUTTON>
	<BUTTON name="signin" style="float:right" class="button" onclick="document.location.href='auth.php?signin'">Login</BUTTON>
	</FORM>
</DIV>

<?PHP
	$signup = ob_get_clean();
	ob_start();
?>


<!--  Here are the 'signin' version of the page auth.php -->

<DIV class="signup">
	<H1>Registration</H1>

	<FORM name="wrong" method="POST" action="<?PHP echo $url_path;?>/index.php">
		<HR>
	<LABEL id="icon" for="name"><I class="icon-envelope "></I></LABEL>
	<INPUT type="text" name="email" id="email" placeholder="Email" required/>
	<LABEL id="icon" for="name"><I class="icon-user"></I></LABEL>
	<INPUT type="text" name="username" id="name" placeholder="Username" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="password" placeholder="Password" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="retry_password" id="name" placeholder="Confirm Password" required/>
	<BR><BR>
	<BUTTON name="signup" style="float:left"  class="button" onclick="document.location.href='camagru.php'" type="submit" >Register</BUTTON>
	<BUTTON name="signin" style="float:right" class="button" onclick="document.location.href='auth.php?signin'">Login</BUTTON>
	</FORM>
</DIV>
<DIV class="wrong"> Notice that your email must be valid and your password must be containt at least 8 characters, letters MIN/MAJ and numbers !</DIV>

<?PHP
	$wrong = ob_get_clean();
	ob_start();
?>


<!--  Here are the 'wrong' version of the page auth.php -->

<DIV class="signin">
	<H1>Login</H1>

	<FORM name="signin" method="POST" action="<?PHP echo $url_path;?>/index.php">
		<HR>
	<LABEL id="icon" for="name"><I class="icon-user"></I></LABEL>
	<INPUT type="text" name="username" id="name" placeholder="Username" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="password" placeholder="Password" required/>
	<BR><BR>
	<BUTTON name="signin" style="float:right" class="button" onclick="document.location.href='camagru.php'" type="submit"      >Login</BUTTON>
	</FORM>
	<BUTTON name="reset_1"   style="float:left; margin-left:0.9cm;"  class="button" onclick="document.location.href='auth.php?reset_1'">Reset</INPUT>
</DIV>

<?PHP
	$signin = ob_get_clean();
	ob_start();
?>


<!--  Here are the 'reset_1' version of the page auth.php -->

<DIV class="reset_1">
	<H1>Reset</H1>

	<FORM name="reset_1" method="POST" action="reset_pass.php">
		<HR>
	<LABEL id="icon" for="name"><I class="icon-envelope "></I></LABEL>
	<INPUT type="text" name="email" id="email" placeholder="Email" required/>
	<BR><BR>
	<INPUT 	style="display:block;margin-left:auto;margin-right:auto;" align="center" class="button_b" type="submit" name="ForgotPassword" value="Reset" />
	</FORM>
</DIV>

<?PHP
	$reset_1 = ob_get_clean();
	ob_start();
?>


<!--  Here are the 'reset_2' version of the page auth.php -->

<DIV class="reset_2">
	<H1>Reset</H1>

	<FORM  name="reset_2" method="POST" action="reset_key.php">
		<HR>
	<LABEL id="icon" for="name"><I class="icon-envelope "></I></LABEL>
	<INPUT type="text" name="email" id="email" placeholder="Email" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="password" placeholder="Password" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="confirmpassword" id="name" placeholder="Confirm Password" required/>
	<INPUT type="hidden" name="q"

	<?PHP
	if (isset($_GET['reset_2']))
	{
	    echo " value='" . $_GET['reset_2'] ."'";
	}
	else
		echo " value=''";
	echo ' /><input type="submit" style="display:block;margin-left:auto;margin-right:auto;" align="center" class="button_b" name="ResetPasswordForm" value="Reset"'; ?>
 	/>
	</FORM>
</DIV>

<?PHP
	$reset_2 = ob_get_clean();
	ob_start();
?>


<!--  Here are the 'reset_2 wrong' version of the page auth.php -->

<DIV class="reset_2">
	<H1>Reset</H1>

	<FORM  name="reset_2w" method="POST" action="reset_key.php">
		<HR>
	<LABEL id="icon" for="name"><I class="icon-envelope "></I></LABEL>
	<INPUT type="text" name="email" id="email" placeholder="Email" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="password" placeholder="Password" required/>
	<LABEL id="icon" for="name"><I class="icon-shield"></I></LABEL>
	<INPUT type="password" name="confirmpassword" id="name" placeholder="Confirm Password" required/>
	<INPUT type="hidden" name="q"

	<?PHP
	if (isset($_GET['reset_2w']))
	{
	    echo " value='" . $_GET['reset_2w'] ."'";
	}
	else
		echo " value=''";
	echo ' /><input type="submit" style="display:block;margin-left:auto;margin-right:auto;" align="center" class="button_b" name="ResetPasswordForm" value="Reset"'; ?>
 	/>

	</FORM>

</DIV>
<DIV class="wrong"> Notice that password must be containt at least 8 characters, letters MIN/MAJ and numbers !</DIV>


<!-- It is the selector who choose a version page created up there. -->

<?PHP
	$reset_2w = ob_get_clean();
	if (isset($_GET['signin']))
		echo $signin;
	else if (isset($_GET['signup']))
		echo $signup;
	else if (isset($_GET['wrong']))
		echo $wrong;
	else if (isset($_GET['reset_1']))
		echo $reset_1;
	else if (isset($_GET['reset_2']))
		echo $reset_2;
	else if (isset($_GET['reset_2w']))
		echo $reset_2w;
	else if (isset($_GET['logout']))
	{
		$_SESSION = array();
		session_destroy();
		echo $signup;
	}
	else
	 	echo $signup;
?>
</HTML>
