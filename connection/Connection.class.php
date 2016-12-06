<?php
class Connection
{
		private $log_request;
		private $debug_req;

		// PDO object for execute request
		private static $PDO;

		// connection to the database
		public function __construct($hostname, $db_name, $username, $password, $log_request, $debug_req, $option = NULL)
		{
				try
				{
						self::$PDO = new PDO('mysql:host=' . $hostname . ';dbname=' . $db_name . ";charset=utf8",
										$username,
										$password,
										$option);
				}
				catch (Exception $e)
				{
						echo "Can't connect to mysql<br>";
						trigger_error($e->getMessage(), E_USER_ERROR);
				}
				$this->log_request = $log_request;
				$this->debug_req = $debug_req;

				return (self::$PDO);
		}

		public function prepare($request, $params)
		{
				// Check return of execute()
				if (($req = self::$PDO->prepare($request)) == FALSE)
				{
						echo "Error in the request : " . $request . "<br>";
						$this->log_request(self::$PDO, $request, "FALSE");
						exit;
				}

				try
				{
						$this->log_request(self::$PDO, $request, "INI");
						$req->execute($params);
				}
				catch (Exception $e)
				{
						$this->log_request(self::$PDO, $request, "FALSE");
						trigger_error($e->getMessage(), E_USER_ERROR);
						exit;
				}
				return ($req);
		}

		// Execute or query the request and return the result of the request + the last_insert_id
		public function req_last_insert($request_option, $request, $params = NULL)
		{
				// Escape criticals char
				//$request = $this->check($request);
				if ($request_option == "query")
				{
						if (($result = self::$PDO->query($request)) == FALSE)
						{
								echo "Error in the request : " . $request . "<br>";
								$this->log_request(self::$PDO, $request, "FALSE");
								exit;
						}
				}
				else if ($request_option == "prepare")
				{
						$req = self::$PDO->prepare($request);
						if (($req->execute($params)) == FALSE)
						{
								echo "Error in the request : " . $request . "<br>";
								$this->log_request(self::$PDO, $request, "FALSE");
								exit;
						}
				}

				$last_id = self::$PDO->lastInsertId();
				return ($last_id);
		}

		// to execute a request to the database and log the request in a sql table
		public function query($request)
		{
				try
				{
						$result = self::$PDO->query($request);
				}
				catch (Exception $e)
				{
						$this->log_request(self::$PDO, $request, "FALSE");
						trigger_error($e->getMessage(), E_USER_ERROR);
						exit;
				}

				return $result;
		}

		//Get back the request to write it in the DB
		public function log_request($PDO, $request, $status)
		{
				if ($this->log_request == "SW")
				{
						if (strstr($request, "SELECT") != FALSE || (strstr($request, "SHOW") != FALSE))
						{
								try
								{
									$request = addslashes($request);
									$sql = "INSERT INTO log_request_sw (username, request, server_uri, date, status) VALUES (:username, :request, :server_uri, :date, :status)";
									$PDO->prepare($sql, array(
										"username" => $_SESSION['auth']['username'],
										"request" => $request,
										"server_uri" => $_SERVER['REQUEST_URI'],
										"date" => gmdate("Y-m-d H:m:s"),
										"status" => $status
									));
								}
								catch (Exception $e)
								{
										trigger_error($message->getMessage(), E_USER_ERROR);
								}
						}
				}

				if ($this->debug_req == 1)
						echo $request . "<br>";// . $sql . "<br>"; //Print the $sql (to debug)
				// for log SELECT request AND INSERT INTO or UPDATE

				if (strstr($request, "INSERT INTO") != FALSE || strstr($request, "UPDATE") != FALSE || strstr($request, "DELETE") != FALSE)
				{
						try
						{
								if (isset($_SESSION['auth']['username']))
									$username = $_SESSION['auth']['username'];
								else {
									$username = "no_user_logged";
								}
								$request = addslashes($request);
								$sql = "INSERT INTO log_request_wr (username, request, server_uri, date, status) VALUES (:username, :request, :server_uri, :date, :status)";
								$PDO->prepare($sql, array(
										"username" => $username,
										"request" => $request,
										"server_uri" => $_SERVER['REQUEST_URI'],
										"date" => gmdate("Y-m-d H:m:s"),
										"status" => $status
								));
						}
						catch (Exception $e)
						{
								trigger_error($e->getMessage(), E_USER_ERROR);
						}
				}
		}

		//Data enter going
		public function check($string)
		{
				$string = addslashes($string);
				//$string = str_replace();
				return ($string);
		}
}
