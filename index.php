<?php
require("config/database.php");

//////////////////////////////////  CHECK AUTHENTICATE  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// If the auth form is POST verif username and password
if (isset($_POST['signin']) && !isset($_SESSION['auth']['connect']))
{
  $passw_hash = hash("sha512", $_POST['password']);
  $params = array('username' => $PDO->check($_POST['username']), 'password' => $passw_hash);

  //$passwd = $PDO->prepare("SELECT password FROM users WHERE username = :username", array(
  //	'username' => $passw_hash
  //));

  $sql = "SELECT users.id, username, email
  FROM users
  WHERE username = :username
  AND password = :password";

  $result = $PDO->prepare($sql, $params)->fetch(PDO::FETCH_ASSOC);

  // if the request return a value
  if (!empty($result))
  {
    $date = gmdate("Y-m-d h:i:s");
    $_SESSION['auth']['username'] = $result['username'];
    $_SESSION['auth']['email'] = $result['email'];
    $_SESSION['auth']['id'] = $result['id'];
    $_SESSION['auth']['last_signin_date'] = $date;

    $_SESSION['auth']['connect'] = 1;
    $PDO->prepare("UPDATE users SET last_signin_date = :last_signin_date WHERE id = :id", array(
      'last_signin_date' => $date,
      'id'   => $result['id']));
    }
    else // else if the request return null go to auth page
    header("Location: $url_path/auth.php?signin?option=badlogin");
    //TODO : when auth is wrong display error message on main page

  }// If user in signup check if username already exist and if 2 password matches
  else if (isset($_POST['signup']) && !isset($_SESSION['auth']['connect']) && preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
  {
    $date = gmdate("Y-m-d h:i:s");
    $passwd_hash = hash("sha512", $_POST['password']);

    // Check if username is empty or already exist
    if (!empty($_POST['username']) || empty($PDO->query(
    "SELECT username FROM users WHERE username = '" . $_POST['username'] . "'")))
    {
      if (!empty($_POST['password']) && $_POST['password'] === $_POST['retry_password'])
      {
        if ($id = $PDO->req_last_insert("prepare", "INSERT INTO users (email, username, password, last_signin_date) VALUES(:email, :username, :password, :last_signin_date)",
        array(
          'email'	   => $_POST['email'],
          'username' => $_POST['username'],
          'password' => $passwd_hash,
          'last_signin_date' => $date
        )))
        {
          $_SESSION['auth']['username'] = $_POST['username'];
          $_SESSION['auth']['email'] = $_POST['email'];
          $_SESSION['auth']['id'] = $id;
          $_SESSION['auth']['last_signin_date'] = $date;
          $_SESSION['auth']['connect'] = 1;
          $PDO->prepare("UPDATE users SET last_signin_date = :date WHERE username = :username", array(
            'date' => $date,
            'username'   => $_POST['username']));


            $us_nm  = $_POST['username'];
            $dest   = $_POST['email'];
            $body   = "Hello $us_nm ! Thank you for subscribing to the plateform Camagru. We hope you're enjoyed by its awesome features !";
            $sujet  = "Welcome on Camagru !";
            $header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
            $header.= "Reply-to: \"Camagru\" <camagru@42.fr>" . "\r\n";
            $header.= "MIME-Version: 1.0" . "\r\n";
            $header.= 'X-Mailer: PHP/' . phpversion();

            mail($dest, $sujet, $body, $header);
            header("Location: $url_path/camagru.php");
            exit();
          }
        }
      }
      else
      {
        header("Location: $url_path/auth.php");
        exit();
      }
    }
    if (isset($_SESSION['auth']['connect']))
    {
      header("Location: $url_path/camagru.php");
      exit();
    }
    else
    {
      if (!empty($_POST['password']) && (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $_POST['password']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
      {
        header("Location: $url_path/auth.php?wrong");
        exit();
      }
      header("Location: $url_path/auth.php");
      exit();
    }
    ?>
