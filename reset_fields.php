<?php
$page_title = "Reset fields";

 
// include database and object files
include_once "layout_header.php";
include_once 'config/database.php';
include_once 'models/website.php';
 
// get database connection
$database = new Database();
$db = $database->connect();
 

// prepare objects
$website = new website($db);

if($website->reset_checked()){
        header("Location: index.php?message=success");
    }
    // if unable to create the website, tell the user
    else{
     header("Location: index.php?message=failure");
}
?>