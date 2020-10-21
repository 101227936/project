<?php 
	require "../Database/init.php";
	ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Order Details | UBold - Responsive Admin Dashboard Template</title>
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item active">Order Detail</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Order Detail</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						
						<?php
							if(empty($_GET['order_id']))header("Location: order_list.php");
							else
							{
								$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
								$db->join("tbl_payment", "tbl_order.order_id=tbl_payment.order_id", "LEFT");
								$db->where("tbl_order.order_id",$_GET['order_id'],"=");
								$order = $db->getOne("tbl_order");
								//print_r("<pre>");
								//print_r($order);
								//print_r($db->getLastQuery());
								//print_r("</pre>");
							}
						?>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Track Order</h4>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Order ID:</h5>
                                                    <p>#<?=$order["order_id"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Status:</h5>
                                                    <p><?=$order["order_status"]?></p>
                                                </div>
                                            </div>
                                        </div>
										<h4 class="header-title mb-3">Order Information</h4>

                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Remark:</span> <?=$order["remark"]?></p>
                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Order Datetime:</span> <?=$order["order_datetime"]?></p>
                                            </li>
                                        </ul>
										<?php							
										if($order["order_status"]=="Waiting for Confirmation" || $order["order_status"]=="Pending")
										{
											?>
											<a href="order_confirmation.php?order_id=<?=$order["order_id"]?>&action=Accept" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-success waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> Accept</button></a>
											<a href="order_confirmation.php?order_id=<?=$order["order_id"]?>&action=Reject" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-danger waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> Reject</button></a>
											<?php
										}
										else if($order["order_status"]=="Menu Edited")
										{
											?>
											<a href="send_confirmation_email.php?order_id=<?=$order["order_id"]?>" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-warning waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> Change & Send Email</button></a>
											<?php
										}
										else if($order["order_status"]=="Accept")
										{
											?>
											<a href=""><button type="button" class="btn btn-warning waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-basket mr-1"></i> Delivery</button></a>
											<?php
										}
										?>
										<a href="order_list.php"><button type="button" class="btn btn-info waves-effect waves-light mb-2 mr-2"> Back</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Items from Order #<?=$order["order_id"]?></h4>
										
										

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Product name</th>
                                                        <th>Product type</th>
														<th>Product size</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
														<?php
															if($order["order_status"]=="Pending"||$order["order_status"]=="Menu Edited")
															{
																?>
																<th style="width: 125px;">Action</th>
																<?php
															}
														?>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
													$db->join("tbl_product_redeem", "tbl_order_detail.product_detail_id=tbl_product_redeem.product_redeem_id && tbl_order_detail.product_id=0", "LEFT");
													$db->join("tbl_product_detail", "tbl_order_detail.product_detail_id=tbl_product_detail.product_detail_id", "LEFT");
													$db->join("tbl_product", "tbl_order_detail.product_id=tbl_product.product_id", "LEFT");
													$db->where("order_id",$order["order_id"],"=");
													$cols = Array ("*");
													$order_details = $db->get("tbl_order_detail",null, $cols);
													//print_r("<pre>");
													//print_r($order_details);
													//print_r($db->getLastQuery());
													//print_r("</pre>");
													$price_sum=0;
													$point_sum=0;
													foreach($order_details as $order_detail)
													{
														if($order_detail['product_id']==0)$point_sum+=$order_detail['product_redeem_point']*$order_detail['quantity'];
															else $price_sum+=$order_detail['product_detail_price']*$order_detail['quantity'];
														?>
														<tr>
															<th scope="row"><?=($order_detail['product_id']==0)?$order_detail['product_redeem_name']:$order_detail['product_name']?></th>
															<td><?=($order_detail['product_id']==0)?$order_detail['product_redeem_type']:$order_detail['product_type']?></td>
															<td><?=($order_detail['product_id']==0)? "-":$order_detail['product_detail_size']?></td>
															<td><?=$order_detail['quantity']?></td>
															<td><?=($order_detail['product_id']==0)? $order_detail['product_redeem_point']:$order_detail['product_detail_price']?></td>
															<td><?=($order_detail['product_id']==0)?($order_detail['product_redeem_point']*$order_detail['quantity']):($order_detail['product_detail_price']*$order_detail['quantity'])?></td>
															<?php
																if(($order["order_status"]=="Pending"||$order["order_status"]=="Menu Edited") && $order_detail['product_id']>0)
																{
																	?>
																	<td>
																		<a href="alternative_product.php?order_id=<?=$order["order_id"]?>&product_id=<?=$order_detail['product_id']?>&product_detail_id=<?=$order_detail['product_detail_id']?>&page=1"> <i class="mdi mdi-square-edit-outline"></i></a>
																	</td>
																	<?php
																}
																else if($order["order_status"]=="Pending"||$order["order_status"]=="Menu Edited")
																{
																	?>
																	<td>
																		Redeem item cannot be changed
																	</td>
																	<?php
																}
															?>
														</tr>
														<?php
													}
													?>
                                                    <tr>
                                                        <th scope="row" colspan="5" class="text-right">Total (RM):</th>
                                                        <td><div class="font-weight-bold"><?=$price_sum?></div></td>
                                                    </tr>
													<tr>
                                                        <th scope="row" colspan="5" class="text-right">Total point:</th>
                                                        <td><div class="font-weight-bold"><?=$point_sum?></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->  
						 <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Member Information</h4>

                                        <h5 class="font-family-primary font-weight-semibold"><?=$order['user_name']?></h5>
                                        
                                        <p class="mb-2"><span class="font-weight-semibold mr-2">Address:</span> <?=$order['user_address']?></p>
                                        <p class="mb-2"><span class="font-weight-semibold mr-2">Phone:</span> <?=$order['user_phone']?></p>
            
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Billing Information</h4>

                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Payment ID:</span> <?=$order["payment_id"]?></p>
                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Payment Status:</span> <?=$order["payment_status"]?></p>
                                            </li>
                                        </ul>
            
                                    </div>
                                </div>
                            </div> <!-- end col -->
        
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Delivery Info</h4>
            
                                        <div class="text-center">
                                            <p class="mb-1"><span class="font-weight-semibold">Delivery Datetime :</span> <?=$order["delivery_datetime"]?></p>
                                            <p class="mb-0"><span class="font-weight-semibold">Delivery Address :</span> <?=$order["delivery_address"]?></p>
                                        </div>
										<?php
											if($order["order_status"]=="Delivery"||$order["order_status"]=="Arrive")
											{
												?>
												<h4 class="header-title mb-3">Driver Info</h4>
												<div class="list-unstyled mb-0">
													<p class="mb-1"><span class="font-weight-semibold">Driver Name :</span> <?=$order["delivery_name"]?></p>
													<p class="mb-1"><span class="font-weight-semibold">Driver Phone :</span> <?=$order["delivery_phone"]?></p>
													<p class="mb-1"><span class="font-weight-semibold">Driver Car Model :</span> <?=$order["delivery_car_model"]?></p>
													<p class="mb-1"><span class="font-weight-semibold">Driver Car Plate Number :</span> <?=$order["delivery_car_plate_number"]?></p>
												</div>
												<?php
											}
										?>
                                    </div>
                                </div>
                            </div> <!-- end col -->
        
                        </div>
                        <!-- end row -->
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