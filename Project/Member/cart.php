<?php
	include '../Database/init.php';
	ob_start();
	session_start();
	
	$db->where("tbl_order.order_status","Cart","=");
	$db->where("tbl_order.user_id",$_SESSION['user_id'],"=");
	$orders = $db->get("tbl_order");
	
	if(sizeof($orders)==0)
	{
		$data = Array (
			'user_id' => $_SESSION['user_id'],
			'order_status' => "Cart"
		);
		
		if (!$db->insert ('tbl_order', $data)) echo 'insert failed: ' . $db->getLastError();
	}
	$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
	$db->join("tbl_order_detail", "tbl_order.order_id=tbl_order_detail.order_id", "LEFT");
	$db->join("tbl_product_redeem", "tbl_order_detail.product_id=0 AND tbl_order_detail.product_detail_id=tbl_product_redeem.product_redeem_id", "LEFT");
	$db->join("tbl_product_detail", "tbl_order_detail.product_detail_id=tbl_product_detail.product_detail_id", "LEFT");
	$db->join("tbl_product", "tbl_product.product_id=tbl_order_detail.product_id", "LEFT");
	$db->where("tbl_order.order_status","Cart","=");
	$db->where("tbl_order.user_id",$_SESSION['user_id'],"=");
	$orders = $db->get("tbl_order");
	$reward=$orders[0]["user_reward"];

	if(isset($_POST["btnSave"]))
	{
		$db->where("tbl_order_detail.order_detail_id",$_POST['order_detail_id'],"=");
		$product_detail = $db->getOne("tbl_order_detail");
		if($product_detail['product_id']==0)
		{
			$db->where("tbl_user.user_id",$_SESSION['user_id'],"=");
			$user = $db->getOne("tbl_user");
			
			$db->join("tbl_order", "tbl_order.order_id=tbl_order_detail.order_id", "LEFT");
			$db->join("tbl_product_redeem", "tbl_order_detail.product_detail_id = tbl_product_redeem.product_redeem_id", "LEFT");
			$db->where("tbl_order_detail.order_detail_id",$_POST['order_detail_id'],"!=");
			$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
			$db->where("tbl_order.order_status","Cart","=");
			$db->where("tbl_order.user_id",$_SESSION['user_id'],"=");
			$cols = Array("SUM(product_redeem_point*quantity) as total");
			$redeem_detail_without_self = $db->get("tbl_order_detail", null,$cols);
			
			$db->join("tbl_product_redeem", "tbl_order_detail.product_detail_id = tbl_product_redeem.product_redeem_id", "LEFT");
			$db->where("tbl_order_detail.order_detail_id",$_POST['order_detail_id'],"=");
			$db->where("tbl_order_detail.product_id",$product_detail['product_id'],"=");
			$current_redeem = $db->getOne("tbl_order_detail");
			
			if(($current_redeem['product_redeem_point']*$_POST['quantity'])+$redeem_detail_without_self[0]['total']<=$user['user_reward'])
			{
				$_SESSION['error'] = "";
				$data = Array (
					'quantity' => $_POST['quantity']
				);
				$db->where("tbl_order_detail.order_detail_id",$_POST['order_detail_id'],"=");
				
				if (!$db->update ('tbl_order_detail', $data))
					echo 'update failed: ' . $db->getLastError();
			}
			else $_SESSION['error'] = "No Sufficient Point Balance";
		}
		else
		{
			$data = Array (
				'quantity' => $_POST['quantity']
			);
			$db->where("tbl_order_detail.order_detail_id",$_POST['order_detail_id'],"=");
			
			if (!$db->update ('tbl_order_detail', $data))
				echo 'update failed: ' . $db->getLastError();							
		}
		header("Location: cart.php");
	}
	
	else if(isset($_POST["btnDelete"]))
	{
		//print_r("<pre>");
		//print_r($_POST['order_detail_id']);
		//print_r($_POST['quantity']);
		//print_r("</pre>");
		
		$db->where("tbl_order_detail.order_detail_id",$_POST['order_detail_id'],"=");
		
		if (!$db->delete ('tbl_order_detail'))
			echo 'delete failed: ' . $db->getLastError();			

		header("Location: cart.php");
	}	
	
	else if(isset($_POST["btnDeleteALL"]))
	{	
		if (!$db->delete ('tbl_order_detail'))
			echo 'delete failed: ' . $db->getLastError();	
		header("Location: cart.php");
	}	
?>
	
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Shopping Cart</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../Landing/favicon-1.ico">
		
		<!-- Jquery Toast css -->
        <link href="../assets/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css" />

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
											<form method="post">
												<button type="submit" onclick="return confirm('Are you sure you want to clear the shopping cart?')" formaction="cart.php?action=deleteALL" name="btnDeleteALL" class="mdi mdi-cart-remove btn btn-danger waves-effect waves-light"></button>
											</form>
										</ol>
                                    </div>
                                    <h4 class="page-title">Shopping Cart</h4>
                                </div>
                            </div>
						</div>     
                        <!-- end page title --> 
						

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="table-responsive">
													
                                                    <table class="table table-borderless table-centered mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Price / Point</th>
                                                                <th>Quantity</th>
                                                                <th>Total</th>
                                                                <th colspan="2" style="width: 50px; text-align:center">Action:</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															<?php
																$total=0;
																$point=0;
																foreach($orders as $order)
																{
																	if(isset($order["order_detail_id"]))
																	{
																		if(isset($order["product_id"]))$total+=$order["product_detail_price"] * $order["quantity"];
																		else $point+=$order["product_redeem_point"] * $order["quantity"];
																		
																		?>
																		<form method="post" class="parsley-examples">
																		<input type="hidden" name="order_detail_id" value="<?=$order["order_detail_id"]?>">
																		<tr>
																			<td>
																				<img src="<?=(isset($order["product_id"]))? $order["product_image"]:$order["product_redeem_image"];?>" alt="product-img"
																					title="product-img" class="rounded mr-3" height="120" width="70"/>
																				<p class="m-0 d-inline-block align-middle font-16">
																					<?=(isset($order["product_id"]))? $order["product_name"]:$order["product_redeem_name"];?>
																					<br>
																					<small class="mr-2"><b>Size:</b> <?php echo $order["product_detail_size"];?></small>
																				</p>
																			</td>
																			<td>
																				<?=(isset($order["product_id"]))? "RM".$order["product_detail_price"]:$order["product_redeem_point"]." points"?>
																			</td>
																			<td>
																				<input type="number" min="1" value="<?php echo $order["quantity"];?>" required name="quantity" class="form-control" placeholder="Qty" style="width: 90px;">
																			</td>
																			<td>
																				<?=(isset($order["product_id"]))? "RM". $order["product_detail_price"] * $order["quantity"]:$order["product_redeem_point"]* $order["quantity"]?>
																			</td>
																			<td>
																				<button type="submit" formaction="cart.php?action=save" formmethod="post" name="btnSave" class="btn btn-blue waves-effect waves-light"><i class="mdi mdi-content-save"></i></button>
																			</td>
																			<td>
																				<button type="submit" onclick="return confirm('Are you sure?')" formaction="cart.php?action=delete" name="btnDelete" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></button>
																			</td>
																			</tr>
																		</form>
																		<?php
																	}
																	else {
																		?>
																		<tr>
																			<td>
																				<p class="mdi mdi-cart-off text-danger"><?php echo " The shopping cart is empty."?></p>
																			</td>
																		</tr>
																		<?php
																	}
																}
															?>
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end table-responsive-->
												<br>

                                                <!-- action buttons-->
                                                <div class="row mt-4">
                                                    <div class="col-sm-6">
                                                        <a href="main_menu.php" class="btn text-muted d-none d-sm-inline-block btn-link font-weight-semibold">
                                                            <i class="mdi mdi-arrow-left"></i> Continue Shopping </a>
                                                    </div> <!-- end col -->
                                                    <div class="col-sm-6">
                                                        <div class="text-sm-right">
														<?php
															if($total!=0)
															{
																?>
																<a href="checkout.php" class="btn btn-danger"><i class="mdi mdi-cart-plus mr-1"></i> Checkout </a>
																<?php
															}
														?>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row-->
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-4">
                                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                    <h4 class="header-title mb-3">Order Summary</h4>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Grand Total RM:</td>
                                                                    <td><?php echo $total;?>
                                                                </tr>
																<tr>
                                                                    <td>Grand Total Point:</td>
                                                                    <td><?php echo $point;?>
                                                                </tr>
																<tr>
                                                                    <td>Reward Points:</td>
                                                                    <td><?=(isset($_SESSION['user_id']))? $reward:""?></td>
                                                                </tr>
																<tr>
                                                                    <td colspan="2"><?=(isset($_SESSION['error']))? $_SESSION['error']:""?></td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table-responsive -->
                                                </div>
                                            </div> <!-- end col -->

                                        </div> <!-- end row -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        
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
		
		<!-- Tost-->
        <script src="../assets/libs/jquery-toast-plugin/jquery.toast.min.js"></script>
		
		<!-- toastr init js-->
        <script src="../assets/js/pages/toastr.init.js"></script>
		
        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
    </body>
</html>