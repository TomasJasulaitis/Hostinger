<?php
// check if value was posted
if($_POST){
 
    // include database and object file
include_once 'config/database.php';
include_once 'models/website.php';
 
//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate website object
$website = new Website($db);
     
    // set product id to be deleted
    $website->id = $_POST['object_id'];
     echo  $website->id;
    // delete the product
    if($website->delete()){
        echo "Object was deleted.";
     
    }
    // if unable to delete the product
    else{
        echo "Unable to delete object.";
    }
}
?>