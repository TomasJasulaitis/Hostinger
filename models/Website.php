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
	public $contains_link;
	public $checked;

//Contruct with DB
public function __construct($db){
	$this->conn = $db;
}

public function read_single() {
 	$query = "
 	SELECT
    	url,
        nofollow,
 		time_checked,
 		url_host,
 		contains_link,
 		checked
 	FROM 
 		" . $this->table . "
 	WHERE 
 		id = ?
 	LIMIT 0,1";

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
	$this->contains_link = $row['contains_link'];
	$this->checked = $row['checked'];

	return $stmt;
 	}

//create new website o
public function create(){
	$query = "
	INSERT INTO 
		" . $this->table . "
	SET
		url = :url,
		nofollow = :nofollow,
		url_host = :url_host,
		checked = false,
		contains_link = false";

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

public function read_all($from_record_num, $records_per_page){
    $query = "
    SELECT
    	id,
    	url,
        nofollow,
 		time_checked,
 		url_host,
 		contains_link,
 		checked
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

public function read_all_for_daily_task(){
    $query = "SELECT
    			id,
    			url,
 				url_host
            FROM
                " . $this->table . "
            WHERE CHECKED = 0
       ";
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 	
    return $stmt;
}

// delete the website
public function delete(){
 
    $query = "
    DELETE FROM 
   		" . $this->table . "
    WHERE
    	id = ?";
     
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
 
    $stmt->execute();
    return $stmt;
}

// used for paging products
public function count_all(){
 
    $query = "
    SELECT 
    	id 
    FROM 
    	" . $this->table . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    $num = $stmt->rowCount();
 
    return $num;
}
// read products by search term
public function search($search_term, $from_record_num, $records_per_page){
 
    // select query
    $query = "
    		SELECT
    			id,
    			url,
                nofollow,
 				time_checked,
 				url_host,
 				contains_link,
 				checked
            FROM
                " . $this->table . " 
            WHERE
                url LIKE ? OR url_host LIKE ?
            ORDER BY
                url ASC
            LIMIT
                ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $search_term = "%{$search_term}%";
    $stmt->bindParam(1, $search_term);
    $stmt->bindParam(2, $search_term);
    $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 	
    // return values from database
    return $stmt;
}
 
public function count_all_by_search($search_term){
 
    // select query
    $query = 'SELECT
                COUNT(*) as total_rows
            FROM
                ' . $this->table . '
            WHERE
                url LIKE ?';
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $search_term = "%{$search_term}%";
    $stmt->bindParam(1, $search_term);
 
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function count_all_rows_checked(){
    // select query
    $query = 'SELECT
                COUNT(*) as total_rows
            FROM
                ' . $this->table . '
            WHERE
                checked = 1';
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_rows'];
}

public function count_all_rows_nofollow(){
    // select query
    $query = 'SELECT
                COUNT(*) as total_rows
            FROM
                ' . $this->table . '
            WHERE
                nofollow = 1';
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_rows'];
}

public function count_all_rows_missing_link(){
    // select query
    $query = 'SELECT
                COUNT(*) as total_rows
            FROM
                ' . $this->table . '
            WHERE
                contains_link = 0 AND
                time_checked > UNIX_TIMESTAMP(NOW() - INTERVAL 25 HOUR)';
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_rows'];
}

public function update(){
	$query = "UPDATE " . $this->table . "
 		SET
 			nofollow = :nofollow,
 			time_checked = :time_checked,
 			contains_link = :contains_link,
 			checked = :checked
 		WHERE 
 			id = :id
 		";
 	$this->id = htmlspecialchars(strip_tags($this->id));
 	$this->nofollow = htmlspecialchars(strip_tags($this->nofollow));
 	$this->time_checked = htmlspecialchars(strip_tags($this->time_checked));
 	$this->contains_link = htmlspecialchars(strip_tags($this->contains_link));
 	$this->checked = htmlspecialchars(strip_tags($this->checked));


	$stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $this->id);
 	$stmt->bindParam(':nofollow', $this->nofollow);
 	$stmt->bindParam(':time_checked', $this->time_checked);
 	$stmt->bindParam(':contains_link', $this->contains_link);
 	$stmt->bindParam(':checked', $this->checked);


 	if($stmt->execute()){
 	return true;
	 }
	else{
 	return false;
 	}
}

public function reset_checked(){

	$query = "UPDATE website
 		SET
 			checked = 0
 		WHERE 
 			1
 		";
	$stmt = $this->conn->prepare($query);
  
 	if($stmt->execute()){
 	return true;
 	}
 	else{
 	return false;
 	}
}

public function get_no_link(){
 
    // select query
    $query = "
    		SELECT
    			url
            FROM
                " . $this->table . " 
            WHERE
                contains_link = 0
            ORDER BY
                url ASC"; 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // execute query
    $stmt->execute();
 	
    // return values from database
    return $stmt;
}

public function get_no_nofollow(){
 
    // select query
    $query = "
    		SELECT
    			url
            FROM
                " . $this->table . " 
            WHERE
                nofollow = 1
            ORDER BY
                url ASC"; 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // execute query
    $stmt->execute();
 	
    // return values from database
    return $stmt;
}
}

?>