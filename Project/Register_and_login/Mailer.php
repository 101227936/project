<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
	);
	
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'jasminkee613@gmail.com';                     // SMTP username
    $mail->Password   = 'keechu0116';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('jasminkee613@gmail.com', 'Mailer');
    $mail->addAddress('keechu613@gmail.com', 'JasminPlanet');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	$data = array(
		'login_id'=>'3',
		'url'=>$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])
    );
	$query = http_build_query($data);

	$url = "http://" .$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/email-templates/email-password.php';
	
	$message = file_get_contents($url.'?'.$query);
	
	
	
	$xpath = new DOMXPath(@DOMDocument::loadHTML($message));
	$images = $xpath->evaluate("//img");
	if($images)
	{
		$i=0;
		foreach ($images as $image) {
			$src = $image->getAttribute('src');
			$mail->AddEmbeddedImage('email-templates/'.$src, $i);
			$message=str_replace($src,"cid:".$i,$message);
			$i++;
		}
	}

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Here is the subject';
	$mail->MsgHTML($message);
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->charSet = "UTF-8"; 

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>