<?php
$url_path = "/camagru";

//Option for log request : SW -> log request SHOW, SELECT and INSERT INTO, UPDATE  RW-> Only INSERT INTO, UPDATE
$log_request = "RW";

//Show all request 1 -> show all  0 -> show nothing
$debug_req = 0;

// DB conf
$hostname = "localhost";
$db_name = "camagru";
$username = "root";
$password = "root";
$option = array(
    // Activation PDO exceptions:
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_TIMEOUT => 10
);
?>
