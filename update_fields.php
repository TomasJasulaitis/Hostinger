<?php
$page_title = "Force update";

 
// include database and object files
include_once "layout_header.php";
include_once 'config/database.php';
include_once 'models/update.php';
 
// get database connection
$database = new Database();
$db = $database->connect();
 
// prepare objects
$update = new Update($db);
 
if($update->update_for_mailer()){
        echo "success";
        echo "<div class='right-button-margin'>
               <a href='index.php' class='btn btn-default pull-right'>
               <span class='glyphicon glyphicon-list'></span> Back to the list
               </a>
</div>";

          exit();
    }
    // if unable to create the website, tell the user
    else{
      echo "failed";
      echo "<div class='right-button-margin'>
               <a href='index.php' class='btn btn-default pull-right'>
               <span class='glyphicon glyphicon-list'></span> Back to the list
               </a>
</div>";

        exit();
}
?>