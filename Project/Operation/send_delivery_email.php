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
	$mail->Password   = 'howtoing';                                 // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
	$db->join("tbl_login", "tbl_user.login_id=tbl_login.login_id", "LEFT");
	$db->where("tbl_order.order_id",$_GET['order_id'],"=");
	$order = $db->getOne("tbl_order");
	
	//print_r("<pre>");
	//print_r($order);
	//print_r($db->getLastQuery());
	//print_r("</pre>");

    //Recipients
    $mail->setFrom('fcmsmember@gmail.com', 'FoodEdge Gourmet Catering');
    $mail->addAddress($order['email'], $order['user_name']);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	

	$data = array(
		'order_id'=>$_GET['order_id']
    );
	$query = http_build_query($data);
    
	$url = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/delivery_email.php';
    
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
    $mail->Subject = 'Email of Delivery Information from FCMS';
	$mail->MsgHTML($message);
    $mail->AltBody = 'Thanks for waiting order for delivery. Please preview the delivery information in detail in browser';
	$mail->charSet = "UTF-8"; 
    
    if($mail->send())
	{
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$data = Array (
			'modified_datetime' => date('Y-m-d H:i:s'),
			'order_status' => 'Delivering'
		);
		$db->where ('order_id', $_GET['order_id']);
		$db->update ('tbl_order', $data);
		header("Location: order_detail.php?order_id=".$_GET['order_id']."");
	}
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>