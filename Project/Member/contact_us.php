<?php
	require "../Database/init.php";
	ob_start();
	$db->join("tbl_product", "tbl_product_detail.product_id=tbl_product.product_id", "LEFT");
	if(!empty($_GET['search']))$db->where ("tbl_product.product_name", '%'.$_GET['search'].'%', 'like');
	if(!empty($_GET['type']))$db->where ("tbl_product.product_type", $_GET['type'], '=');
	$db->where("tbl_product_detail.product_detail_status","Available","=");
	
	if(!empty($_GET['page']))$page = $_GET['page'];
	else $page = 1;
	$db->pageLimit = 4;
	$product_details = $db->arraybuilder()->paginate("tbl_product_detail", $page);		
	//print_r("<pre>");
	//print_r($product_details);
	//print_r($db->getLastQuery());
	//print_r("</pre>");
?>


<?php
	require "../Database/init.php";
	ob_start();
	if(!empty($_GET['search']))$db->where ("tbl_product_redeem.product_redeem_name", '%'.$_GET['search'].'%', 'like');
	if(!empty($_GET['type']))$db->where ("tbl_product_redeem.product_redeem_type", $_GET['type'], '=');
	$db->where("tbl_product_redeem.product_redeem_status","Available","=");
	
	if(!empty($_GET['page']))$page = $_GET['page'];
	else $page = 1;
	$db->pageLimit = 4;
	$product_redeem_details = $db->arraybuilder()->paginate("tbl_product_redeem", $page);		
	//print_r("<pre>");
	//print_r($product_redeem_details);
	//print_r($db->getLastQuery());
	//print_r("</pre>");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Contact Us</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../Landing/FoodEdge.ico">

	    <!-- App css -->
	    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	    <link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
	    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

	    <!-- icons -->
	    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body data-layout-mode="horizontal">

        <!-- Begin page -->
        <div id="wrapper">

			<?php include "member_topbar.php";?>
			<?php include "member_topnav.php";?>
            
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
			
			<div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                      
		<!-- ============ Social Section  ============= -->
						   
       <div class="content"
         style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 5000px; display: block; margin: 0 auto; padding: 20px;">
        <table class="main" width="100%" cellpadding="0" cellspacing="0"
               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;"
               bgcolor="#fff">
            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                
                     <div class="text-center w-75 m-auto" style = "color:white;">
					    <h2  class="top-title"> FoodEdge : Contact Us</h2>
					    <hr>
					 </div>
            </tr>
			
			 <td class=""
                    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #38414a; margin: 0; padding: 20px;"
                    align="center" bgcolor="#71b6f9" valign="top">
               
                    <span style="margin-top: 10px;display: block;">DROP US A MESSAGE OR DIAL US :</span>
					<span class="social_info"><a class="color_animation" href="tel:883-335-6524">(+60) 145661826</a></span>
             </td>
			
        </table>
    </div>
	  
	  
       
        <!-- ============ Contact Section  ============= -->
		
		
		 <form id="contact-us" method="post" action="#">
		 
		 
		 <div class="form-group mb-3">
		 
				<div class="col-auto">
					<!-- Name -->
					<label for="simpleinput">Name</label>
					<input type="text" name="name" id="name" required="required" class="form-control" placeholder="Name" />
					
				</div>
				
				
				<div class="col-auto">
					 <!-- Email -->
					<label for="simpleinput">Email</label>
					<input type="email" name="email" id="email" required="required" class="form-control" placeholder="Email" />
				</div>
					
					
				<div class="col-auto">
					 <!-- Subject -->
					<label for="simpleinput">Subject</label>
					<input type="text" name="subject" id="subject" required="required" class="form-control" placeholder="Subject" />
				</div>
					
				<div class="col-auto">
					 <!-- Message -->
					<label for="simpleinput">Message</label>
					<input type="textarea" name="message" id="message" required="required" class="form-control" placeholder="Message" />
				</div>
					
					
				<hr>
				<div class="col-auto">
					  <button onclick="alert('Message Sent!')" type="submit" id="submit" name="submit" class="btn btn-primary waves-effect waves-light mb-2">Send Message</button> 					 
				</div>
         </div>
		 
		 
		 </form>
		 
		 <?php	
			require '../Database/init.php';
			require "../encrypt.php";
			use PHPMailer\PHPMailer\PHPMailer;
			use PHPMailer\PHPMailer\Exception;
			use PHPMailer\PHPMailer\SMTP;
			require '../PHPMailer/src/Exception.php';
			require '../PHPMailer/src/PHPMailer.php';
			require '../PHPMailer/src/SMTP.php';
					
			if(isset($_POST['submit']))
			{
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
					
					//$email = $_POST['email'];
					
					//Server settings
					//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
					$mail->isSMTP();                                            // Send using SMTP
					$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = 'fcmsmember@gmail.com';                     // SMTP username
					$mail->Password   = 'howtoing';                               // SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	
					//Recipients
					$mail->setFrom($_POST['email'], $_POST['name']);
					$mail->addAddress('keechu613@gmail.com', 'JasminPlanet');     // Add a recipient
					//$mail->addAddress('ellen@example.com');               // Name is optional
					//$mail->addReplyTo('info@example.com', 'Information');
					//$mail->addCC('cc@example.com');
					//$mail->addBCC('bcc@example.com');
					
					// Attachments
					//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
					//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	
					// Content
					$mail->isHTML(true); // Set email format to HTML
					$mail->Subject = $_POST['subject'];
					
					$mail->Body = $_POST['message'];
	
					
					//$mail->MsgHTML($message);
					//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
					$mail->charSet = "UTF-8"; 
	
					
					$mail->send();
					$mail->SMTPDebug = 0;
					
					echo '<p hidden>Message has been sent</p>';
					
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}

			}
	  ?>
		 
		


                <?php include "member_footer.php";?>

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        
        <!-- /Right-bar -->
        <?php include "member_rightsidebar.php";?>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
        
    </body>
</html>