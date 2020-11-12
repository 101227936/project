<?php require "../Database/init.php";session_start();require "../encrypt.php";?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <title>My Account</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/FoodEdge.ico">
		
		<!-- third party css -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

	    <!-- App css -->
	    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	    <link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
	    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

	    <!-- icons -->
	    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	    
	    <style>
        .account_row:hover {
            background-color: #f5f5f5;
        }
        </style>

    </head>

    <body>
		<?php
			$db->join("tbl_login", "tbl_login.login_id=tbl_staff.login_id", "INNER");
			$db->where("tbl_staff.staff_id", $_SESSION['user_id']);
			$rows = $db->getOne ("tbl_staff");
		?>
		<?php
            if(isset($_POST['accountName'])&&isset($_POST['accountPhone'])&&isset($_POST['accountAddress'])&&isset($_POST['accountEmail']))
			{
                if($_FILES['image']['size']!=0)
                {
					if($rows['staff_profile'] != "../Image/Profile/default.png")unlink($rows['staff_profile']);
					
					$random_Name = date("YmdHis");
                    $file_name = "../Image/Profile/".$random_Name.'.'.explode("/",$_FILES['image']['type'])[1];
                    $file_size =$_FILES['image']['size'];
                    $file_tmp =$_FILES['image']['tmp_name'];
                    $file_type=$_FILES['image']['type'];
                    if($file_size > 2097152){
                        echo "<script> alert('File size must be excately 2 MB');location='account_detail.php?account_id=".$_GET['account_id']."'</script>";
                    }
					else move_uploaded_file($file_tmp,$file_name);
				}
				else $file_name = $rows['staff_profile'];
				$data = Array (
				   'email' => trim($_POST['accountEmail'])
				);
				$db->where("tbl_login.login_id",$rows['login_id']);
				$id = $db->update ('tbl_login', $data);
				$data = Array (
				   'staff_profile' => $file_name,
				   'staff_name' => $_POST['accountName'],
				   'staff_phone' => $_POST['accountPhone'],
				   'staff_address' => $_POST['accountAddress']
				);
				$db->where("tbl_staff.staff_id",$rows['staff_id']);
				$id = $db->update ('tbl_staff', $data);
				
				if(strlen(trim($_POST['pass1']))>0)
				{
					$data = Array (
					   'password' => encrypt_decrypt("encrypt",trim($_POST['pass1'])),
					);
					$db->where("tbl_login.login_id",$rows['login_id']);
					$id = $db->update ('tbl_login', $data);
				}
				
				
				echo "<script> alert('Update Successful');location='profile.php'</script>";
			}
		?>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include "topbar.php"?>
			<?php include "sidebar.php"?>

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">My Account</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <img src="<?php echo $rows['staff_profile']?>" width="196" height="196" alt="profile-image">

                                    <div class="text-left mt-3">

                                        <p class="text-muted mb-4 font-16"><strong>Name &emsp;&emsp;<span class="ml-3">:</span></strong><span class="ml-2"><?php echo $rows['staff_name']?></span></p>

                                        <p class="text-muted mb-4 font-16"><strong>Email &emsp;&ensp;<span class="ml-4">:</span></strong><span class="ml-2"><?php echo $rows['email']?></span></p>

                                        <p class="text-muted mb-4 font-16"><strong>Mobile &emsp;<span class="ml-4">:</span></strong><span class="ml-2 "><?php echo $rows['staff_phone']?></span></p>

                                        <p class="text-muted mb-3 font-16"><strong>Address &emsp;<span class="ml-3">:</span></strong><span class="ml-2"><?php echo $rows['staff_address']?></span></p>

                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->

                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                                <h3>Update Your Information Here</h3>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="settings">
                                            <form method="post" action="" id="userForm" class="parsley-examples" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image">Upload Your Photo(Less than 2MB)</label>
                                                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                                                        </div>
                                                    </div> <!-- end col -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name">Your Name<span class="text-danger">*</span></label>
                                                            <input type="text" name="accountName" parsley-trigger="change" required placeholder="Enter your new name" class="form-control" id="accountName" value="<?php echo $rows['staff_name']?>">
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="userEmail">Email address<span class="text-danger">*</span></label>
                                                            <input type="email" name="accountEmail" parsley-trigger="change" data-parsley-trigger="keyup" data-parsley-remote data-parsley-remote-validator='validate' data-parsley-remote-message="Email already used" required placeholder="Enter your new email" class="form-control" id="accountEmail" value="<?php echo $rows['email']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="userPhone">Mobile<span class="text-danger">*</span></label>
                                                            <input type="type" name="accountPhone" data-parsley-type="digits" data-parsley-length="[10,11]" parsley-trigger="change" required placeholder="Enter your new mobile number" class="form-control" id="accountPhone" value="<?php echo $rows['staff_phone']?>">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
												<div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="userAddress">Address<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="accountAddress" name="accountAddress" rows="2" parsley-trigger="change" required placeholder="Enter your new address"><?php echo $rows['staff_address']?></textarea>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
												<label style="color:red;"><u>*If you don't want to change password, let it be EMPTY*</u></label><br>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<div class="form-group">
																<label for="pass1">Password</label>
																<input id="pass1" type="password" name="pass1" placeholder="Password"
																	   class="form-control">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="passWord2">Confirm Password</label>
															<input data-parsley-equalto="#pass1" type="password"  name="pass2"
																   placeholder="Password" class="form-control" id="passWord2">
														</div>
													</div>
												</div>
                                                <div class="text-center">
                                                    <input type="submit" onclick="return confirm('Are you sure?')" id="btnSave" name="btnSave" class="btn btn-success waves-effect waves-light mt-2 width-xl" value="Update">
											   </div>
                                            </form>
                                        </div>
                                        <!-- end settings content-->

                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include "footer.php"?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
		
		<script>
		var uploadField = document.getElementById("image");

		uploadField.onchange = function() {
			if(this.files[0].size > 2097152){
			   alert("File is too big!");
			   this.value = "";
			};
		};
		</script>

        <!-- Right Sidebar -->
        <?php include "right_sidebar.php"?>
        <!-- /Right-bar -->

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <!-- third party js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="../assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="../assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script src="../assets/js/pages/datatables.init.js"></script>
		
		<!-- Plugin js-->
        <script src="../assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="../assets/js/pages/form-validation.init.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
		
		<script>
			$("#add_operation").parsley();
			window.Parsley.addAsyncValidator('validate', function (xhr) {
				return 200 === xhr.status;
			}, 'check_duplicate.php?email=<?=$rows['email']?>');
		</script>
        
    </body>
</html>
