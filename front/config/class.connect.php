<?php
error_reporting(0);
class db {
	private $conn;
	private $host;
	private $user;
	private $password;
	private $baseName;
	private $port;
	private $Debug;
	
	function __construct($params=array()) {

	    //connect('localhost', 'whothe_wrdp5', '7OCcZY9dvkGo0o', 'whothe_wrdp5');

		$this->conn = false;
		$this->host = 'localhost'; //hostname
		$this->user = 'findadoc_admin'; //username
		$this->password = 'admin@12345'; //password
		$this->baseName = 'findadoc_findadoctor'; //name of your database
		$this->port = '3306';
		$this->debug = true;
		$this->connect();
	}

	function __destruct() {
		$this->disconnect();
	}

	function connect() {
		if (!$this->conn) {
			$this->conn = mysqli_connect($this->host, $this->user, $this->password);
			mysqli_select_db( $this->conn,$this->baseName);
			mysqli_set_charset($this->conn,"utf8");
			if (!$this->conn) {
				$this->status_fatal = true;
				echo 'Connection BDD failed';
				die();
			}
			else {
				$this->status_fatal = false;
			}
		}

		return $this->conn;
	}

	function disconnect() {
		if ($this->conn) {
			@pg_close($this->conn);
		}
	}

	function getOne($query) { // getOne function: when you need to select only 1 line in the database
		$cnx = $this->conn;
		if (!$cnx || $this->status_fatal) {
			echo 'GetOne -> Connection BDD failed';
			die();
		}

		$cur = @mysqli_query($cnx,$query);

		if ($cur == FALSE) {
			$errorMessage = @pg_last_error($cnx);
			$this->handleError($query, $errorMessage);
		}
		else {
			$this->Error=FALSE;
			$this->BadQuery="";
			$tmp = mysqli_fetch_array($cur, MYSQL_ASSOC);

			$return = $tmp;
		}

		@mysqli_free_result($cur);
		return $return;
	}

	function getAll($query) { // getAll function: when you need to select more than 1 line in the database
		$cnx = $this->conn;
		if (!$cnx || $this->status_fatal) {
			echo 'GetAll -> Connection BDD failed';
			die();
		}

		mysqli_query($cnx ,"SET NAMES 'utf8'");
		$cur = mysqli_query($cnx,$query);
		$return = array();

		while($data = mysqli_fetch_assoc($cur)) {
			array_push($return, $data);
		}

		return $return;
	}

	function execute($query,$use_slave=false){//execute function: to use INSERT or UPDATE
		$cnx = $this->conn;
		if (!$cnx||$this->status_fatal) {
			return null;
		}

		$cur = mysqli_query($cnx,$query);

		if ($cur == FALSE) {

			 $ErrorMessage = mysqli_error($cnx);
			 $this->handleError($query, $ErrorMessage);
		}
		else {

			$this->Error=FALSE;
			$this->BadQuery="";
			$this->NumRows =@mysqli_affected_rows();
			return;
		}
		@mysqli_free_result($cur);
	}

	function handleError($query, $str_erreur) {
		$this->Error = TRUE;
		$this->BadQuery = $query;
		if ($this->Debug) {
			echo "Query : ".$query."<br>";
			echo "Error : ".$str_erreur."<br>";
		}
	}


  function getCoordinates($address)
  {
     $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern
     $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
     $response = file_get_contents($url);
     $json = json_decode($response,TRUE); //generate array object from the response from the web
     return ($json['results'][0]['geometry']['location']['lat'].",".$json['results'][0]['geometry']['location']['lng']);
 }


function getCoordinates1($address)
 {
  $url = 'https://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyDKR37cS_99owrx2OFYJOozZkoIbv-N248';
  $curl = curl_init();curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HEADER, false);
  $data = curl_exec($curl);
  curl_close($curl);
  $output = json_decode($data,TRUE);
  //print_r($output);
//return($output['results'][0]['geometry']['location']['lat']."=>".$output['results'][0]['geometry']['location']['lng']);
return($output);
//  echo "<pre>";print_r($output);
 }

  public function search($q)
  {
        //echo $q;
    	$cnx1 = $this->conn;
		if (!$cnx1 || $this->status_fatal) {
			echo 'GetAll -> Connection BDD failed';
			die();
		}
		mysqli_query($cnx1,"SET NAMES 'utf8'");
		$cur = mysqli_query($cnx1,$q);
	 	$return = array();
		while($data = mysqli_fetch_assoc($cur))
		{
			array_push($return, $data);
		}
		return $return;
  }


}
