<?php

// include database and object files
include_once 'config/database.php';
include_once 'models/website.php';
include_once 'simple_html_dom/simple_html_dom.php';
class Update{
	//DB stuff
	private $conn;

//Contruct with DB
public function __construct($db){
	$this->conn = $db;
}

function update_for_mailer(){
// get database connection
$database = new Database();
$db = $database->connect();
$website = new Website($db);
$stmt = $website->read_all_for_daily_task();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

 	$website->id = $row['id'];
 	$website->url = $row['url'];
 	$website->url_host = $row['url_host'];

	$new_host1 = str_replace('/','\/',$website->url_host);
	$new_host2 = str_replace('.','\.',$new_host1);
	$new_host3 = str_replace('-','\-',$new_host2);
	$new_host4 = str_replace(':','\:',$new_host3);
	$new_host5 = "/$new_host4/";
	$html = file_get_html($website->url);
	$website->contains_link = false;
	$website->nofollow = false;
	$website->checked = false;

	foreach($html->find('a') as $element){
		if(preg_match($new_host5, $element)){
			$website->contains_link = true;
			if(preg_match("/nofollow/", $element)){
				$website->nofollow = true;
			}
		}
	$website->time_checked = date("Y-m-d H:i:s");
	$website->checked = true;
	}
 	if($website->update()){
       //header("Location: update.php?message=success");
  	}
 	else{
  	  // header("Location: update.php?message=failure");
 	}
}
}
}

?>