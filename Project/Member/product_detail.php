<?php
	include '../Database/init.php';
	ob_start();
	if(empty($_GET['product_detail_id']))header("Location: main_menu.php");
	else
	{
		$db->join("tbl_product", "tbl_product_detail.product_id=tbl_product.product_id", "LEFT");
		$db->where("tbl_product_detail.product_detail_id",$_GET['product_detail_id'],"=");
		$cols = Array("*");
		$product_detail = $db->getOne("tbl_product_detail", null, $cols);
		if($product_detail['product_detail_status']=="Not Available")header("Location: main_menu.php");
		//else
		//{
		//	print_r("<pre>");
		//	print_r($product_detail);
		//	print_r($db->getLastQuery());
		//	print_r("</pre>");
		//}
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Product Details | UBold - Responsive Admin Dashboard Template</title>
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
        <!-- third party css end -->

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

            <?php include "member_topbar.php";?>
			<?php include "member_topnav.php";?>

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
                                    <h4 class="page-title">Product Detail</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-lg-5">											

                                            <div class="tab-content pt-0">
                                                <div class="tab-pane active show" id="product-1-item">
                                                    <img src="<?php echo $product_detail['product_image']?>" alt="" class="img-fluid mx-auto d-block rounded">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-lg-7">
                                            <div class="pl-xl-3 mt-3 mt-xl-0">
                                                <p class="mb-1"><?php echo $product_detail['product_type']?></p>
                                                <h4 class="mb-3"><?php echo $product_detail['product_name']?></h4>
                                                <p class="text-warning mb-2 font-13">
                                                    Rating:
													<?php
														$cols = Array("AVG(rating) as rating");
														$db->groupBy ("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
														$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
														$db->where("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
														$rating = $db->getOne("tbl_order_detail", null, $cols);
													?>
													<?=isset($rating['rating'])? $rating['rating']:'-'?>
                                                </p>
                                                
                                                <h4 class="mb-4">Price : RM
													</span> <b>
													<?php echo $product_detail['product_detail_price']?></h4>
													</b>
												</h4>

                                                <p class="text-muted mb-4">
													<?php echo $product_detail['product_detail_description']?></h4>
												</p>
												
											
													<form class="form-inline mb-4 parsley-examples" action="cart.php?action=add&id=<?php echo $product_detail['product_id'];?>" method="POST" >
														<div class="form-group">
															<label for="quantity">Quantity<span class="text-danger">*</span>: </label>
															<input type="text" class="form-control" id="quantity" name="quantity" required="" data-parsley-type="digits" data-parsley-min="1" placeholder="Min value is 1" value="1">
															<input type="hidden" name="image" value="<?php echo $product_detail['product_image']?>">
															<input type="hidden" name="name" value="<?php echo $product_detail['product_name']?>">				
															<input type="hidden" name="price" value="<?php echo $product_detail['product_detail_price']?>">				
															<input type="hidden" name="size" value="<?php echo $product_detail['product_detail_size']?>">				
														</div>
														<div class="form-group">
															<input type="submit" class="form-control btn btn-warning waves-effect waves-light" value="Add to cart">
														</div>
														
													</form>
											

                                                
												
												<div>
													<div>
														<h4 class="mb-2 mt-5 font-16">Reviews</h4>

														<div class="clerfix"></div>
														
														<div class="media">
															<div class="media-body">	
																
																	<?php
																		$cols = Array("rating, comment");
																		$db->groupBy ("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
																		$db->where("tbl_order_detail.rating", NULL,"IS NOT");
																		$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
																		$db->where("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
																		$ratings = $db->get("tbl_order_detail", null, $cols);
																		if(sizeof($ratings)==0)echo "No review yet";
																		else
																		{
																			?>
																			<table id="basic-datatable" class="table dt-responsive nowrap w-100">
																				<thead>
																					<tr>
																						<th>Rating</th>
																						<th>Comment</th>
																					</tr>
																				</thead>
																				<tbody>
																				<?php
																			
																					foreach($ratings as $rating)
																					{
																						?>
																						<tr>
																							<td><?=$rating['rating']?></td>
																							<td><?=$rating['comment']?></td>
																						</tr>
																						<?php
																					}
																				?>
																				</tbody>
																		</table>
																		<?php
																		}
																	?>																	
															</div>
														</div>
													</div> 
												</div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->
						
                        
                        </div> <!-- end col -->
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include "member_footer.php";?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        </div>
        <!-- /Right-bar -->
		<?php include "member_rightsidebar.php";?>
		
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

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
		
		
        
    </body>
</html>