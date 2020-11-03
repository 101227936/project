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
	$file_name = "../Image/Product/".$random_Name.'.'.explode("/",$_FILES['AddimageProduct']['type'])[1];
	$file_size =$_FILES['AddimageProduct']['size'];
	$file_tmp =$_FILES['AddimageProduct']['tmp_name'];
	$file_type=$_FILES['AddimageProduct']['type'];

	if($file_size > 2097152){
		echo "<script> alert('File size must be excately 2 MB');location='add_product.php'</script>";
		$error = 1;
	}
	if ($file_size == 0)
	{
		echo "<script> alert('Must Insert a image file');location='add_product.php'</script>";
		$error = 1;
	}
	if($error==0)
	{
		move_uploaded_file($file_tmp,$file_name);
		$data = Array (
			"product_type" => trim($_POST['AddpType']),
			"product_name" => trim($_POST['AddpName']),
			"product_image" => $file_name,
			"product_description" => trim($_POST['AddpDescription'])
				);
				$id = $db->insert ('Tbl_product', $data);
		$size = array("small", "medium", "large");
		$last_id= $db->getOne('tbl_product','max(product_id)');
		//print_r($last_id['max(product_id)']);
		print_r($last_id['max(product_id)']);
		for($i=0;$i<3;++$i)
		{	
			$pPrice="AddpPrice".$i;
			$pStatus="AddpStatus".$i;
			$pDesc="AddpDesc".$i;
			if($_POST[$pPrice]!="" && $_POST[$pStatus]!="" && $_POST[$pDesc]!="")
			{
				$data2 = Array (
					'product_id' => $last_id['max(product_id)'],
					'product_detail_price' =>trim($_POST[$pPrice]),
					'product_detail_status' => trim($_POST[$pStatus]),
					'product_detail_description' => trim($_POST[$pDesc]),
					'product_detail_size' => $size[$i]
				);
				$adp = $db->insert ('tbl_product_detail', $data2);
			}
		}
		if ($adp && $id)
		{
			$order = $db->get("tbl_subscribe");
			if(sizeof($order)==0)
			{
				echo "<script> alert('Add product successful.');location='product_list.php'</script>";
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

					$last_id= $db->getOne('tbl_product','max(product_id)');
					$data = array(
						'product_id'=>$last_id['max(product_id)'],
					);
					$query = http_build_query($data);
					
					$url = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/add_product_email.php';
					
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
					$mail->Subject = 'NEW PRODUCT RELEASE! ';
					$mail->MsgHTML($message);
					$mail->AltBody = 'Our new product is available now!';
					$mail->charSet = "UTF-8"; 
					
					if($mail->send())
					{
						echo "<script> alert('Add product and send newslettter successful.');location='product_list.php'</script>";
					}
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}
		}
	}
}
?>