<?php

//title of the page
$page_title = "Website creation";

include_once "layout_header.php";
include_once 'config/database.php';
include_once 'models/website.php';

//checking for messages from form completion
if(isset($_GET['message']) && ($_GET['message'] != null)){
    switch($_GET['message']){
        case 'success':
            echo "<div class='alert alert-success'>Successfully created a new website. </div>";
            break;
        case 'failure':
            echo "<div class='alert alert-danger'> Failed to created a new website. </div>";
            break;
        case 'empty':
            echo "<div class='alert alert-danger'> Please fill in all the fields. </div>";
            break;
        default: 
            break;
    }
}

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();
//Instantiate website object
$website = new Website($db);

//checks if anything was writen in the forms
if($_POST){

        // set website property values
    $website->url = $_POST['url'];
    $website->url_host =$_POST['url_host'];

    //going to scrap website
    if(empty($_POST['url'])||empty($_POST['url_host'])){
        header("Location:  create.php?message=empty");
        exit();
    }
    else{
        // create the website
        if($website->create()){
              header("Location: create.php?message=success");
              exit();
        }
        // if unable to create the website, tell the user
        else{
            header("Location: create.php?message=failure");
            exit();
        }
    }
}

include_once "layout_footer.php";
?>

<!-- PHP post code will be here -->
 
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover max-width: 50%'>
 
        <tr>
            <th>Website you want to check in</th>
            <th><input type='text' name='url' class='form-control' /></th>
        </tr>
 
        <tr>
            <th>Website url you want to check for</th>
            <th><input type='text' name='url_host' class='form-control' /></th>
        </tr>
            <th>
            	<div class='right-button-margin'>
            	<a href='index.php' class='btn btn-default'>
                <span class='glyphicon glyphicon-list'></span> Back to the list 
            	</a>
            </div>
            </th>
            <th>
                <button type="submit" class="btn btn-primary">Create</button>
            </th>
        </tr>
    </table>
</form>

