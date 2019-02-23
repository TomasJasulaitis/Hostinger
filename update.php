<?php

// get ID of the product to be read
 
// include database and object files
include_once 'config/database.php';
include_once 'models/website.php';
include_once 'simple_html_dom/simple_html_dom.php';
class Update{
 		//DB stuff
 		private $conn;
 		private $table = 'website';


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

$new1 = str_replace('/','\/',$website->url_host);
$new2 = str_replace('.','\.',$new1);
$new3 = str_replace('-','\-',$new2);
$new3 = str_replace(':','\:',$new2);
$new4 = "/$new3/";
$html = file_get_html($website->url);
$website->contains_link = false;
$website->nofollow = false;
$website->checked = false;

//$regex = '#<a[^>]*>(.*)</a[^v]*>#si';
foreach($html->find('a') as $element){
	if(preg_match($new4, $element)){
		$website->contains_link = true;
		if(preg_match("/nofollow/", $element)){
			$website->nofollow = true;
		}
	}
	$website->time_checked = date("Y-m-d H:i:s");
	$website->checked = true;
}
 if($website->update()){
       header("Location: update.php?message=success");
  }
  else{
  	   header("Location: update.php?message=failure");
  }
 }
}
}

 		?>