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

    </head>

    <body data-layout-mode="horizontal">

        <!-- Begin page -->
        <div id="wrapper">
			<?php include "member_topbar.php"?>
			<?php include "member_topnav.php"?>
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
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                                            <li class="breadcrumb-item active">Orders</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Orders</h4>
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
                                                        <th>Order ID</th>
														<th>Remark</th>
                                                        <th>Products</th>
                                                        <th>Date Order</th>
														<th>Date Delivery</th>
														<th>Days</th>
                                                        <th>Payment Status</th>
                                                        <th>Total</th>
                                                        <th>Order Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														$db->join("tbl_payment", "tbl_order.order_id=tbl_payment.order_id", "LEFT");
														$db->join("tbl_user", "tbl_user.user_id=tbl_order.user_id", "INNER");
														$db->where("tbl_user.user_id", 1);
														$orders = $db->get("tbl_order");
														foreach($orders as $order)
														{
															$db->join("tbl_product_detail", "tbl_order_detail.product_detail_id=tbl_product_detail.product_detail_id", "LEFT");
															$db->join("tbl_product", "tbl_order_detail.product_id=tbl_product.product_id", "LEFT");
															$db->where("order_id",$order["order_id"],"=");
															$db->where("tbl_order_detail.product_id",0,">");
															$db->groupBy ("product_name");
															$cols = Array ("*","ABS(TIMESTAMPDIFF(DAY,now(),'".$order["modified_datetime"]."')) as day" , "sum(tbl_product_detail.product_detail_price) as total");
															$order_details = $db->get("tbl_order_detail",null, $cols);
															//print_r("<pre>");
															//print_r($order_details);
															//print_r($db->getLastQuery());
															//print_r("</pre>");
															?>
															<tr>
																<td><a href="order_detail.php?order_id=<?=$order["order_id"]?>" class="text-body font-weight-bold">#<?=$order["order_id"]?></a> </td>
																<td>
																	<?=$order["remark"]?>
																</td>
																<td>
																	<?php
																		foreach($order_details as $order_detail)
																		{
																			?>
																			<img src="../<?=$order_detail['product_image']?>" alt="product-img" height="32" />
																			<?php
																		}
																	?>
																</td>
																<td>
																	<?=$order["order_datetime"]?>
																</td>
																<td>
																	<?=$order["modified_datetime"]?>
																</td>
																<td>
																	<?=$order_detail["day"]?>
																</td>
																<td>
																	<h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-coin"></i> <?=$order["payment_status"]?></span></h5>
																</td>
																<td>
																	<?=$order_detail["total"]?>
																</td>
																<td>
																	<h5><span class="badge badge-info"><?=$order["order_status"]?></span></h5>
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

                <?php include "member_footer.php"?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
		
		<?php include "member_rightsidebar.php"?>

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