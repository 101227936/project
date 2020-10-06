<?php
	include '../Database/init.php';
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
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Main Menu</a></li>
                                            <li class="breadcrumb-item active">Product Detail</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Product Detail</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

						<?php	
							//$db->join("tbl_product", "tbl_product_detail.product_id=tbl_product.product_id", "LEFT");
							$db->where("tbl_product.product_id",$_GET['product_id'],"=");						
							$product = $db->getOne("tbl_product");
							//$products = $db->getOne("tbl_product_detail");
						?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-lg-5">											

                                            <div class="tab-content pt-0">
                                                <div class="tab-pane active show" id="product-1-item">
                                                    <img src="../<?php echo $product['product_image']?>" alt="" class="img-fluid mx-auto d-block rounded">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-lg-7">
                                            <div class="pl-xl-3 mt-3 mt-xl-0">
                                                <p class="mb-1"><?php echo $product['product_type']?></p>
                                                <h4 class="mb-3"><?php echo $product['product_name']?></h4>
                                                <p class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
														$db->where("tbl_order_detail.product_id",$_GET['product_id'],"=");		
														$product = $db->getOne("tbl_order_detail");
														echo $product['rating'];
													?>
                                                </p>
                                                
                                                <h4 class="mb-4">Price : RM
													</span> <b>
													<?php 
														$db->where("tbl_product_detail.product_id",$_GET['product_id'],"=");		
														$product = $db->getOne("tbl_product_detail");
														echo $product['product_detail_price'];
													?>
													</b>
												</h4>

                                                <p class="text-muted mb-4">
													<?php 	
														$db->where("tbl_product_detail.product_id",$_GET['product_id'],"=");		
														$product = $db->getOne("tbl_product_detail");
														echo $product['product_detail_desctiption'];
													?>
												</p>
                                                
                                                <form class="form-inline mb-4">
													<label class="my-1 mr-2" for="example-number">Quantity</label>
                                                    <input class="form-control my-2 mr-sm-3" id="example-number" type="number" name="number" min="1">

                                                    <label class="my-1 mr-2" for="sizeinput">Size</label>
                                                    <select class="custom-select my-1 mr-sm-3" id="sizeinput">
                                                        <option selected>Small</option>
                                                        <option value="1">Medium</option>
                                                        <option value="2">Large</option>
                                                    </select>
													
													<label class="my-1 mr-2" for="sizeinput"></label>
													<?php 	
														$db->where("tbl_product_detail.product_id",$_GET['product_id'],"=");															
														$product = $db->getOne("tbl_product_detail");														
														if($product['product_detail_status'] == "Not available")
														{
															echo "This product is not available";
														}
													?>
                                                </form>

                                                <div>                                                 
                                                    <button type="button" class="btn btn-success waves-effect waves-light">
                                                        <span class="btn-label"><i class="mdi mdi-cart"></i></span>Add to cart
                                                    </button>
                                                </div>
												
												<div>
													<div>
														<h4 class="mb-2 mt-5 font-16">Reviews</h4>

														<div class="clerfix"></div>
														
														<div class="media">
															<div class="media-body">															
																	<?php 	
																		$db->where("tbl_order_detail.product_id",$_GET['product_id'],"=");		
																		$product = $db->getOne("tbl_order_detail");

																		if(empty($product['comment']))
																			echo "No review yet";
																		else
																			echo $product['comment'];
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

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
        
    </body>
</html>