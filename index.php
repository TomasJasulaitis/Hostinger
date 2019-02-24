<?php

// core.php holds pagination variables
include_once 'config/core.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'models/website.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->connect();
 
$website = new Website($db);
 
$page_title = "Main page";
include_once "layout_header.php";
 
// query products
$stmt = $website->read_all($from_record_num, $records_per_page);
// specify the page where paging is used
$page_url = "index.php?";
 
// count total rows - used for pagination
$total_rows=$website->count_all();
 
// read_template.php controls how the product list will be rendered
include_once "read_template.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
?>