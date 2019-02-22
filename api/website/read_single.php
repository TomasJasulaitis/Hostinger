<?php

$page_title = "Read single website";


// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once "../../layout_header.php";
include_once '../../config/Database.php';
include_once '../../models/Website.php';
 
// get database connection
$database = new Database();
$db = $database->connect();
 
// prepare objects
$website = new Website($db);
 
// set ID property of product to be read
$website->id = $id;
 
// read the details of product to be read
$website->read_single();

// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='../../index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
echo "</div>";

// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>Url</td>";
        echo "<td>{$website->url}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Nofollow</td>";
        echo "<td>{$website->nofollow}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Time checked</td>";
        echo "<td>{$website->time_checked}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Url Host</td>";
        echo "<td>{$website->url_host}</td>";
    echo "</tr>";
 
 
echo "</table>";
 
// set footer
include_once "../../layout_footer.php";
?>

