<?php
//disabled display of SID
// ini_set('session.use_trans_sid', false);

//Initiate the session

if(!isset($_SESSION))
  session_start();
// show all error
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Include Connection class
require_once("connection/Connection.class.php");

// Include personal conf for DB and site
require_once("config/config.php");

//Instantiate the PDO object for connection
$PDO = new Connection($hostname, $db_name, $username, $password, $log_request, $debug_req, $option);
?>
