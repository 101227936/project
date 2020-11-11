
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login Page</title>
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
	require '../Database/init.php';
	require "../encrypt.php";
	session_start();
	
	if (isset($_POST['btnSave']))
	{
		$db->where("email", $_POST['useremail']);
		$db->where("status", "Active","=");
		$db->where("password", encrypt_decrypt("encrypt",trim($_POST['password'])));
		$results = $db->get ('tbl_login');
		
		if (sizeof($results)==0)
		{
			echo "<script> alert('Failed');location=' ../Register_and_login/login.php'</script>";
		}
		
		else
		{
			$_SESSION['role']=$results[0]['role'];
		
			if($_SESSION['role']=="Member")
			{
				$db->where("tbl_user.login_id",$results[0]['login_id'] );
				$results1 =$db->get("tbl_user");

				$_SESSION['user_id']=$results1[0]['user_id'];
				//print_r ($results1);
				//print_r("<pre>");
				//print_r($product_details);
				//print_r($db->getLastQuery());
				//print_r("</pre>");
				header("location: ../Member/main_menu.php");
			}
			else if ($_SESSION['role']=="Operation")
			{
				$db->where("tbl_staff.login_id",$results[0]['login_id'] );
				$results1 =$db->get("tbl_staff");
				$_SESSION['user_id']=$results1[0]['staff_id'];
				header("location: ../Operation/order_list.php");
			}
			else if ($_SESSION['role']=="Management")
			{
				$db->where("tbl_staff.login_id",$results[0]['login_id'] );
				$results1 =$db->get("tbl_staff");
				$_SESSION['user_id']=$results1[0]['staff_id'];
				header("location: ../Management/management_dashboard.php");
			}
			//print_r ($_SESSION['user_id']);
			//print_r ($_SESSION['role']);
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
												<h2 class="top-title"> FoodEdge : Login</h2>
											
												<hr>
											</div>
										</div>
									</div>
                                    <p class="text-muted mb-4 mt-3">Please enter your email address and password.</p>
                                </div>

                                <form method="post" class="parsley-examples" >

                                    <div class="form-group mb-3">
                                        <label for="useremail">User Email</label>
										 <input class="form-control" type="email" id="useremail" name="useremail"  placeholder="Enter your email"required>
                                  
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
									
                                    

                                    

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block"id="btnSave"  name="btnSave"  type="submit"> Log In </button>
                                    </div>
									
									

                                </form>

                               

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="ForgetPassword1.php" class="text-white-50 ml-1">Forgot your password?</a></p>
                                <p class="text-white-50">Don't have an account? <a href="register.php" class="text-white ml-1"><b>Sign Up</b></a></p>
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