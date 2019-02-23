<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src/Exception.php';
require 'PHPMailer\src/PHPMailer.php';
require 'PHPMailer\src/SMTP.php';
include_once 'config/database.php';
include_once 'models/website.php';
include_once 'update.php';

$database = new Database();
$db = $database->connect();

$updater = new Update($db);
$website = new Website($db);

$updater->update_for_mailer();
$rows_checked = $website->count_all_rows_checked();
$rows_in_db = $website->count_all_rows();
$nofollow_links = $website->count_all_rows_nofollow();
$missing_links = $website->count_all_rows_missing_link();

$toAddress = "tomis.jasulaitis@gmail.com"; //To whom you are sending the mail.
$message   = "$rows_checked URLs checked, $missing_links backlinks not found, $nofollow_links found with NOFOLLOW:";
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
$mail->Username = "phexsprays@gmail.com"; // your gmail address
$mail->Password = "Tomjas1997"; // password
$mail->SMTPSecure ='tls';
$mail->SetFrom("phexsprays@gmail.com");
$mail->Subject = "Crawler information"; // Mail subject
$mail->Body    = $message;
$mail->AddAddress($toAddress);
if (!$mail->Send()) {
     echo "Mailer Error: " . $mail->ErrorInfo;
    
} else {
    echo "Mail sent succesfully";
}


























/*
//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "phexsprays@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "Tomjas1997";

//Set who the message is to be sent from
$mail->setFrom('phexsprays@gmail.com', 'First Last');

//Set an alternative reply-to address
$mail->addReplyTo('phexsprays@gmail.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress('tomis.jasulaitis@gmail.com', 'Tomas Jasulaitis');

//Set the subject line
$mail->Subject = 'PHPMailer GMail SMTP test';

$mail->Body = 'This is a plain-text message body';

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}
*/
?>