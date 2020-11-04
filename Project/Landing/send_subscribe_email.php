<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../Database/init.php";
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
ob_start();

if(isset($_POST['btnSub']))
{
	$sub = trim($_POST['SubEmail']);
	$data = Array (
		'subscribe_email' => $sub
	);
	$db->where("subscribe_email","$sub","=");
	$order = $db->getOne("tbl_subscribe");
	if(sizeof($order)>0)
	{
		echo "<script> alert('This email subscribe already.');location='landing.php'</script>";
	}
	else
	{
		if ($db->insert ('tbl_subscribe', $data))
		{
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
				$mail->Password   = 'howtoing';                                  // SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

				$user_email = trim($_POST['SubEmail']);

				$db->where("subscribe_email",$user_email,"=");
				$order = $db->getOne("tbl_subscribe");

				//Recipients
				$mail->setFrom('fcmsmember@gmail.com', 'FoodEdge Gourmet Catering');
				$mail->addAddress($user_email);
				
				$data = array(
					'subscribe_email'=>$_POST['SubEmail']
				);
				$query = http_build_query($data);
				
				$url = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/subscribe_email.php';
				
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
				$mail->Subject = 'Subscribe Email from FCMS';
				$mail->MsgHTML($message);
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				$mail->charSet = "UTF-8"; 
				
				if($mail->send())
				{
					echo "<script> alert('Subscribe Successfully.');location='landing.php'</script>";
				}
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
		else
		{
			echo 'Subscribe failed: ' . $db->getLastError();
		}
	}
}


?>
