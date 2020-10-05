<?php
require "../Database/init.php";
require "../encrypt.php";

error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Profile | UBold - Responsive Admin Dashboard Template</title>
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

    <body data-layout-mode="horizontal">
        <?php
            if($_POST['btnSave'])
            {
                $test = encrypt_decrypt("encrypt",trim($_POST['password']));
                //echo '<script>alert("Haha")</script>'; 
                $data = Array (
                    'user_name' =>trim($_POST['name']),
                    'user_phone' => trim($_POST['userPhone']),
                    'user_address' => trim($_POST['userAddress']),
                    'email' => trim($_POST['userEmail']),
                    'password' => $test
                );
                $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                $db->where ('u.login_id', 3);
                if ($db->update ('tbl_user u', $data))
                    echo "<script> alert('Save change');location='Customer_profile.php'</script>";
                else
                    echo 'update failed: ' . $db->getLastError();
            }
        ?>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include "member_topbar.php";?>
            <!-- end Topbar -->
            <?php include "member_topnav.php";?>
            <!-- end topnav-->

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
                                    <h4 class="page-title">Profile Management</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <?php
                                        $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                                        $db->where("u.login_id", 3);
                                        $rows = $db->getOne ("tbl_user u");
                                    ?>
                                    <img src="../<?php echo $rows['user_profile']?>" width="170" height="170" alt="profile-image">

                                    <div class="text-left mt-3">

                                        <p class="text-muted mb-4 font-16"><strong>Name &emsp;&emsp;<span class="ml-3">:</span></strong><span class="ml-2"><?php echo $rows['user_name']?></span></p>

                                        <p class="text-muted mb-4 font-16"><strong>Email &emsp;&ensp;<span class="ml-4">:</span></strong><span class="ml-2"><?php echo $rows['email']?></span></p>

                                        <p class="text-muted mb-4 font-16"><strong>Mobile &emsp;<span class="ml-4">:</span></strong><span class="ml-2 "><?php echo $rows['user_phone']?></span></p>

                                        <p class="text-muted mb-3 font-16"><strong>Address &emsp;<span class="ml-3">:</span></strong><span class="ml-2"><?php echo $rows['user_address']?></span></p>

                                        <p class="text-muted mb-3 font-16"><strong>Reward Point :</strong><span class="ml-2"><?php echo $rows['user_reward']?></span></p>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->

                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                                <h3>Update Your Profile Here</h3>
                                                <hr>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="settings">
                                            <form method="post" action="" id="userForm" class="parsley-examples">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name">Your Name<span class="text-danger">*</span></label>
                                                            <input type="text" name="name" parsley-trigger="change" required placeholder="Enter your name" class="form-control" id="name" value="<?php echo $rows['user_name']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php $output = encrypt_decrypt("decrypt",trim($rows['password']));?>
                                                            <label for="password">Password<span class="text-danger">*</span></label>
                                                            <input type="password" name="password" parsley-trigger="change" required placeholder="Enter new password" class="form-control" id="password" value="<?php echo $output?>">
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="userAddress">Address<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="userAddress" name="userAddress" rows="4" parsley-trigger="change" required placeholder="Enter your new address..."><?php echo $rows['user_address']?></textarea>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="userEmail">Email address<span class="text-danger">*</span></label>
                                                            <input type="email" name="userEmail" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="userEmail" value="<?php echo $rows['email']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="userPhone">Mobile<span class="text-danger">*</span></label>
                                                            <input type="type" name="userPhone" data-parsley-type="digits" data-parsley-length="[10,11]" parsley-trigger="change" required placeholder="Enter new phone number" class="form-control" id="userPhone" value="<?php echo $rows['user_phone']?>">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->

                                                <div class="text-center">
                                                    <input type="submit" id="btnSave" name="btnSave" class="btn btn-success waves-effect waves-light mt-2 width-xl" value="Update">
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
                <?php include "member_footer.php"?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <?php include "member_rightsidebar.php";?>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

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