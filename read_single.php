<?php

$page_title = "Reading single website";


// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once "layout_header.php";
include_once 'config/database.php';
include_once 'models/website.php';
 
// get database connection
$database = new Database();
$db = $database->connect();
 
// prepare objects
$website = new Website($db);
 
// set ID property of website to be read
$website->id = $id;
 
// read the details of website to be read
$website->read_single();
 ?>
<!DOCTYPE html>

<style>
table{
    background-color: lightgrey;
}
</style>
<?php

//back to the start
echo "<div class='right-button-margin'>
               <a href='index.php' class='btn btn-default pull-right'>
               <span class='glyphicon glyphicon-list'></span> Back to the list
               </a>
</div>";



// HTML table for displaying website details
echo "<table class='table table-hover table-responsive table-bordered table-striped'>
    <tr>
       <td>Website</td>
       <td>{$website->url}</td>
   </tr>
 
   <tr>
       <td>Nofollow</td>
       <td>{$website->nofollow}</td>
   </tr>
 
   <tr>
       <td>Time checked</td>
       <td>{$website->time_checked}</td>
   </tr>

   <tr>
       <td>Host website</td>
       <td>{$website->url_host}</td>
   </tr>

 <tr>
       <td>Contains link</td>
       <td>{$website->contains_link}</td>
   </tr>

    <tr>
       <td>Checked</td>
       <td>{$website->checked}</td>
   </tr>
 
</table>";
 
// set footer
include_once "layout_footer.php";
?>

