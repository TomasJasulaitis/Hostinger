<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src/Exception.php';
require 'PHPMailer\src/PHPMailer.php';
require 'PHPMailer\src/SMTP.php';
include_once 'config/database.php';
include_once 'models/website.php';
include_once 'models/update.php';

$database = new Database();
$db = $database->connect();

$updater = new Update($db);
$website = new Website($db);

$updater->update_for_mailer();
$rows_checked = $website->count_all_rows_checked();
$rows_in_db = $website->count_all_rows();
$nofollow_links = $website->count_all_rows_nofollow();
$missing_links = $website->count_all_rows_missing_link();

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
   $message .= $url . "---NOFOLLOW--<br>";
}
$toAddress = "tomis.jasulaitis@gmail.com"; //To whom you are sending the mail.
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
$mail->Username = "testreddragonemail@gmail.com"; // your gmail address
$mail->Password = "Tomis1997"; // password
$mail->SMTPSecure ='tls';
$mail->SetFrom("testreddragonemail@gmail.com");
$mail->Subject = "Crawler information"; // Mail subject
$mail->Body    = $message;
$mail->AddAddress($toAddress);
if (!$mail->Send()) {
     echo "Mailer Error: " . $mail->ErrorInfo;
    
} else {
    echo "Mail sent succesfully";
     $website->reset_checked();
}
}


?>