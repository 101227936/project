<?php 
	require "../Database/init.php";
	ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Payment Detail</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/FoodEdge.ico">

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
                        <?php
                            $db->join("tbl_order_detail od", "p.order_id=od.order_id", "INNER");
                            $db->where("p.payment_id",$_GET['payment_id'],"=");
                            $payment = $db->getOne("tbl_payment p");
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Payment Detail for #<?=$payment["payment_id"]?></h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						
						<?php
							if(empty($_GET['payment_id']))header("Location: payment_list.php");
							else
							{
								$db->join("tbl_order_detail od", "p.order_id=od.order_id", "INNER");
								$db->where("p.payment_id",$_GET['payment_id'],"=");
								$payment = $db->getOne("tbl_payment p");
								
								$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
								$db->join("tbl_login l","tbl_user.login_id=l.login_id","INNER");
								$db->join("tbl_payment", "tbl_order.order_id=tbl_payment.order_id", "LEFT");
								$db->where("tbl_order.order_id",$payment['order_id'],"=");
								$order = $db->getOne("tbl_order");
							}
						?>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Payment Information</h4>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Payment ID:</h5>
                                                    <p>#<?=$payment["payment_id"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Order ID:</h5>
                                                    <p>#<?=$payment["order_id"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Payment Status:</h5>
                                                    <p><?=$payment["payment_status"]?></p>
                                                </div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Card Number:</h5>
                                                    <p>xxxx xxxx xxxx <?=substr($payment["card_number"],-4)?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Amount of Price:</h5>
                                                    <p>RM <?=$payment["amount_price"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Amount of Point:</h5>
                                                    <p><?=$payment["amount_point"]?> point</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Refund Reason:</h5>
                                                    <p><?=($payment["refund_reason"]==null)?"[Not Applicable]":$payment["refund_reason"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Refund Datetime:</h5>
                                                    <p><?=($payment["refund_datetime"]==null)?"[Not Applicable]":date_format(date_create($order['refund_datetime']),"l jS F Y, h:i:s A");?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
    
                                                    <div class="modal-body">
                                                        <form action="send_payment_refunded_email.php?payment_id=<?=$payment["payment_id"]?>" method="post" class="parsley-examples">
                                                            <div class="form-group">
                                                                <label for="refund">Enter Refund Reason <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" id="refund" name="refund" rows="4" parsley-trigger="change" required placeholder="Enter the refund reason"></textarea>
                                                            </div>
                                                            <div class="form-group text-center">
                                                                <button class="btn btn-success waves-effect waves-light mb-2 mr-2" type="submit"><i class="mdi mdi-check mr-1"></i> Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        
										<?php							
										if($payment["payment_status"]=="Waiting for Refund")
										{
                                            ?>
                                            <!---->
											<button type="button" data-toggle="modal" data-target="#signup-modal" class="btn btn-success waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-cash-refund mr-1"></i> Refund</button>
											<?php
										}
										?>
										<a href="payment_list.php"><button type="button" class="btn btn-info waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-arrow-left mr-1"></i> Back</button></a>
                                    </div>
                                </div>
                            </div>
							
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Member Information</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-4">
													<h5 class="mt-0">Name:</h5>
													<?=$order["user_name"]?><br>
                                                </div>
                                            </div>
											<div class="col-lg-6">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Email:</h5>
                                                    <p><?=$order["email"]?></p>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
											<div class="col-lg-6">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Phone:</h5>
                                                    <p><?=$order["user_phone"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <h5 class="mt-0">Address:</h5>
                                                    <p><?=$order['user_address']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
						</div>
						<div class="row">
                            <div class="col-lg-12">
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
                                                        <th>Price/Point</th>
                                                        <th>Total</th>
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
															<td><?=($order_detail['product_id']==0)? $order_detail['product_redeem_point']." point":"RM ".$order_detail['product_detail_price']?></td>
															<td><?=($order_detail['product_id']==0)?($order_detail['product_redeem_point']*$order_detail['quantity'])." point":"RM ".($order_detail['product_detail_price']*$order_detail['quantity'])?></td>
														</tr>
														<?php
													}
													?>
                                                    <tr>
                                                        <th scope="row" colspan="5" class="text-right">Total (RM):</th>
                                                        <td><div class="font-weight-bold"><?=$price_sum?></div></td>
                                                    </tr>
													<tr>
                                                        <th scope="row" colspan="5" class="text-right">Total Reward Point:</th>
                                                        <td><div class="font-weight-bold"><?=$point_sum?></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
		
		<!-- Plugin js-->
        <script src="../assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="../assets/js/pages/form-validation.init.js"></script>
        
    </body>
</html>