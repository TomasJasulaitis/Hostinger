<?php
// core.php holds pagination variables
include_once 'config/core.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'models/website.php';
 
// instantiate database and website object
$database = new Database();
$db = $database->connect();
 
$website = new Website($db);
 
// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';
 

$page_title = "<font color='#84ac39'>You searched for \"{$search_term}\" </font>";
include_once "layout_header.php";
 
// query websites
$stmt = $website->search($search_term, $from_record_num, $records_per_page);
// specify the page where paging is used
$page_url="search.php?s={$search_term}&";
 
// count total rows - used for pagination
$total_rows=$website->count_all_by_search($search_term);

//back to the main page link
 echo "<div class='right-button-margin'>";
                echo "<a href='index.php' class='btn btn-default pull-right'>";
                echo "<span class='glyphicon glyphicon-list'></span> Back to the list" ;
                echo "</a>";
 echo "</div>";


include_once "read_template.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
?>