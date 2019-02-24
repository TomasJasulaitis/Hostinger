<?php
// check if value was posted
if($_POST){
    // include database and object file
    include_once 'config/database.php';
    include_once 'models/website.php';

  /*  if(isset($_GET['message']) && ($_GET['message'] != null)){
        switch($_GET['message']){
            case 'success':
                echo "<div class='alert alert-success'>Successfully deleted a website. </div>";
                break;
            case 'failure':
                echo "<div class='alert alert-danger'> Failed to delete a website. </div>";
                break;
            default:
                break;
        }
    }*/
    //Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate website object
    $website = new Website($db);
         
    // set product id to be deleted
    $website->id = $_POST['object_id'];
    // delete the product
    if($website->delete()){
     
        }

    }
?>