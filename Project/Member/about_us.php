<?php
	require "../Database/init.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>About Us</title>
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
        <div id="wrapper" class="a">

			<?php include "member_topbar.php";?>
			<?php include "member_topnav.php";?>
            
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
			
			<div>
                <div class="background_content" style="background: url('../assets/images/restaurant.jpg'); ">
					<h1><span>About</span> Us</h1>
				</div>
			</div>

            <div>
				<h1 class="alignment">Our Values</h1>
                <div class="about_us">
                    Restaurant is a place for simplicity. Good food, good beer, and good service. Simple is the name of the game, and we’re good at finding it in all the right places, even in your dining experience. We’re a small group from SWINBURNE PLANET who make simple food possible. Come join us and see what simplicity tastes like!
                </div>
				<div class="b">
                    <div>
                       <img src="../Landing/images/kabob.jpg" width="250" height="220">
                       <img src="../Landing/images/limes.jpg" width="250" height="220">
                       <img src="../Landing/images/radish.jpg"  width="250" height="220">
                       <img src="../Landing/images/corn.jpg"  width="250" height="220">
                   </div>
                </div>
				
				<div class="c">
					  <div class="column2">
						  <div>
							<i data-feather="search" class="icons-xxl"></i>
							<h4>1. Search</h4>
							<p class="title">Search for the products displayed in the main menu page and main menu redeem page.</p>
						  </div>
					  </div>
					  <div class="column2">
						  <div>
							<i data-feather="check-circle" class="icons-xxl"></i>
							<h4>2. Choose</h4>
							<p class="title">Select the products that you like and add to cart.</p>
						  </div>
					  </div>
					  <div class="column2">
						  <div>
							<i data-feather="credit-card" class="icons-xxl"></i>
							<h4>3. Checkout</h4>
							<p class="title">Make payment using secured online transfer via credit card and using reward points for products redeem.</p>
						  </div>
					  </div>
					  <div class="column2">
						  <div>
							<i data-feather="thumbs-up" class="icons-xxl"></i>
							<h4>4. Enjoy</h4>
							<p class="title">Have a good time enjoying your chosen products.</p>
						  </div>
					  </div>
				</div>
				
                <div class="background_content2" style="background: url('../assets/images/management.jpg'); ">
					<h1><span>Our Peo</span>ple</h1>
				</div>
			
				<div>
					<h1 class="alignment">Who we are?</h1>
					<div style="height: 90px; font-size: 20px; line-height: 35px;">
						It's always been pretty simple for us. Great people make great work. Meet the team.
					</div>
					<div>
					  <div class="column">
						<div class="card2">
							<img src="../Image/AboutUs/ceo.jpg" alt="John Wick" style="width:100%;">
							<h2>John Wick</h2>
							<p>CEO & Founder</p>
							<p class="title">He is a CEO and also a founder of this company which responsible to manage the overall operations of FoodEdge Gourmet.</p>
						</div>
					  </div>

					  <div class="column">
						<div class="card2">
							<img src="../Image/AboutUs/chef.png" alt="Gordon Ramsay" style="width:100%">
							<h2>Gordon Ramsay</h2>
							<p>Chef</p>
							<p class="title">He is the chef for the company which good in cooking asian, western food and beverages.</p>
						</div>
					  </div>
					  
					  <div class="column">
						<div class="card2">
							<img src="../Image/AboutUs/account.jpg" alt="Wilson" style="width:100%">
							<h2>Wilson Walker</h2>
							<p>Accounts Manager</p>
							<p class="title">He is an account manager that responsible in managing financials of FoodEdge Gourmet.</p>
						</div>
					  </div>
					  
					  <div class="column">
						<div class="card2">
							<img src="../Image/AboutUs/stocks.jpg" alt="Jennifer" style="width:100%">
							<h2>Jennifer Ayesha</h2>	
							<p>Inventory and Stock Manager</p>
							<p class="title">She manages inventory tracking system to record deliveries, and stock levels of FoodEdge Gourmet.</p>
						</div>
					  </div>
					  
					  <div class="column">
						<div class="card2">
							<img src="../Image/AboutUs/store.jpg" alt="Alice" style="height:auto;width:100%">
							<h2>Alice Rachael</h2>
							<p>Store Manager</p>
							<p class="title">She is responsible for overseeing the daily operations of FoodEdge Gourmet.</p>
						</div>
					  </div>
					</div>
					
					<div class="background_content2" style="background:url('../assets/images/restaurant-1.jpg');">
						<h1><span>Informa</span>tion</h1>
					</div>	

					<div class="column3">
						<div>
							<p>Address</p>
							<p class="title2">&#8226 38, Carpenter Street, Kuching</p>
							<hr>
						</div>
								
						<div>
							<p>Working Hours</p>
							<p class="title2">&#8226 Monday - Sunday  10.00 am to 10.00 pm</p>
							<hr>
						</div>
								
						<div>
							<p>Contact</p>
							<p class="title2">&#8226 Tel: +60 123 456 789</p>
							<p class="title2">&#8226 Email: foodedge@gmail.com</p>
						</div>
					</div>
									
					<div class="column3">
						<div class="map">
							<iframe src="https://www.google.com/maps/d/embed?mid=1Jde5YFaP1D_egb85-U91y93fQoV9Fwoy" class="map_size" width="100%" height="auto" allowfullscreen></iframe>
						</div>
					</div>
				</div>    
            </div>
			
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>

        <!-- END wrapper -->
		<?php include "member_footer.php";?>

        
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