<?php
	include '../Database/init.php';
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
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Main Menu</li>
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
                                        <div class="col-lg-8">
                                            <form class="form-inline" action="search.php" method="POST">
                                                <div class="form-group">
                                                    <label for="inputPassword2" class="sr-only">Search</label>
                                                    <input type="search" name="search" class="form-control" id="inputPassword2" placeholder="Search...">
													<input type="submit" name="submit" class="btn btn-light waves-effect">
                                                </div>
												<div
													<?php
														if(isset($_POST['search']))
														{
															$searchq=$_POST['search'];
															$searchq=preg_replace("#[^0-9a-z]#i","",$searchq);
															
															$query=mysql_query("SELECT * FROM tbl_product WHERE product_name LIKE '%$searchq%'");
															$count=mysql_num_rows($query);
															if($count == 0)
															{
																$output='No result';
															}
															else
															{
																while($row=mysql_fetch_array($query))
																{
																	$product=$row['product_name'];
																	
																	$output .= '<div>'.$product.'</div>';		
																}
															}
														}
													?>
												</div>
                                                <div class="form-group mx-sm-3">
                                                    <label for="status-select" class="mr-2">Sort By</label>
                                                    <select class="custom-select" id="status-select">
                                                        <option selected="">All</option>
                                                        <option value="1">Popular</option>
                                                        <option value="2">Price Low</option>
                                                        <option value="3">Price High</option>
                                                        <option value="4">Sold Out</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div> <!-- end row -->
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->

                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
									<?php							
										$db->where("product_id ='1'");
										$rows = $db->getOne("tbl_product");										
									?>
									
                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid"/>
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>										
												
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '2'");
															$rows = $db->getOne("tbl_order_detail");
															echo $rows['rating'];
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '1'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>												
												</h5>
												<h6 class="my-2"> 
													<?php 
														$db->where("product_id = '1'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
													RM
                                                    <?php 
														$db->where("product_detail_id = '1'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
                                    <?php							
										$db->where("product_id ='2'");
										$rows = $db->getOne("tbl_product");
									?>													

                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '2'");
															$rows = $db->getOne("tbl_order_detail");
															echo $rows['rating']
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '2'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>
												</h5>
												<h6> 
													<?php 
														$db->where("product_id = '2'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
													RM
                                                    <?php 
														$db->where("product_detail_id = '4'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
									<?php							
										$db->where("product_id ='3'");
										$rows = $db->getOne("tbl_product");
									?>

                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '3'");
															$rows = $db->getOne("tbl_order_detail");
															echo $rows['rating']
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '3'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>
												</h5>
												<h6> 
													<?php 
														$db->where("product_id = '3'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    RM
													<?php 
														$db->where("product_detail_id = '7'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
									<?php							
										$db->where("product_id ='4'");
										$rows = $db->getOne("tbl_product");
									?>

                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '4'");
															$rows = $db->getOne("tbl_order_detail");
															echo $rows['rating']
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '4'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>
												</h5>
												<h6 class="my-1"> 
													<?php 
														$db->where("product_id = '4'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    RM
													<?php 
														$db->where("product_detail_id = '10'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->


                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
									<?php							
										$db->where("product_id ='5'");
										$rows = $db->getOne("tbl_product");
									?>

                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '5'");
															$rows = $db->getOne("tbl_order_detail");
															echo $rows['rating']
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '5'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>
												</h5>
												<h6> 
													<?php 
														$db->where("product_id = '5'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    RM
													<?php 
														$db->where("product_detail_id = '13'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
									<?php							
										$db->where("product_id ='6'");
										$rows = $db->getOne("tbl_product");
									?>

                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '6'");
															$rows = $db->getOne("tbl_order_detail");
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '6'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>
												</h5>
												<h6> 
													<?php 
														$db->where("product_id = '6'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    RM
													<?php 
														$db->where("product_detail_id = '17'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box product-box">
                                    <?php							
										$db->where("product_id ='7'");
										$rows = $db->getOne("tbl_product");
									?>

                                    <div class="bg-light">
                                        <img src="../<?php echo $rows['product_image']?>" alt="product-pic" class="img-fluid" />
                                    </div>

                                    <div class="product-info">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="font-16 mt-0 sp-line-1"><a href="product_detail1.php?product_id=<?=$rows["product_id"]?>" class="text-dark"><?php echo $rows['product_name']?></a></h5>
                                                <div class="text-warning mb-2 font-13">
                                                    Rating:
													<?php 
															$db->where("product_id = '7'");
															$rows = $db->getOne("tbl_order_detail");
															echo $rows['rating']
													?>
                                                </div>
                                                <h5 class="m-0"> 
													<span class="text-muted"> 
														Category:
														<?php 
															$db->where("product_id = '7'");
															$rows = $db->getOne("tbl_product");
															echo $rows['product_type']
														?>
													</span>
												</h5>
												<h6 class="my-2"> 
													<?php 
														$db->where("product_id = '7'");
														$rows = $db->getOne("tbl_product");
														echo $rows['product_description']
													?>																								
												</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="product-price-tag">
                                                    RM
													<?php 
														$db->where("product_detail_id = '19'");
														$rows = $db->getOne("tbl_product_detail");
														echo $rows['product_detail_price']
													?>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end product info-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->		

                        <div class="row">
                            <div class="col-12">
                                <ul class="pagination pagination-rounded justify-content-end mb-3">
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
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