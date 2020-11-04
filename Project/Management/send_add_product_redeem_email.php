<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../Database/init.php";
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
ob_start();

if(isset($_POST['btnAdd']))
{
	$random_Name = date("YmdHis");
	$error = 0;
	$file_name = "../Image/Product/".$random_Name.'.'.explode("/",$_FILES['AddimageProductRe']['type'])[1];
	$file_size =$_FILES['AddimageProductRe']['size'];
	$file_tmp =$_FILES['AddimageProductRe']['tmp_name'];
	$file_type=$_FILES['AddimageProductRe']['type'];

	if($file_size > 2097152){
		echo "<script> alert('File size must be excately 2 MB');location='redeem_list.php'</script>";
		$error = 1;
	}
	if ($file_size == 0)
	{
		echo "<script> alert('Must Insert a image file');location='redeem_list.php'</script>";
		$error = 1;
	}
	if($error==0)
	{
		move_uploaded_file($file_tmp,$file_name);
		$data = Array (
			"product_redeem_type" => trim($_POST['AddpTypeRe']),
			"product_redeem_name" => trim($_POST['AddpNameRe']),
			'product_redeem_point' =>trim($_POST['AddpPointRe']),
			'product_redeem_status' => trim($_POST['AddpStatusRe']),
			"product_redeem_image" => $file_name,
			"product_redeem_description" => trim($_POST['AddpDescRe'])
		);
		if ($db->insert ('tbl_product_redeem', $data))
		{
			//echo "<script> alert('Add Success');location='redeem_list.php'</script>";
			$flag=false;
			if(trim($_POST['AddpStatusRe'])=="Available")
			{
				$flag = true;
			}
			if($flag)	//Available
			{
				$order = $db->get("tbl_subscribe");
				if(sizeof($order)==0)
				{
					echo "<script> alert('Add product redeem successful.');location='redeem_list.php'</script>";
				}
				else
				{
					$mail = new PHPMailer(true);

					try {
						$mail->SMTPOptions = array(
							'ssl' => array(
							'verify_peer' => false,
							'verify_peer_name' => false,
							'allow_self_signed' => false	//true
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

						$order = $db->get("tbl_subscribe");

						//Recipients
						$mail->setFrom('fcmsmember@gmail.com', 'FCMS');
						for($i=0; $i<sizeof($order); $i++)
						{
							$mail->addAddress($order[$i]['subscribe_email']);
						}

						$last_id= $db->getOne('tbl_product_redeem','max(product_redeem_id)');
						$data = array(
							'product_redeem_id'=>$last_id['max(product_redeem_id)'],
						);
						$query = http_build_query($data);
						
						$url = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/add_product_redeem_email.php';
						
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
						$mail->Subject = 'NEW REDEEM PRODUCT RELEASE! ';
						$mail->MsgHTML($message);
						$mail->AltBody = 'Our new redeem product is available now!';
						$mail->charSet = "UTF-8"; 
						
						if($mail->send())
						{
							echo "<script> alert('Add product redeem and send newslettter successful.');location='redeem_list.php'</script>";
						}
					} catch (Exception $e) {
						echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
					}
				}
			}
			else
			{
				echo "<script> alert('Add product redeem successful.');location='redeem_list.php'</script>";
			}
		} 
		else
		{ 
			echo 'update failed: ' . $db->getLastError();
		}
	}
}
?>