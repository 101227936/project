<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../Database/init.php";
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
ob_start();

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
	$mail->Username   = 'fcmsmember@gmail.com';                     // SMTP username
	$mail->Password   = 'howtoing';                                  // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
	$db->join("tbl_login", "tbl_user.login_id=tbl_login.login_id", "LEFT");
	$db->where("tbl_order.order_id",$_GET['order_id'],"=");
	$order = $db->getOne("tbl_order");
  
	$user_email = $order['email'];
	$user_name = $order['user_name'];

	//Recipients
	$mail->setFrom('fcmsmember@gmail.com', 'FoodEdge Gourmet Catering');
	$mail->addAddress($user_email, $user_name);
	

	$data = array(
		'order_id'=>$_GET['order_id']
    );
	$query = http_build_query($data);
    
	$url = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/receipt_email.php';
    
	$message =  file_get_contents($url.'?'.$query);
	
	$xpath = new DOMXPath(@DOMDocument::loadHTML($message));
	$images = $xpath->evaluate("//img");
	if($images)
	{
		$i=0;
		foreach ($images as $image) {
			$src = $image->getAttribute('src');
			$mail->AddEmbeddedImage(''.$src, $i);
			$message=str_replace($src,"cid:".$i,$message);
			$i++;
		}
	}
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Receipt Email from FoodEdge Gourmet Catering';
	$mail->MsgHTML($message);
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->charSet = "UTF-8"; 
    
	if($mail->send())
	{
		header("Location: order_detail.php?order_id=".$_GET['order_id']."");
	}
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>