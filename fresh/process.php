<?php

  require_once('vendor/autoload.php');

  // use PHPMailer;

  $mail = new PHPMailer;

  // Email information
  $admin_email = "deenbey3@gmail.com";
  $email = $_POST['email'];
  $sender = $_POST['name'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];

  $mail->isSMTP();                                 // Set mailer to use SMTP
  $mail->Host = 'mail.nxygeoprudentials.com';      // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                          // Enable SMTP authentication
  $mail->Username = 'info@nxygeoprudentials.com';  // SMTP username
  $mail->Password = '*$KILIMANJAR0';                // SMTP password
  $mail->SMTPSecure = 'ssl';                       // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 465;                               // TCP port to connect to

  $mail->setFrom($email, 'Client Mail');
  $mail->addAddress($admin_email, 'Admin');
  $mail->isHTML(true);

  $mail->Subject = $subject;
  $mail->Body    = "Sender Email: ". $email ."<br />".
                    $message;


  if(!$mail->send()) {
      echo json_encode(['status_code' => $mail->ErrorInfo]);
  } else {
      echo json_encode(['status_code' => 200]);
  }

