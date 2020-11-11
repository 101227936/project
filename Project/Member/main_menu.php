<?php
	require "../Database/init.php";
	ob_start();
	
	$db->join("tbl_product", "tbl_product_detail.product_id=tbl_product.product_id", "LEFT");
	if(!empty($_GET['search']))$db->where ("tbl_product.product_name", '%'.$_GET['search'].'%', 'like');
	if(!empty($_GET['type']))$db->where ("tbl_product.product_type", $_GET['type'], '=');
	$db->where("tbl_product_detail.product_detail_status","Available","=");
	$db->orderBy("tbl_product_detail.product_id", "Desc");
	
	if(!empty($_GET['page']))$page = $_GET['page'];
	else $page = 1;
	$db->pageLimit = 4;
	$product_details = $db->arraybuilder()->paginate("tbl_product_detail", $page);	

	$db->join("tbl_order", "tbl_order_detail.order_id=tbl_order.order_id", "LEFT");
	$db->where("tbl_order.order_status","Cart","=");
	$db->where("tbl_order.user_id", $_SESSION['user_id'],"=");
	$orders = $db->get("tbl_order_detail");
	$no=count($orders);
	
	//print_r("<pre>");
	//print_r($product_details);
	//print_r($db->getLastQuery());
	//print_r("</pre>");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Main Menu</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../Landing/favicon-1.ico">

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
                            <div class="col-10">
                                <div class="page-title-box notification-list mr-1">
									<div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <a href="cart.php" class="action-icon color_animation2"> <i class="fa fa-shopping-cart"></i><span class="badge badge-danger rounded-circle noti-icon-badge"><?php echo $no;?></span></a>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Main Menu</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						
						<div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="row">
										<div class="col-lg-12">
											<form class="form-inline">
												<div class="form-group">
													<label for="inputPassword2" class="sr-only">Search</label>
													<input type="hidden" class="form-control" id="page" name="page" value="1"/>
													<input type="search" class="form-control" id="search" name="search" placeholder="Search..." value="<?=(empty($_GET['search']))? '':$_GET['search']?>">
												</div>
												<?php
													$cols = Array("DISTINCT(product_type)");
													$product_types = $db->get("tbl_product", null, $cols);
												?>
												<div class="form-group mx-sm-3">
                                                    <label for="status-select" class="mr-2">Sort By</label>
                                                    <select class="custom-select" id="type" name="type">
														<?php
															if(empty($_GET['type']))
															{
																?>
																	<option selected="" value="">All</option>
																<?php
															}
															else
															{
																?>
																	<option value="">All</option>
																<?php
															}
															
															foreach($product_types as $product_type)
															{
																if($product_type['product_type'] == $_GET['type'])
																{
																?>
																	<option selected="" value="<?=$product_type['product_type']?>"><?=$product_type['product_type']?></option>
																<?php
																}
																else
																{
																?>
																	<option value="<?=$product_type['product_type']?>"><?=$product_type['product_type']?></option>
																<?php
																}
															}
														?>
                                                    </select>
                                                </div>
												
												<div class="col-lg-1">
													<div class="form-group mx-sm-3">
														<input type="submit" class="btn form-btn" value="Search">
														<label for="status-select" class="mr-2"></label>
													</div>
												</div>
											</form>
										</div>
                                    </div> <!-- end row -->
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->

						<div class="row">
							<?php
								foreach($product_details as $product_detail)
								{
									//print_r("<pre>");
									//print_r($product_details);
									//print_r($db->getLastQuery());
									//print_r("</pre>");
									?>
									 <div class="col-md-6 col-xl-3">
										<div class="card-box product-box">
											<div class="bg-light">
												<img src="<?=$product_detail['product_image']?>" alt="product-pic" class="img-fluid"/>
											</div>

											<div class="product-info">
												<div class="row align-items-center">
													<div class="col">
														<h5 class="font-16 mt-0 sp-line-1"><a href="product_detail.php?product_detail_id=<?=$product_detail["product_detail_id"]?>" class="text-dark"><?php echo $product_detail['product_name']?></a></h5>										
														
														<div class="color2 mb-2 font-13">
															Rating:
															<?php
																$cols = Array("AVG(rating) as rating");
																$db->join("tbl_order", "tbl_order.order_id=tbl_order_detail.order_id", "LEFT");
																$db->where("tbl_order.order_status",'Arrive',"=");
																$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
																$db->where("tbl_order_detail.product_detail_id",$product_detail['product_detail_id'],"=");
																$rating = $db->get("tbl_order_detail", null, $cols);	
															?>
															<?=isset($rating[0]['rating'])? number_format((float)$rating[0]['rating'], 2, '.', ''):'-'?>
														</div>
														<h5 class="m-0"> 
															<span class="text-muted"> 
																Category:
																<?=$product_detail['product_type']?>
															</span>												
														</h5>
														<h6 class="my-2"> 
															<span class="text-muted"> 
																Size:
																<?=$product_detail['product_detail_size']?>
															</span>																	
														</h6>
														<h6 class="my-2"> 
															<?=$product_detail['product_description']?>															
														</h6>
													</div>
													<div class="col-auto">
														<div class="product-price-tag">
															RM<?=$product_detail['product_detail_price']?>	
														</div>
													</div>
													
												</div> <!-- end row -->
												<form action="add_cart.php" method="POST" >
														<input type="hidden" id="product_id" name="product_id"value="<?=$product_detail['product_id']?>">
														<input type="hidden" id="product_detail_id" name="product_detail_id"value="<?=$product_detail['product_detail_id']?>">
														<input type="hidden" id="product_detail_price" name="product_detail_price"value="<?=$product_detail['product_detail_price']?>">
														<input type="hidden" id="quantity" name="quantity" value="1">
														
														<input type="submit" class="form-control btn form-btn color waves-effect waves-light" value="Add to cart">
												</form>
											</div> <!-- end product info-->
										</div> <!-- end card-box-->
									</div> <!-- end col-->

									<?php
								}
							?>
						</div>
					
                        <div class="row">
                            <div class="col-12">
                                <ul class="pagination pagination-rounded justify-content-end mb-3">
									<?php
										if($page>1)
										{
											?>
											<li class="page-item">
												<a class="page-link" href="main_menu.php?<?=(empty($_GET['search'])&&empty($_GET['type']))? 'page='.($page-1):(($db->totalPages>$page)? 'page='.($page)-1:'page=1').((!empty($_GET['search']))?'&search='.$_GET['search']:'').((!empty($_GET['type']))?'&type='.$_GET['type']:'')?>" aria-label="Previous">
													<span aria-hidden="true">«</span>
													<span class="sr-only">Previous</span>
												</a>
											</li>
											<?php
										}
									?>
									<?php
									for ($x = 1; $x <= $db->totalPages; $x++) 
									{
										?>
										<li class="page-item <?=($x==$page)? 'active':''?>"><a class="page-link" href="main_menu.php?<?=(empty($_GET['search'])&&empty($_GET['type']))? 'page='.($x):(($db->totalPages>1)? 'page='.$x:'page=1').((!empty($_GET['search']))?'&search='.$_GET['search']:'').((!empty($_GET['type']))?'&type='.$_GET['type']:'')?>"><?=$x?></a></li>
										<?php
									}
									?>
									<?php
										if($page<$db->totalPages)
										{
											?>
											<li class="page-item">
												<a class="page-link" href="main_menu.php?<?=(empty($_GET['search'])&&empty($_GET['type']))? 'page='.(($page+1)):(($db->totalPages>1)? 'page='.($page+1):'page=1').((!empty($_GET['search']))?'&search='.$_GET['search']:'').((!empty($_GET['type']))?'&type='.$_GET['type']:'')?>" aria-label="Next">
													<span aria-hidden="true">»</span>
													<span class="sr-only">Next</span>
												</a>
											</li>
											<?php
										}
									?>
                                </ul>
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include "member_footer.php";?>

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        
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