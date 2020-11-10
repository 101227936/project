<?php require "../Database/init.php"?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <title>Payment List</title>
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
        #ProductTR:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        </style>
    </head>

    <body>

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
                                    <h4 class="page-title">Payment List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Payment ID</th>
														<th>Order ID</th>
                                                        <th>Amount Price (RM)</th>
                                                        <th>Amount Point</th>
                                                        <th>Payment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //$db->join("tbl_product_detail pd", "p.product_id=pd.product_id", "INNER");
                                                    $payments = $db->get("tbl_payment");
                                                    foreach($payments as $payment)
                                                    {
                                                        ?>
                                                        <tr onclick="window.location='payment_detail.php?payment_id=<?=$payment['payment_id']?>'" id="ProductTR">
                                                            <td>#<?=$payment["payment_id"]?></td>
                                                            <td>
                                                                #<?=$payment["order_id"]?>
                                                            </td>
                                                            <td>
                                                                <?=$payment["amount_price"]?>
                                                            </td>
                                                            <td>
                                                                <?=$payment["amount_point"]?>
                                                            </td>
                                                            <?php
                                                            if($payment["payment_status"]=="Waiting for Refund")
                                                            {
                                                                ?>
                                                                <td>
                                                                    <span class="badge badge-info badge-warning"><?=$payment["payment_status"]?></span></td>
                                                                </td>
                                                                <?php
                                                            }
                                                            else if($payment["payment_status"]=="Refunded")
                                                            {
                                                                ?>
                                                                <td>
                                                                    <span class="badge badge-success badge-success"><?=$payment["payment_status"]?></span></td>
                                                                </td>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <td>
                                                                    <span class="badge badge-info badge-success"><?=$payment["payment_status"]?></span></td>
                                                                </td>
                                                                <?php
                                                            }
                                                            ?>
                                                          
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        
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

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
        
    </body>
</html>