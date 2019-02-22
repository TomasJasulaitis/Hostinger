<?php

$page_title = "Create website";

include_once "../../layout_header.php";
include_once '../../config/database.php';
include_once '../../models/website.php';
include_once '../../simple_html_dom/simple_html_dom.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();
//Instantiate website object
$website = new Website($db);

// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
 

 $main = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
 $main .=$_SERVER['SERVER_NAME'].":8080";   //PORT JUST FOR DEVELOPMENT
 $main .= $_SERVER['REQUEST_URI'];

 $full_main = dirname(dirname(dirname($main)));

    // set product property values
$website->url = $_POST['url'];
$website->url_host =$_POST['url_host'];
$new1 = str_replace('/','\/',$website->url_host);
$new2 = str_replace('.','\.',$new1);
$new3 = str_replace('-','\-',$new2);

//going to scrap website
if(empty($_POST['url'])||empty($_POST['url_host'])){
header("Location: $full_main/api/website/create.php?message=empty");
exit();
}
else{
$html = file_get_html($website->url);

//finds <a tag
foreach($html->find('a') as $element){		
	if(preg_match("/$new3/", $element, $match)){
		$website->nofollow  = false;
     	if(preg_match("/nofollow/", $element)){
     		$website->nofollow = true;
 		}
 	
 
    // create the website
    if($website->create()){
        echo "<div class='alert alert-success'>Website was created.</div>";
        header("Location: $full_main/api/website/create.php?message=success");
      
    }
 
    // if unable to create the website, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create Website.</div>";
        header("Location: $full_main/api/website/create.php");
        exit();
    }
  }

}
}
}




include_once "../../layout_footer.php";
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
            	<a href='../../index.php' class='btn btn-default'>
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

