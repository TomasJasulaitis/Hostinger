<?php

$page_title = "Read websites";

include_once "../../layout_header.php";
include_once '../../config/Database.php';
include_once '../../models/Website.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate website object
$website = new Website($db);

//website query
$result = $website->read();


echo "<select class='form-control' name='website_id'>";
    echo "<option>Select website...</option>";
 
    while ($row_website = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row_website);
        echo "<option value='{$id}'>{$url}</option>";
    }
 
echo "</select>";

include_once "../../layout_footer.php";
?>

