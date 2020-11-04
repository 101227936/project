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
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Restaurant</title>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css" media="screen" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style-portfolio.css">
        <link rel="stylesheet" href="css/picto-foundry-food.css" />
        <link rel="stylesheet" href="css/jquery-ui.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link rel="icon" href="favicon-1.ico" type="image/x-icon">
      
    </head>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="row">
                <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">FoodEdge</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav main-nav  clear navbar-right ">
                            <li><a class="navactive color_animation" href="#top">WELCOME</a></li>
                            <li><a class="color_animation" href="#story">ABOUT</a></li>
                            <li><a class="color_animation" href="#pricing">MENU</a></li>
                            <li><a class="color_animation" href="#bread">REDEEM</a></li>
                            <li><a class="color_animation" href="#featured">FEATURED</a></li>
                            <li><a class="color_animation" href="#contact">CONTACT</a></li>
							<li><form action="../Register_and_login/login.php" method="get">
								<button class="btn btn-info navbar-btn" action="../Register_and_login/login.php">Login or Register</button>
							</form></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </div><!-- /.container-fluid -->
        </nav>
         
        <div id="top" class="starter_container bg">
            <div class="follow_container">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="top-title"> FoodEdge</h2>
                    <h2 class="white second-title">" The Buffet Catering At Your Doorstep"</h2>
                    <hr>
                    <br>
                </div>
                <div class="col-md-6 col-md-offset-3">
                <form method="post" action="send_subscribe_email.php" id="subsForm" class="parsley-examples" enctype="multipart/form-data">
                    <div class="col-md-8">
                        <input style="border-radius:10px !important;" type="email" name="SubEmail" required placeholder="Enter your email to subscribe our newsletter" class="form" id="SubEmail">
                    </div>
                    <div class="col-md-4">
                        <input type="submit" id="btnSub" name="btnSub" class="form-btn" value="SUBSCRIBE">
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- ============ About Us ============= -->

        <section id="story" class="description_content">
            <div class="text-content container">
                <div class="col-md-6">
                    <h1>About us</h1>
                    <div class="fa fa-cutlery fa-2x"></div>
                    <p class="desc-text">Restaurant is a place for simplicity. Good food, good beer, and good service. Simple is the name of the game, and we’re good at finding it in all the right places, even in your dining experience. We’re a small group from SWINBURNE PLANET who make simple food possible. Come join us and see what simplicity tastes like!</p>
                </div>
                <div class="col-md-6">
                    <div class="img-section">
                       <img src="images/kabob.jpg" width="250" height="220">
                       <img src="images/limes.jpg" width="250" height="220">
                       <div class="img-section-space"></div>
                       <img src="images/radish.jpg"  width="250" height="220">
                       <img src="images/corn.jpg"  width="250" height="220">
                   </div>
                </div>
            </div>
        </section>


       <!-- ============ Main Menu Pricing  ============= -->
        <section id ="pricing" class="description_content">
             <div class="pricing background_content">
                <h1><span>Special Cuisine</span> pricing</h1>
             </div>
            <div class="text-content container"> 
                <div class="container">
                   <div class="row">
							<?php
								foreach($product_details as $product_detail)
								{
									?>
									 <div class="col-md-6 col-xl-3">
										<div class="card-box product-box">
											<div class="bg-light">
												<img src="<?=$product_detail['product_image']?>"width="200" height="200" alt="product-pic" class="img-fluid"/>
											</div>

											<div class="product-info">
												<div class="row align-items-center">
													<div class="col">
														<h5 class="font-16 mt-0 sp-line-1"><a  class="text-dark"><?php echo $product_detail['product_name']?></a></h5>										
														
														<div class="text-warning mb-2 font-13">
															Rating:
															<?php
																$cols = Array("AVG(rating) as rating");
																$db->groupBy ("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
																$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
																$db->where("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
																$rating = $db->getOne("tbl_order_detail", null, $cols);
															
															?>
															<?=isset($rating['rating'])? $rating['rating']:'-'?>
														</div>
														<h5 class="m-0"> 
															<span class="text-muted"> 
																Category:
																<?=$product_detail['product_type']?>
															</span>												
														</h5>
														<h6 class="my-2"> 
															<span class="text-muted"> 
																Size:
																<?=$product_detail['product_detail_size']?>
															</span>																	
														</h6>
														<h6 class="my-2"> 
															<?=$product_detail['product_description']?>															
														</h6>
													</div>
													<div class="col-auto">
														<div class="product-price-tag">
															RM<?=$product_detail['product_detail_price']?>	
														</div>
													</div>
												</div> <!-- end row -->
											</div> <!-- end product info-->
										</div> <!-- end card-box-->
									</div> <!-- end col-->

									<?php
								}
							?>
						</div>
                </div>
            </div>  
        </section>


        <!-- ============ Top Redeem Listing Page  ============= -->
        <section id ="bread" class="description_content">
             <div  class="bread background_content">
                <h1>Top Redeem Item <span>Listing</span></h1>
            </div>
            <div class="text-content container"> 
                <div class="container">
                   <div class="row">
							<?php
								foreach($product_redeem_details as $product_redeem_detail)
								{
									?>
									 <div class="col-md-6 col-xl-3">
										<div class="card-box product-box">
											<div class="bg-light">
												<img src="<?=$product_redeem_detail['product_redeem_image']?>" width="200" height="200"alt="product-pic" class="img-fluid"/>
											</div>

											<div class="product-info">
												<div class="row align-items-center">
													<div class="col">
														<h5 class="font-16 mt-0 sp-line-1"><a  class="text-dark"><?php echo $product_redeem_detail['product_redeem_name']?></a></h5>										
														
														<div class="text-warning mb-2 font-13">
															Rating:
															<?php
																$cols = Array("AVG(rating) as rating");
																$db->groupBy ("tbl_order_detail.product_detail_id",$product_redeem_detail['product_redeem_id'],"=");
																$db->where("tbl_order_detail.product_id",0,"=");
																$db->where("tbl_order_detail.product_detail_id",$product_redeem_detail['product_redeem_id'],"=");
																$rating = $db->getOne("tbl_order_detail", null, $cols);
															
															?>
															<?=isset($rating['rating'])? $rating['rating']:'-'?>
														</div>
														<h5 class="m-0"> 
															<span class="text-muted"> 
																Category:
																<?=$product_redeem_detail['product_redeem_type']?>
															</span>												
														</h5>
														<h6 class="my-2"> 
															<?=$product_redeem_detail['product_redeem_description']?>															
														</h6>
													</div>
													<div class="col-auto">
														<div class="product-price-tag">
															<?=$product_redeem_detail['product_redeem_point']?>	
														</div>
													</div>
												</div> <!-- end row -->
											</div> <!-- end product info-->
										</div> <!-- end card-box-->
									</div> <!-- end col-->
									<?php
								}
							?>
						</div>
                </div>
            </div>  
        </section>

        
        <!-- ============ Featured Dish  ============= -->
        <section id="featured" class="description_content">
            <div  class="featured background_content">
                <h1>Our Featured Dishes <span>Menu</span></h1>
            </div>
            <div class="text-content container"> 
                <div class="col-md-6">
                    <h1>Have a look to our dishes!</h1>
                    <div class="icon-hotdog fa-2x"></div>
                    <p class="desc-text">Each food is handmade at the crack of dawn, using only the simplest of ingredients to bring out smells and flavors that beckon the whole block. Stop by anytime and experience simplicity at its finest.</p>
                </div>
                <div class="col-md-6">
                    <ul class="image_box_story2">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="images/slider1.jpg"  alt="...">
                                    <div class="carousel-caption">
                                        
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="images/slider2.jpg" alt="...">
                                    <div class="carousel-caption">
                                        
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="images/slider3.JPG" alt="...">
                                    <div class="carousel-caption">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </section>

        

        <!-- ============ Social Section  ============= -->
        <section class="social_connect">
            <div class="text-content container"> 
                <div class="col-md-6">
                    <span class="social_heading">FOLLOW</span>
                    <ul class="social_icons">
                        <li><a class="icon-twitter color_animation" href="#" target="_blank"></a></li>
                        <li><a class="icon-github color_animation" href="#" target="_blank"></a></li>
                        <li><a class="icon-linkedin color_animation" href="#" target="_blank"></a></li>
                        <li><a class="icon-mail color_animation" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <span class="social_heading">OR DIAL</span>
                    <span class="social_info"><a class="color_animation" href="tel:883-335-6524">(941) 883-335-6524</a></span>
                </div>
            </div>
        </section>

        <!-- ============ Contact Section  ============= -->
         <section id="contact">
            
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner contact">
                            <!-- Form Area -->
                            <div class="contact-form">
                                <!-- Form -->
                                <form id="contact-us" method="post">
                                    <!-- Left Inputs -->
                                    <div class="col-md-6 ">
                                        <!-- Name -->
                                        <input type="text" name="name" id="name" required="required" class="form" placeholder="Name" />
                                        <!-- Email -->
                                        <input type="email" name="email" id="email" required="required" class="form" placeholder="Email" />
                                        <!-- Subject -->
                                        <input type="text" name="subject" id="subject" required="required" class="form" placeholder="Subject" />
                                    </div><!-- End Left Inputs -->
                                    <!-- Right Inputs -->
                                    <div class="col-md-6">
                                        <!-- Message -->
                                        <textarea name="message" id="message" class="form textarea"  placeholder="Message"></textarea>
                                    </div><!-- End Right Inputs -->
                                    <!-- Bottom Submit -->
                                    <div class="relative fullwidth col-xs-12">
                                        <!-- Send Button -->
                                        <button onclick="alert('Message Sent!')" type="submit" id="submit" name="submit" class="form-btn">Send Message</button>
                                    </div><!-- End Bottom Submit -->
                                    <!-- Clear -->
                                    <div class="clear"></div>
                                </form>
                            </div><!-- End Contact Form Area -->
                        </div><!-- End Inner -->
                    </div>
                </div>
            </div>
        </section>
		
		
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

        <!-- ============ Footer Section  ============= -->
        <footer class="sub_footer">
            <div class="container">
                
                <div class="col-md-4"><p class="sub-footer-text text-center">Back to <a href="#top">TOP</a></p>
                </div>
                
            </div>
        </footer>

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"> </script>
        <script type="text/javascript" src="js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>     
        <script type="text/javascript" src="js/jquery.mixitup.min.js" ></script>
        <script type="text/javascript" src="js/main.js" ></script>

    </body>
</html>