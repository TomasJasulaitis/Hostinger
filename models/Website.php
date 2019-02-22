<?php 
 	class Website{
 		//DB stuff
 		private $conn;
 		private $table = 'website';

 		//Website properties
 		public $id;
 		public $url;
 		public $nofollow;
 		public $time_checked;
 		public $url_host;

 		//Contruct with DB
 		public function __construct($db){
 			$this->conn = $db;
 		}

 		//get websites
 		public function read() {
 		//create query
 			$query = 'SELECT
 			id,
 			url,
 			nofollow,
 			time_checked,
 			url_host
 		FROM ' . $this->table . '
 		ORDER by url';


 		//prepare query
 		$stmt = $this->conn->prepare($query);
 		//execute query
 		$stmt->execute();

 		return $stmt;
 	}

 	public function read_single() {
 		$query = 'SELECT
 			url,
 			nofollow,
 			time_checked,
 			url_host
 		FROM ' . $this->table . '
 		WHERE 
 			id = ?
 		LIMIT 0,1';

 		//prepare query
 		$stmt = $this->conn->prepare($query);

 		//bind ID, Not first, but one.
 		$stmt->bindParam(1, $this->id);

 		//execute query
 		$stmt->execute();

 		$row = $stmt->fetch(PDO::FETCH_ASSOC);

 		//set properties
 		$this->url = $row['url'];
 		$this->nofollow = $row['nofollow'];
 		$this->time_checked = $row['time_checked'];
 		$this->url_host = $row['url_host'];
 	}

 	public function create(){
 		$query = 'INSERT INTO ' . $this->table . '
 		SET
 		 			 url = :url,
 					 nofollow = :nofollow,
 					 url_host = :url_host';

 			$this->url = htmlspecialchars(strip_tags($this->url));
 			$this->nofollow = htmlspecialchars(strip_tags($this->nofollow));
 			$this->url_host = htmlspecialchars(strip_tags($this->url_host));


	        $stmt = $this->conn->prepare($query);
 			$stmt->bindParam(':url', $this->url);
 		    $stmt->bindParam(':nofollow', $this->nofollow);
 		    $stmt->bindParam(':url_host', $this->url_host);
 	
 		     if($stmt->execute()){
 		    	return true;
 		    }
 		    else{
 		    	//print error if something goes wrong
 		    	//printf("Error: %s.\n", $stmt->error);
 		    	return false;

 		    }
 		}

 	public function update(){
 		//create a query
 		$query = '
 			UPDATE ' . $this->table . '
 			SET 
 				nofollow = :nofollow,
 	
 				url_host = :url_host
 			WHERE 
 				url = :url';
 		
 		$this->nofollow = htmlspecialchars(strip_tags($this->nofollow));
 		//$this->time_checked = htmlspecialchars(strip_tags($this->time_checked));
 		$this->url_host = htmlspecialchars(strip_tags($this->url_host));
 		$this->url = htmlspecialchars(strip_tags($this->url));

	    $stmt = $this->conn->prepare($query);
 		$stmt->bindParam(':nofollow', $this->nofollow);
 		//$stmt->bindParam(':time_checked', $this->time_checked);
 		$stmt->bindParam(':url_host', $this->url_host);
 		$stmt->bindParam(':url', $this->url);

 		if($stmt->execute()){
 		    	return true;
 		    }
 		else{
 		    	//print error if something goes wrong
 		    	//printf("Error: %s.\n", $stmt->error);
 		    	return false;
 		}
 	}

 	function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
    			id,
    			url,
                nofollow,
 				time_checked,
 				url_host
            FROM
                " . $this->table . "
            ORDER BY
                url ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
}

// used for paging products
public function countAll(){
 
    $query = "SELECT id FROM " . $this->table . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    $num = $stmt->rowCount();
 
    return $num;
}
}


 

?>