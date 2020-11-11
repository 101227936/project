<?php
require "../Database/init.php";
require "../encrypt.php";
ob_start();
session_start();
error_reporting(0);

if(empty($_SESSION['user_id']))header("Location: ../Landing/landing.php");
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
            if(isset($_POST['btnSubs']))
            {
                $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                $db->where("u.user_id",$_SESSION['user_id'] ,"=");
                $rows = $db->getOne ("tbl_user u");
                $user_email = $rows['email'];

                $db->where("subscribe_email","$user_email","=");
                $order = $db->getOne("tbl_subscribe");
                
                if(sizeof($order)!=0)
                {
                    echo "<script> alert('Email already esixt.');location='subscribe_newsletter.php'</script>";
                }
                else{
                    $data = Array (
                        'subscribe_email' => $user_email
                    );
                    if ($db->insert ('tbl_subscribe', $data))
                    {
                        $data2 = Array (
                            'newsletter_status' => "Active"
                        );
                        $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                        $db->where("u.user_id",$_SESSION['user_id'] ,"=");
                        $rows = $db->getOne ("tbl_user u");
                        if($db->update ('tbl_user', $data2))
                        {
                            echo "<script> alert('Subscribe successfully');location='subscribe_newsletter.php'</script>";
                        }
                        else
                        {
                            echo 'Subscribe failed: ' . $db->getLastError();
                        }
                    }
                    else
                        echo 'Subscribe failed: ' . $db->getLastError();
                }
            }
            if(isset($_POST['btnSubsU']))
            {
                $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                $db->where("u.user_id",$_SESSION['user_id'] ,"=");
                $rows = $db->getOne ("tbl_user u");
                $user_email = $rows['email'];

                $db->where("subscribe_email",$user_email,"=");
                if ($db->delete ('tbl_subscribe'))
                {
                    $data2 = Array (
                        'newsletter_status' => "Inactive"
                    );
                    $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                    $db->where("u.user_id",$_SESSION['user_id'] ,"=");
                    $rows = $db->getOne ("tbl_user u");
                    if($db->update ('tbl_user', $data2))
                    {
                        echo "<script> alert('Unsubscribe successfully');location='subscribe_newsletter.php'</script>";
                    }
                    else
                    {
                        echo 'Unscribe failed: ' . $db->getLastError();
                    }
                }
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
                                    <h4 class="page-title">Subscribe Newsletter</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-2 col-xl-2">
                            </div>
                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box text-center">
                                    <?php
                                        $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                                        $db->where("u.login_id", 3);
                                        $rows = $db->getOne ("tbl_user u");
                                        $user_email = $rows['email']; 

                                    $db->where("subscribe_email",$user_email,"=");
                                    $order = $db->getOne("tbl_subscribe");
                                    
                                    if(sizeof($order)!=0)
                                    {
                                        ?>
                                            <h2 class="text-center">Thank You for Subscribing!</h2>
                                            <h4 style="color:grey" class="text-center">*You can unsubscribe anytime you want</h4>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <h2 class="text-center">SUBSCRIBE to our newsletter</h2>
                                            <h4 style="color:grey" class="text-center">*We are using your current email address to sign up so you will receive news and updates</h4>
                                        <?php
                                    }
                                    ?>
                                    
                                    <form method="post" action="" id="useraForm" class="parsley-examples" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <?php
                                                $db->join("tbl_login l", "l.login_id=u.login_id", "INNER");
                                                $db->where("u.user_id",$_SESSION['user_id'] ,"=");
                                                $rows = $db->getOne ("tbl_user u");
                                                $user_email = $rows['email']; 

                                                $db->where("subscribe_email",$user_email,"=");
                                                $order = $db->getOne("tbl_subscribe");

                                                if(sizeof($order)!=0)
                                                {
                                                    ?>
                                                    <input type="submit" id="btnSubsU" name="btnSubsU" class="btn btn-danger waves-effect waves-light mt-3 width-xl" value="UNSUBSCRIBE">
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <input type="submit" id="btnSubs" name="btnSubs" class="btn btn-success waves-effect waves-light mt-3 width-xl" value="SUBSCRIBE">
                                                    <?php
                                                }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                            </div>
                                        </div> <!-- end row -->
                                    </form>
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->
                            <div class="col-lg-2 col-xl-2">
                            </div>
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