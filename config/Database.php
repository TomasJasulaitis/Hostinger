<?php

class Database {

	//DB params
	private $DB_SERVER    = 'localhost';
	//private $DB_NAME       = 'tomjas3';
	//private $DB_USERNAME   = 'tomjas3';
	//private $DB_PASSWORD   = 'fooShahcaipheeL9';
	private $DB_NAME       = 'crawler';
	private $DB_USERNAME   = 'root';
	private $DB_PASSWORD   = '';
	private $conn;


	//DB connect
	public function connect(){
		$this->conn = null;

		try{
			$this->conn = new PDO('mysql:host=' . $this->DB_SERVER . ';dbname=' . $this->DB_NAME,
			 $this->DB_USERNAME, $this->DB_PASSWORD);
			//echo 'Connection succesfull';
		}catch(PDOException $e){
			echo 'Connection error: ' . $e->getMessage();
		}
		return $this->conn;
	}


}

?>
