<?php
	require "../Database/init.php";
	ob_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FoodEdge Gourmet Catering</title>
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
      
        <!-- Font Awesome Icon Library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        .checked {
        color: orange;
        }
        </style>
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
                    <div class="fa fa-users fa-2x"></div>
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
                <h1><span>Main</span> Menu</h1>
             </div>
            <div class="text-content container"> 
                <div class="container">
                    <div class="row">
                        <?php
                        $db->join("tbl_product_detail pd","p.product_id = pd.product_id","INNER");
                        $db->groupBy ("p.product_id");
                        $product_details = $db->get("tbl_product p");

                        $i=0;
						foreach($product_details as $product_detail)
						{
                            ?>
                                <div class="col-md-4">
                                    <img src="<?=$product_detail['product_image']?>" width="80%" height="300px" alt="product-pic" class="img-fluid"/>
                                    <div class="card-body">
                                        <h2 class="card-title" style="padding-top:20px;padding-bottom:10px !important"><?=$product_detail['product_name']?></h2>
                                        <?php
                                        $cols = Array("AVG(rating) as rating");
                                        $db->join("tbl_order", "tbl_order.order_id=tbl_order_detail.order_id", "LEFT");
                                        $db->where("tbl_order.order_status",'Arrive',"=");
                                        $db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
                                        $rating = $db->get("tbl_order_detail", null, $cols);
                                        if(isset($rating[0]['rating']))
                                        {
                                            for($i=0;$i<5;$i++)
                                            {
                                                if(round($rating[0]['rating'])<=$i)
                                                {
                                                    ?>
                                                    <span class="fa fa-star"></span>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <span class="fa fa-star checked"></span>
                                                    <?php
                                                }
                                              
                                            }
                                        }
                                        echo isset($rating[0]['rating'])? number_format((float)$rating[0]['rating'], 2, '.', ''):'No Rating';                                 
                                        ?>
                                        <hr style="margin-top:15px;border-top: 1px solid #bbbbbb !important">
                                        <p style="text-align:left"><?=$product_detail['product_description']?></p>
                                        <br>
                                        <?php
                                        $db->join("tbl_product_detail pd","p.product_id = pd.product_id","INNER");
                                        $db->where("p.product_id",$product_detail['product_id'],"=");
                                        $product_details = $db->get("tbl_product p");
                                        ?>
                                        <p style="text-align:left">Size: 
                                        <?php
                                        $msg="";
                                        $count=0;
                                        foreach($product_details as $product_detail)
                                        {
                                            if($count!=2)
                                            {
                                                if($product_detail['product_detail_status']=="Not available")
                                                {
                                                    ?>
                                                    <del style="color:red;"><?=$product_detail['product_detail_size']?></del><?=","?>
                                                    <?php
                                                    $msg.=$product_detail['product_detail_size']." ";
                                                }
                                                else
                                                {
                                                    echo $product_detail['product_detail_size'].",";
                                                }
                                                $count++;
                                            }
                                            else
                                            {
                                                $count=0;
                                                if($product_detail['product_detail_status']=="Not available")
                                                {
                                                    ?>
                                                    <del style="color:red;"><?=$product_detail['product_detail_size']?></del>
                                                    <?php
                                                    $msg.=$product_detail['product_detail_size']." ";
                                                }
                                                else
                                                {
                                                    echo $product_detail['product_detail_size'];
                                                }
                                            }
                                        }
                                        ?>
                                        <?php

                                        ?>
                                        <?php
                                        $db->join("tbl_product_detail pd","p.product_id = pd.product_id","INNER");
                                        $db->where("p.product_id",$product_detail['product_id'],"=");
                                        $product_details = $db->getOne("tbl_product p","max(product_detail_price) AS max, min(product_detail_price) AS min");
                                        ?>
                                        <p>
                                            <?php
                                            if($product_details['min']==$product_details['max'])
                                            {
                                                ?>
                                                <h2 class="text-muted" style="padding-top:15px;padding-bottom:10px;">RM <?=$product_details['min'].".00"?></h2>
                                                <?php
                                            }
                                            else
                                            {
                                            ?>
                                                <h2 class="text-muted" style="padding-top:15px;padding-bottom:10px;">RM <?=$product_details['min'].".00 - RM ".$product_details['max'].".00"?></h2>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <?php
                                        if($msg!="")
                                        {
                                            $na=str_replace(" ",", ",$msg);
                                            $na2=substr_replace($na, ' ', -2);
                                            ?>
                                            <p style="color:red;text-align:center;font-size:15px;padding-bottom:70px;">*Not available for <?=$na2?> size</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>  
        </section>


        <!-- ============ Top Redeem Listing Page  ============= -->
        <section id ="bread" class="description_content" style="padding-top:10px !important">
             <div  class="bread background_content">
                <h1>Redeem Item <span>Listing</span></h1>
            </div>
            <div class="text-content container"> 
                <div class="container">
                   <div class="row">
                        <?php
                        $product_redeem_details = $db->get("tbl_product_redeem");

                        $i=0;
						foreach($product_redeem_details as $product_redeem_detail)
						{
                            ?>
                                <div class="col-md-4">
                                    <img src="<?=$product_redeem_detail['product_redeem_image']?>" width="80%" height="300px" alt="product-pic" class="img-fluid"/>
                                    <div class="card-body">
                                        <h2 class="card-title" style="padding-top:20px;padding-bottom:10px !important"><?=$product_redeem_detail['product_redeem_name']?></h2>
                                        <?php
                                        $cols = Array("AVG(rating) as rating");
                                        $db->where("tbl_order_detail.product_id",0,"=");
                                        $db->where("tbl_order_detail.product_detail_id",$product_redeem_detail['product_redeem_id'],"=");
                                        $rating = $db->get("tbl_order_detail", null, $cols);
                                        if(isset($rating[0]['rating']))
                                        {
                                            for($i=0;$i<5;$i++)
                                            {
                                                if(round($rating[0]['rating'])<=$i)
                                                {
                                                    ?>
                                                    <span class="fa fa-star"></span>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <span class="fa fa-star checked"></span>
                                                    <?php
                                                }
                                              
                                            }
                                        }
                                        echo isset($rating[0]['rating'])? number_format((float)round($rating[0]['rating']), 2, '.', ''):'No Rating';                                 
                                        ?>
                                        <hr style="margin-top:15px;border-top: 1px solid #bbbbbb !important">
                                        <p style="text-align:left"><?=$product_redeem_detail['product_redeem_description']?></p>
                                        <br>
                                       <p>
                                        <h2 class="text-muted" style="padding-top:5px;padding-bottom:70px;"><?=$product_redeem_detail['product_redeem_point']." Point"?></h2>
                                        </p>
                                    </div>
                                </div>
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
                    <div class="fa fa-cutlery fa-2x"></div>
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

        <!-- ============ Contact Section  ============= -->
        <section id ="contact" class="description_content" style="padding-top:20px;padding-bottom:100px;">
            <div  class="beer background_content">
                <h1><span>Contact</span> Us</h1>
            </div>
            <div class="text-content container"> 
                <div class="col-md-6">
                    <h1>Get in touch</h1>
                    <div class="fa fa-envelope fa-2x"></div>
                    <p class="desc-text" style="text-align: justify;text-justify: inter-word;padding-right:20px;">If you have any question, please feel free to drop us a line. We'll get back to you as soon as we can. That's a promise!</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <!-- Form Area -->
                        <div class="contact-form">
                            <!-- Form -->
                            <form id="contact-us" method="post">
                                <!-- Left Inputs -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Name -->
                                        <input type="text" name="name" id="name" required="required" class="form" placeholder="Name" />
                                    </div>
                                    <div class="col-md-12">
                                        <!-- Email -->
                                        <input type="email" name="email" id="email" required="required" class="form" placeholder="Email" />
                                    </div>
                                    <div class="col-md-12">
                                        <!-- Subject -->
                                        <input type="text" name="subject" id="subject" required="required" class="form" placeholder="Subject" />
                                    </div><!-- End Left Inputs -->
                                    <!-- Right Inputs -->
                                    <div class="col-md-12">
                                        <!-- Message -->
                                        <textarea class="form" id="message" name="message" placeholder="Enter your message"></textarea>
                                    </div><!-- End Right Inputs -->
                                </div>
                                
                                <!-- Bottom Submit -->
                                <div class="text-center">
                                    <!-- Send Button -->
                                    <!--<button onclick="alert('Message Sent!')" type="submit" id="submit" name="submit" class="form-btn">Send Message</button>-->
                                    <input type="submit" id="submit" name="submit" class="form-btn" style="width:100% !important;" value="Send Message">
                                </div><!-- End Bottom Submit -->
                            </form>
                        </div><!-- End Contact Form Area -->
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
					$mail->addAddress('keechu613@gmail.com', 'JasminPlanet');    // Add a recipient
				
					// Content
					$mail->isHTML(true); // Set email format to HTML
					$mail->Subject = $_POST['subject'];
					
					$mail->Body = $_POST['message'];
	
					$mail->charSet = "UTF-8"; 
	
					
                    if($mail->send())
                    {
                        echo "<script> alert('Message has been sent.');location='landing.php'</script>";
                    }
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}

			}
	  ?>	

        <!-- ============ Footer Section  ============= -->
        <footer class="sub_footer">
            <div class="container">
                <div class="col-md-12"><p class="sub-footer-text text-right">Back to <a href="#top">TOP</a></p>
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