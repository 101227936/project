<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register & Signup | </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

		<!-- App css -->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
		<link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

		<!-- icons -->
		<link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg authentication-bg-pattern">
	
	<?php	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	require '../Database/init.php';
	require "../encrypt.php";
	if(isset($_POST['btnSave'])){
		
		$db->where("email", $_POST['email_id']);
	
		$results = $db->get ('tbl_login');

		if($results) {
			echo "<script> alert('Email Already Exit');location='register.php'</script>";
			
		} else if ($_POST['password'] != $_POST['confirmpassword'])
		{
			echo "<script> alert('User Password Is Different');location='register.php'</script>";
		}
		else 
		{
			
			$data = Array (
                          
                        'email' => $_POST['email_id'],
                        'password' => encrypt_decrypt("encrypt",trim($_POST['password'])),
						'role' => "Member",
						'status' => "Inactive"
							);
							
							$id = $db->insert ('tbl_login', $data);
				
							$last_id= $db->getOne('tbl_login','max(login_id)');
							//print_r("<pre>");
							//print_r($last_id);
							//print_r($db->getLastQuery());
							//print_r("</pre>");
							
			$data2 = Array (
						  'user_profile'=> "../Image/Profile/20201021103922.png",
                          'user_name'=> $_POST['user_name'],
						  'user_phone'=> $_POST['user_phone'],
						  'user_address'=> $_POST['user_address'],
						  'user_reward' => "0",
						  'newsletter_status' => "Inactive",
						  'login_id' => $last_id['max(login_id)']
						  
							);

			
			
			$id2 = $db->insert ('tbl_user', $data2);
			if($id && $id2){
					// Instantiation and passing `true` enables exceptions
					$mail = new PHPMailer(true);
					try {
			

						$data = Array (
							'status' => "Active"

						);
						$db->where ("email", $_POST['email_id']);

						if($db->update ('tbl_login', $data))
						{
							echo "<script> alert('User Verification Sent to Your Email Account. Please Activate It'location='l.php'</script>)";
						
						}else {echo "Update Unsuccessfuly. User ID Already Exits";}
						
						
						
						
					$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
					);
					
					//Server settings
					$mail->SMTPDebug = 0;                      // Enable verbose debug output
					$mail->isSMTP();                                            // Send using SMTP
					$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = 'fcmsmember@gmail.com';                     // SMTP username
					$mail->Password   = 'howtoing';                               // SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

					//Recipients
					$mail->setFrom('fcmsmember@gmail.com', 'Mailer');
					$mail->addAddress('keechu613@gmail.com', 'JasminPlanet');     // Add a recipient
					//$mail->addAddress('ellen@example.com');               // Name is optional
					//$mail->addReplyTo('info@example.com', 'Information');
					//$mail->addCC('cc@example.com');
					//$mail->addBCC('bcc@example.com');

					// Attachments
					//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
					//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
					
					$data = array(
						'login_id'=>$last_id['max(login_id)'],
						'status'=>'Active',
						'url'=>$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])
					);
					
					$query = http_build_query($data);

					$url = "http://" .$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/email-templates/email-verification.php';
					
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
					echo  "<script> alert('Message has been sent'location='login.php'</script>)";
				} catch (Exception $e) {
					echo  "<script> alert('User Verification Sent to Your Email Account. Please Activate It'location='login.php'</script>)";
				}

			
			
			
			}else {echo "<script> alert('Register Failed');location='register.php'</script>";}
		}
	
	}
	?>	
	

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
								
								 <div id="top" class="starter_container bg">
										<div class="follow_container">
											<div class="col-md-16 col-md-offset-3">
												<h2 class="top-title"> FoodEdge : Register</h2>
											
												<hr>
											</div>
										</div>
									</div>
									
									
                                    <div class="auth-logo">
                                        
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="../assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Don't have an account? Create your account, it takes less than a minute</p>
                                </div>

                                <form method="post" action="#" class="parsley-examples">
	
 
									
									<div class="form-group">
                                        <label for="userid">User Name</label>
                                        <input class="form-control" type="text" id="user_name" name="user_name" placeholder="Enter your name" required>
									</div>
									<div class="form-group">
                                        <label for="userid">User Phone</label>
                                        <input class="form-control" type="type" data-parsley-type="digits" data-parsley-length="[10,11]" parsley-trigger="change" id="user_phone" name="user_phone" placeholder="Enter your phone"  required>
                                    </div>
									<div class="form-group">
                                        <label for="userid">Home Address</label>
                                        <input class="form-control" type="text" id="user_address" name="user_address" placeholder="Enter your address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" type="email" id="email_id" name="email_id"  placeholder="Enter your email"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
										<div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                        </div>
                                            <input  type="password" id="password" name="password" class="form-control" placeholder="Enter your password" minlength="8" required>
                                            
                                        </div>
                                    </div>
									
									 <div class="form-group">
                                        <label for="confirmpassword">Confirm Password</label>
                                        <div class="input-group input-group-merge">
										<div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                         </div>
                                            <input type="confirmpassword" id="confirmpassword" name="confirmpassword" class="form-control" minlength="8" placeholder="Enter your confirm password" required>
                                            
                                        </div>
                                    </div>
                                   
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block"id="btnSave" name="btnSave" type="submit"> Sign Up </button>
                                    </div>

                                </form>

                                

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Already have account?  <a href="login.php" class="text-white ml-1"><b>Sign In</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

      

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
		
		<!-- Plugin js-->
        <script src="../assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="../assets/js/pages/form-validation.init.js"></script>
        
    </body>
</html>