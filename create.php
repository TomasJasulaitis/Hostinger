<?php

$page_title = "Create website";

include_once "layout_header.php";
include_once 'config/database.php';
include_once 'models/website.php';


//Instantiate DB and connect
$database = new Database();
$db = $database->connect();
//Instantiate website object
$website = new Website($db);
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){

    // set product property values
$website->url = $_POST['url'];
$website->url_host =$_POST['url_host'];

//going to scrap website
if(empty($_POST['url'])||empty($_POST['url_host'])){
header("Location: create.php?message=empty");
exit();
}
else{

    // create the website
    if($website->create()){
        echo "<div class='alert alert-success'>Website was created.</div>";
        header("Location: create.php?message=success");
      
    }
 
    // if unable to create the website, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create Website.</div>";
        header("Location: website/create.php");
        exit();
    }
}
}





include_once "layout_footer.php";
?>

<!-- PHP post code will be here -->
 
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Url you want to check in</td>
            <td><input type='text' name='url' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Url you want to check for</td>
            <td><input type='text' name='url_host' class='form-control' /></td>
        </tr>
            <td>
            	<div class='right-button-margin'>
            	<a href='index.php' class='btn btn-default'>
                <span class='glyphicon glyphicon-list'></span> Back to the list 
            	</a>
            </div>
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
    </table>
</form>

