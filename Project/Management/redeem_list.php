<?php require "../Database/init.php"?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <title>Ecommerce Orders | UBold - Responsive Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">
		
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
        #ProductRedeemTR:hover {
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
                                    <h4 class="page-title">Product Redeem List</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-lg-12">
                                                <div class="text-lg-right">
                                                    <a href="add_product_redeem.php" class="btn btn-danger waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> Add Product Redeem</a>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Product ID</th>
														<th>Product Image</th>
                                                        <th>Product Name</th>
                                                        <th>Redeem Point</th>
														<th>Product Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //$db->join("tbl_product_detail pd", "p.product_id=pd.product_id", "INNER");
                                                    $products = $db->get("tbl_product_redeem");
                                                    foreach($products as $product)
                                                    {
                                                        ?>
                                                        <tr onclick="window.location='redeem_detail.php?product_redeem_id=<?=$product['product_redeem_id']?>'" id="ProductRedeemTR">
                                                            <td><?=$product["product_redeem_id"]?></td>
                                                            <td>
                                                                <img src="<?=$product['product_redeem_image']?>" alt="product-img" height="100" width="100" />
                                                            </td>
                                                            <td>
                                                                <?=$product["product_redeem_name"]?>
                                                            </td>
                                                            <td>
                                                                <?=$product["product_redeem_point"]?>
                                                            </td>
                                                            <td>
                                                                <?=$product["product_redeem_description"]?>
                                                            </td>
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