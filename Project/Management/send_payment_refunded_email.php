<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../Database/init.php";
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
ob_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
$data = Array (
'refund_reason' => trim($_POST['refund']),
'payment_status'=> "Refunded",
'refund_datetime'=>date("Y-m-d G:i:s")
);
$db->where("p.payment_id",$_GET['payment_id'],"=");
$id = $db->update ('tbl_payment p', $data);


$db->join("tbl_order o","o.user_id = u.user_id","INNER");
$db->join("tbl_payment p","p.order_id = p.order_id","INNER");
$db->where("p.payment_id",$_GET['payment_id'],"=");
$user=$db->getOne("tbl_user u");

$total=($user['user_reward'] + $user['amount_point']);

$data2 = Array (
	'user_reward' => $total
	);
	$db->join("tbl_order o","o.user_id = u.user_id","INNER");
	$db->join("tbl_payment p","p.order_id = p.order_id","INNER");
	$db->where("p.payment_id",$_GET['payment_id'],"=");
	$user2=$db->update ('tbl_user u', $data2);

if($id && $data2)
{
	$db->join("tbl_order o", "p.order_id=o.order_id", "INNER");
	$db->join("tbl_user u", "o.user_id=u.user_id", "INNER");
	$db->join("tbl_login l","u.login_id=l.login_id","INNER");
	$db->where("p.payment_id",$_GET['payment_id'],"=");
	$order = $db->getOne("tbl_payment p");

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
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'fcmsmember@gmail.com';                     // SMTP username
		$mail->Password   = 'howtoing';                                 // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom('fcmsmember@gmail.com', 'FoodEdge Gourment Catering');
		$mail->addAddress($order['email'], $order['user_name']);     // Add a recipient

		$data = array(
			'payment_id'=>$order['order_id']
		);
		$query = http_build_query($data);
		
		$url = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/payment_refunded_email.php';
		
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
		$mail->Subject = 'Payment Refunded';
		$mail->MsgHTML($message);
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		$mail->charSet = "UTF-8"; 
		
		if($mail->send())
		{
			echo "<script> alert('Refund payment and send email successfully.');location='payment_list.php'</script>";
		}
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

?>
