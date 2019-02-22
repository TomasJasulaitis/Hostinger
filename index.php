<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

// set page header
$page_title = "Read websites";
include_once "layout_header.php";

// Include the php dom parser    
include_once 'simple_html_dom/simple_html_dom.php';
include_once 'config/Database.php';
include_once 'models/Website.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate website object
$website = new Website($db);

echo "<div class='right-button-margin'>";
    echo "<a href='api/website/create.php' class='btn btn-default pull-right'>Create website</a>";
echo "</div>";


// query products
$stmt = $website->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// display the products if there are any
if($num>0){
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Url</th>";
            echo "<th>No follow</th>";
            echo "<th>Time checked/th>";
            echo "<th>Url host</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td>{$url}</td>";
                echo "<td>{$nofollow}</td>";
                echo "<td>{$time_checked}</td>";
                echo "<td>{$url_host}</td>";
 
             echo "<td>";
                    // read, edit and delete buttons
 echo "<a href='api/website/read_single.php?id={$id}' class='btn btn-primary left-margin'>
    <span class='glyphicon glyphicon-list'></span> Read
</a>
 
<a delete-id='{$id}' class='btn btn-danger delete-object'>
    <span class='glyphicon glyphicon-remove'></span> Delete
</a>";
                echo "</td>";
 			
            echo "</tr>";	
 			
        }
echo "</table>";
 
   // the page where this paging is used
$page_url = "index.php?";
 
// count all products in the database to calculate total pages
$total_rows = $website->countAll();
 
// paging buttons here
include_once 'api/website/paging.php';
}
 
// tell the user there are no products
else{
    echo "<div class='alert alert-info'>No products found.</div>";
}
 
include_once "layout_footer.php";
?>