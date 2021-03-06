<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require '../Database/init.php';

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
    $mail->SMTPDebug = 0;                       // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'fcmsmember@gmail.com';                     // SMTP username
    $mail->Password   = 'howtoing';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	$db->join("tbl_user", "tbl_user.login_id=tbl_login.login_id", "LEFT");
	$db->where ("email", $_GET['emailaddress']);
	$user = $db->getOne ("tbl_login");
	
	if(!isset($user))echo "<script> alert('Email is not exist');location='login.php'</script>";
	
    //Recipients
    $mail->setFrom('fcmsmember@gmail.com', 'FoodEdge Gourmet Catering');
    $mail->addAddress($user['email'], $user['user_name']);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	$data = array(
		'login_id'=>$user['login_id'],
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
    $mail->Subject = 'Reset Password from FCMS';
	$mail->MsgHTML($message);
    $mail->AltBody = "Forgot your password? Let's get you a new one! ";
	$mail->charSet = "UTF-8"; 

    $mail->send();
	echo "<script> alert('Reset Password Email Sent to Your Email Account. Please Reset It');location='login.php'</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>