<?php
	require "../Database/init.php";
	ob_start();
	if(!empty($_GET['search']))$db->where ("tbl_product_redeem.product_redeem_name", '%'.$_GET['search'].'%', 'like');
	if(!empty($_GET['type']))$db->where ("tbl_product_redeem.product_redeem_type", $_GET['type'], '=');
	$db->where("tbl_product_redeem.product_redeem_status","Available","=");
	
	if(!empty($_GET['page']))$page = $_GET['page'];
	else $page = 1;
	$db->pageLimit = 4;
	$product_redeem_details = $db->arraybuilder()->paginate("tbl_product_redeem", $page);		
	//print_r("<pre>");
	//print_r($product_redeem_details);
	//print_r($db->getLastQuery());
	//print_r("</pre>");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Ecommerce Products | UBold - Responsive Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

	    <!-- App css -->
	    <link href="../assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	    <link href="../assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	    <link href="../assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
	    <link href="../assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

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
                                <div class="page-title-box">
                                    <h4 class="page-title">Redeem Main Menu</h4>
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
													$cols = Array("product_redeem_type");
													$product_redeem_types = $db->get("tbl_product_redeem", null, $cols);
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
															
															foreach($product_redeem_types as $product_redeem_type)
															{
																if($product_redeem_type['product_redeem_type'] == $_GET['type'])
																{
																?>
																	<option selected="" value="<?=$product_redeem_type['product_redeem_type']?>"><?=$product_redeem_type['product_redeem_type']?></option>
																<?php
																}
																else
																{
																?>
																	<option value="<?=$product_redeem_type['product_redeem_type']?>"><?=$product_redeem_type['product_redeem_type']?></option>
																<?php
																}
															}
														?>
                                                    </select>
                                                </div>
												<div class="form-group mx-sm-3">
                                                    <input type="submit" class="btn btn-warning waves-effect waves-light" value="Search">
													<label for="status-select" class="mr-2"></label>
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
								foreach($product_redeem_details as $product_redeem_detail)
								{
									//print_r("<pre>");
									//print_r($product_details);
									//print_r($db->getLastQuery());
									//print_r("</pre>");
									?>
									 <div class="col-md-6 col-xl-3">
										<div class="card-box product-box">
											<div class="bg-light">
												<img src="<?=$product_redeem_detail['product_redeem_image']?>" alt="product-pic" class="img-fluid"/>
											</div>

											<div class="product-info">
												<div class="row align-items-center">
													<div class="col">
														<h5 class="font-16 mt-0 sp-line-1"><a href="product_redeem_detail.php?product_redeem_id=<?=$product_redeem_detail["product_redeem_id"]?>" class="text-dark"><?php echo $product_redeem_detail['product_redeem_name']?></a></h5>										
														
														<div class="text-warning mb-2 font-13">
															Rating:
															<?php
																$cols = Array("AVG(rating) as rating");
																$db->groupBy ("tbl_order_detail.product_detail_id",$product_redeem_detail['product_redeem_id'],"=");
																$db->where("tbl_order_detail.product_id",0,"=");
																$db->where("tbl_order_detail.product_detail_id",$product_redeem_detail['product_redeem_id'],"=");
																$rating = $db->getOne("tbl_order_detail", null, $cols);
															
															?>
															<?=isset($rating['rating'])? $rating['rating']:'-'?>
														</div>
														<h5 class="m-0"> 
															<span class="text-muted"> 
																Category:
																<?=$product_redeem_detail['product_redeem_type']?>
															</span>												
														</h5>
														<h6 class="my-2"> 
															<?=$product_redeem_detail['product_redeem_description']?>															
														</h6>
													</div>
													<div class="col-auto">
														<div class="product-price-tag">
															<?=$product_redeem_detail['product_redeem_point']?>	
														</div>
													</div>
												</div> <!-- end row -->
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
												<a class="page-link" href="main_menu_redeem.php?<?=(empty($_GET['search'])&&empty($_GET['type']))? 'page='.($page-1):(($db->totalPages>$page)? 'page='.($page)-1:'page=1').((!empty($_GET['search']))?'&search='.$_GET['search']:'').((!empty($_GET['type']))?'&type='.$_GET['type']:'')?>" aria-label="Previous">
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
										<li class="page-item <?=($x==$page)? 'active':''?>"><a class="page-link" href="main_menu_redeem.php?<?=(empty($_GET['search'])&&empty($_GET['type']))? 'page='.($x):(($db->totalPages>1)? 'page='.$x:'page=1').((!empty($_GET['search']))?'&search='.$_GET['search']:'').((!empty($_GET['type']))?'&type='.$_GET['type']:'')?>"><?=$x?></a></li>
										<?php
									}
									?>
									<?php
										if($page<$db->totalPages)
										{
											?>
											<li class="page-item">
												<a class="page-link" href="main_menu_redeem.php?<?=(empty($_GET['search'])&&empty($_GET['type']))? 'page='.(($page+1)):(($db->totalPages>1)? 'page='.($page+1):'page=1').((!empty($_GET['search']))?'&search='.$_GET['search']:'').((!empty($_GET['type']))?'&type='.$_GET['type']:'')?>" aria-label="Next">
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