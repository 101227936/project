<?php
	require "../Database/init.php";
	ob_start();
	if(empty($_GET['order_id'])||empty($_GET['product_id'])||empty($_GET['product_detail_id'])||empty($_GET['page']))header("Location: order_list.php");
	else
	{
		
		$db->where("product_id",$_GET['product_id'],"=");
		$db->where("product_detail_id",$_GET['product_detail_id'],"=");
		$cols=Array("product_detail_price");
		$order = $db->getOne("tbl_product_detail", null, $cols);
		
		$price = $order['product_detail_price'];
		
		$db->join("tbl_product", "tbl_product_detail.product_id=tbl_product.product_id", "LEFT");
		if(!empty($_GET['search']))$db->where ("tbl_product.product_name", '%'.$_GET['search'].'%', 'like');
		$db->where("tbl_product_detail.product_detail_status","Available","=");
		$db->where("tbl_product_detail.product_id",$_GET['product_id'],"!=");
		$db->where("tbl_product_detail.product_detail_id",$_GET['product_detail_id'],"!=");
		$db->where("tbl_product_detail.product_detail_price",$price,"=");
		
		$page = $_GET['page'];
		$db->pageLimit = 4;
		$product_details = $db->arraybuilder()->paginate("tbl_product_detail", $page);
		//$product_details = $db->get("tbl_product_detail");
		

	}
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
	    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	    <link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
	    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

	    <!-- icons -->
	    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

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
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                                            <li class="breadcrumb-item active">Products</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Products</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						
						<div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="row">
										<div class="col-lg-8">
											<form class="form-inline">
												<div class="form-group">
													<label for="inputPassword2" class="sr-only">Search</label>
													<input type="hidden" class="form-control" id="order_id" name="order_id" value="<?=$_GET['order_id']?>"/>
													<input type="hidden" class="form-control" id="product_id" name="product_id" value="<?=$_GET['product_id']?>"/>
													<input type="hidden" class="form-control" id="product_detail_id" name="product_detail_id" value="<?=$_GET['product_detail_id']?>"/>
													<input type="hidden" class="form-control" id="page" name="page" value="1"/>
													<input type="search" class="form-control" id="search" name="search" placeholder="Search..." value="<?=(empty($_GET['search']))? '':$_GET['search']?>">
												</div>
												<div class="form-group mx-sm-3">
													<input type="submit" class="btn btn-warning waves-effect waves-light" value="Search">
												</div>
											</form>
										</div>
										<div class="col-lg-4">
                                            <div class="text-lg-right mt-3 mt-lg-0">
                                                <a href="order_detail.php?order_id=<?=$_GET['order_id']?>" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-keyboard-backspace mr-1"></i> Back</a>
                                            </div>
                                        </div><!-- end col-->
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

											<div class="product-action">
												<a href="select_alternative_product.php?order_id=<?=$_GET["order_id"]?>&product_id=<?=$_GET['product_id']?>&product_detail_id=<?=$_GET['product_detail_id']?>&select_product_id=<?=$product_detail['product_id']?>&select_product_detail_id=<?=$product_detail['product_detail_id']?>" onclick="return confirm('Are you sure?')" class="btn btn-success btn-xs waves-effect waves-light"><i class="mdi mdi-check"></i></a>
											</div>

											<div class="bg-light">
												<img src="../<?=$product_detail['product_image']?>" alt="product-pic" class="img-fluid" />
											</div>

											<div class="product-info">
												<div class="row align-items-center">
													<div class="col">
														<h5 class="font-16 mt-0 sp-line-1"><a href="ecommerce-product-detail.html" class="text-dark"><?=$product_detail['product_name']?></a> </h5>
													</div>
													<div class="col-auto">
														<div class="product-price-tag">
															RM<?=$product_detail['product_detail_price']?>
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
                        <!-- end row-->
						
                        <div class="row">
                            <div class="col-12">
                                <ul class="pagination pagination-rounded justify-content-end mb-3">
									<?php
										if($page>1)
										{
											?>
											<li class="page-item">
												<a class="page-link" href="alternative_product.php?order_id=<?=$_GET["order_id"]?>&product_id=<?=$_GET['product_id']?>&product_detail_id=<?=$_GET['product_detail_id']?><?=(empty($_GET['search']))? '&page='.($page-1):(($db->totalPages>$page)? '&page='.($page)-1:'&page=1').'&search='.$_GET['search']?>" aria-label="Previous">
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
										<li class="page-item <?=($x==$page)? 'active':''?>"><a class="page-link" href="alternative_product.php?order_id=<?=$_GET["order_id"]?>&product_id=<?=$_GET['product_id']?>&product_detail_id=<?=$_GET['product_detail_id']?><?=(empty($_GET['search']))? '&page='.($x):(($db->totalPages>1)? '&page='.$x:'&page=1').'&search='.$_GET['search']?>"><?=$x?></a></li>
										<?php
									}
									?>
									<?php
										if($page<$db->totalPages)
										{
											?>
											<li class="page-item">
												<a class="page-link" href="alternative_product.php?order_id=<?=$_GET["order_id"]?>&product_id=<?=$_GET['product_id']?>&product_detail_id=<?=$_GET['product_detail_id']?><?=(empty($_GET['search']))? '&page='.(($page+1)):(($db->totalPages>1)? '&page='.($page+1):'&page=1').'&search='.$_GET['search']?>" aria-label="Next">
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

                <?php include "footer.php"?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

		<?php include "right_sidebar.php"?>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
        
    </body>
</html>