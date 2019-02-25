<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once ($_SERVER['DOCUMENT_ROOT'].'/hostinger/crawler/PHPMailer/src/Exception.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/hostinger/crawler/PHPMailer/src/PHPMailer.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/hostinger/crawler/PHPMailer/src/SMTP.php');
include_once 'config/database.php';
include_once 'models/website.php';
include_once 'models/update.php';

$database = new Database();
$db = $database->connect();

$updater = new Update($db);
$website = new Website($db);

//goes through all websites and checks for url that was specified
$updater->update_for_mailer(); 
//returns count of all the entries with checked as true
$rows_checked = $website->count_all_rows_checked();
//returns count all the rows in database
$rows_in_db = $website->count_all();
//returns count of all the entries with nofollow as true
$nofollow_links = $website->count_all_rows_nofollow();
//returns count of all the entries with contains as false
$missing_links = $website->count_all_rows_missing_link();

//if all rows are checked in DB
if($rows_checked == $rows_in_db){

$message   = "$rows_checked URLs checked, $missing_links backlinks not found, $nofollow_links found with NOFOLLOW: <br>
";

$stmt = $website->get_no_link();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   extract($row);
   $message .= $url . "<br>";
}

$stmt = $website->get_no_nofollow();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   extract($row);
   $message .= $url . " ---NOFOLLOW--<br>";
}
$toAddress = "phexsprays@gmail.com"; //To whom you are sending the mail.
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth    = true;
$mail->Host        = "smtp.gmail.com";
$mail->Port        = 587;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->IsHTML(true);
$mail->Username = "phexsprays@gmail.com"; 
$mail->Password = 'ggusllgdflqbcjuh'; 
$mail->SMTPSecure ='tls';
$mail->SetFrom("testreddragonemail@example.com");
$mail->Subject = "Crawler information"; 
$mail->Body    = $message;
$mail->AddAddress($toAddress);
if (!$mail->Send()) {
     echo "Mailer Error: " . $mail->ErrorInfo;

} else {
    echo "<h1> Mail sent succesfully </h1>";
     echo "<div class='right-button-margin'>";
                echo "<a href='index.php' class='btn btn-default pull-right'>";
                echo "<span class='glyphicon glyphicon-list'></span> Back to the list" ;
                echo "</a>";
 echo "</div>";
    //resets checked to false of all the entries 
    $website->reset_checked();
}
}


?>