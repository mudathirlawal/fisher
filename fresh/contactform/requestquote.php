<?php
/*
    PHP contact form script
*/

/***************** Configuration *****************/

require_once('../vendor/autoload.php');

$mail = new \PHPMailer\PHPMailer\PHPMailer();

// Email information
$contact_email_to = "";
$email = $_POST['email'];
$name = $_POST['name'];
$message = $_POST['message'];
$subject = $_POST['subject'];

$mail->isSMTP();                                 // Set mailer to use SMTP
//  $mail->SMTPDebug = 2;
$mail->Host = 'smtp.gmail.com';      // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                          // Enable SMTP authentication
$mail->Username = '';  // SMTP username
$mail->Password = '';                // SMTP password
$mail->SMTPSecure = 'ssl';                       // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                               // TCP port to connect to

// Subject prefix
$contact_subject_prefix = "Contact Form Message: ";

// Name too short error text
$contact_error_name = "Name is too short or empty!";

// Email invalid error text
$contact_error_email = "Please enter a valid email!";

// Subject too short error text
$contact_error_subject = "Subject is too short or empty!";

// Message too short error text
$contact_error_message = "Too short message! Please enter something.";

/********** Do not edit from the below line ***********/

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    // The Request must be Ajax POST, enter a message for direct access requests.
    die('Invalid Request!');
}

if( isset($_POST) ) {

    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    if(strlen($name)<4){
        die($contact_error_name);
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die($contact_error_email);
    }

    if(strlen($subject)<3){
        die($contact_error_subject);
    }

    if(strlen($message)<3){
        die($contact_error_message);
    }

    $mail->setFrom("$email", 'Client Mail');
    $mail->addAddress($contact_email_to, 'Admin');
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "Sender Email: ". $email ."<br />".
        $message;
    $sendEmail = $mail->send($contact_email_to, $contact_subject_prefix . $subject, $message,
        "From: ".$name." <".$email.">" . PHP_EOL
        ."Reply-To: ".$email . PHP_EOL
        ."X-Mailer: PHP/" . phpversion()
    );

    if( $sendEmail ) {
        return json_encode(['status_code' => 200]);
    } else {
        return json_encode(['status_code' => $mail->ErrorInfo]);
    }
}
