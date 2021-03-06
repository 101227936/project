<?php 
	require "../Database/init.php";
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Checkout Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../Landing/FoodEdge.ico">

        <!-- Select2 Css-->
        <link href="../assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />        

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
                                    <h4 class="page-title">Checkout</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="nav nav-pills flex-column navtab-bg nav-pills-tab text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                    <a class="nav-link active show py-2" id="custom-v-pills-billing-tab" data-toggle="pill" href="#custom-v-pills-billing" role="tab" aria-controls="custom-v-pills-billing"
                                                        aria-selected="true">
                                                        <i class="mdi mdi-account-circle d-block font-24"></i>
                                                        Billing Info
                                                    </a>
                                                    <a class="nav-link mt-2 py-2" id="custom-v-pills-shipping-tab" data-toggle="pill" href="#custom-v-pills-shipping" role="tab" aria-controls="custom-v-pills-shipping"
                                                        aria-selected="false" onclick="getInfo()">
                                                        <i class="mdi mdi-truck-fast d-block font-24"></i>
                                                        Shipping Info</a>
                                                    <a class="nav-link mt-2 py-2" id="custom-v-pills-payment-tab" data-toggle="pill" href="#custom-v-pills-payment" role="tab" aria-controls="custom-v-pills-payment"
                                                        aria-selected="false">
                                                        <i class="mdi mdi-cash-multiple d-block font-24"></i>
                                                        Payment Info</a>
                                                </div>  

                                                <div class="border mt-4 rounded">
                                                    <h4 class="header-title p-2 mb-0">Order Summary</h4>
    
                                                    <div class="table-responsive">
                                                        <table class="table table-centered table-nowrap mb-0">
                                                            <tbody>
															<?php
																$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
																$db->join("tbl_login","tbl_login.login_id=tbl_user.login_id","LEFT");
																$db->where("tbl_user.user_id", $_SESSION['user_id']);
																$orders = $db->get("tbl_order");
																
																foreach($orders as $order)
																{
																	if($order["order_status"] == "Cart")
																	{
																		$db->join("tbl_product_redeem", "tbl_order_detail.product_detail_id=tbl_product_redeem.product_redeem_id && tbl_order_detail.product_id=0", "LEFT");
																		$db->join("tbl_product_detail", "tbl_order_detail.product_detail_id=tbl_product_detail.product_detail_id", "LEFT");
																		$db->join("tbl_product", "tbl_order_detail.product_id=tbl_product.product_id", "LEFT");
																		$db->where("order_id",$order["order_id"],"=");
																		$cols = Array ("*");
																		$orderID = $order["order_id"];
																		$orderStatus = $order["order_status"];
																		$order_details = $db->get("tbl_order_detail",null, $cols);
																		
																		$sum_price=0;
																		$sum_point=0;
																		foreach($order_details as $order_detail)
																		{
																			if($order_detail['product_id']==0)$sum_point+=$order_detail['product_redeem_point']*$order_detail['quantity'];
																			else $sum_price+=$order_detail['product_detail_price']*$order_detail['quantity'];
																			$total=$order_detail['product_detail_price']*$order_detail['quantity'];
																			$link = "";
																			if($order_detail['product_id']==0)
																			{
																				$link = "product_redeem_detail.php?product_redeem_id=".$order_detail['product_redeem_id'];
																			}
																			else
																			{
																				$link = "product_detail.php?product_detail_id=".$order_detail['product_detail_id'];
																			}
																			?>
																				<tr>
																					<td style="width: 90px;">
																						<a href="<?=$link?>">
																						<img src="<?=($order_detail['product_id']==0)?$order_detail['product_redeem_image']:$order_detail['product_image']?>" alt="product-img" height="48" class="rounded"/>
																						</a>
																					</td>
																					<td>
																						<a href="<?=$link?>">
																						<p class="text-body font-weight-semibold"><?=($order_detail['product_id']==0)?$order_detail['product_redeem_name']:$order_detail['product_name']?></p>
																						</a>
																						<?php
																						if($order_detail['product_id']==0)
																						{
																							if($order_detail['product_redeem_point'] > 1)
																							{
																								?>
																								<small class="d-block"><?=$order_detail['quantity']?> x <?=$order_detail['product_redeem_point'] ?> Points</small>
																								<?php
																								
																							}
																							else
																							{
																								?>
																								<small class="d-block"><?=$order_detail['quantity']?> x <?=$order_detail['product_redeem_point'] ?> Point</small>
																								<?php
																							}
																						}
																						else
																						{
																							?>
																							<small class="d-block"><?=$order_detail['quantity']?> x RM<?=$order_detail['product_detail_price']?> (<?=$order_detail['product_detail_size']?>)</small>
																							<?php
																						}
																						?>
																					</td>
																					<?php
																						if($order_detail['product_id']==0)
																						{
																							if($total > 1)
																							{
																								?>
																									<td class="text-right"><?=$order_detail['product_redeem_point']?> Points</td>
																								<?php
																							}
																							else
																							{
																								?>
																									<td class="text-right"><?=$order_detail['product_redeem_point']?> Point</td>
																								<?php
																							}
																						}
																						else
																						{
																							?>
																							<td class="text-right">RM <?=$total?></td>
																							<?php
																						}
																						?>
																				</tr>
																			<?php
																		}
																	}
																}
																?>
																<tr class="text-right">
																	<td colspan="2">
																		<h5 class="m-0">Total Price:</h5>
																	</td>
																	<td class="text-right font-weight-semibold">RM<?=$sum_price?></td>
																</tr>
																<tr class="text-right">
																	<td colspan="2">
																		<h5 class="m-0">Total Point:</h5>
																	</td>
																	<td class="text-right font-weight-semibold"><?=$sum_point?> Points</td>
																</tr>
																<tr class="text-right">
																	<td colspan="2">
																		<h5 class="m-0">User's Point Left: </h5>
																	</td>
																	<td class="text-right font-weight-semibold">(<?=$order['user_reward']?> - <?=$sum_point?>) <?=$lastPoint = $order['user_reward'] - $sum_point?> Points</td>
																</tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table-responsive -->
                                                </div> <!-- end .border-->
                                            </div> <!-- end col-->
											<script>
												function clickFunction(){
													if(document.getElementById('customCheck2').checked == true)
													{
														document.getElementById('billing-address').value='';
														document.getElementById('billing-address').readOnly=false;
													}
													else
													{
														document.getElementById('billing-address').value='<?=$order["user_address"]?>';
														document.getElementById('billing-address').readonly='true';
													}
												};
													
												function getInfo(){
													document.getElementById('name_display').value=document.getElementById("billing-first-name").value;
													document.getElementById('address_display').value=document.getElementById("billing-address").value;
													document.getElementById('phone_display').value=document.getElementById("billing-phone").value;
													document.getElementById('email_display').value=document.getElementById("billing-email-address").value;
												};
												
												function displayDate(){
													if(document.getElementById('shippingMethodRadio2').checked == true)
													{
														document.getElementById('delivery-time').style.display = "inline";
													}
													else
													{
														document.getElementById('delivery-time').style.display = "none";
													}
												};
											</script>
                                            <div class="col-lg-8">
												<form method="post" action="#">
													<div class="tab-content p-3">
														<div class="tab-pane fade active show" id="custom-v-pills-billing" role="tabpanel" aria-labelledby="custom-v-pills-billing-tab">
															<div>
																<h4 class="header-title">Billing Information</h4>

																<p class="sub-header">Information get from your saved address in profile.</p>
																<form>
																	<div class="row">
																		<div class="col-12">
																			<div class="form-group">
																				<label for="billing-first-name">Full Name</label>
																				<input class="form-control" type="text" placeholder="Enter your first name" name="billing-first-name" id="billing-first-name" value = "<?=$order["user_name"]?>" readonly = "true"/>
																			</div>
																		</div>
																	</div> <!-- end row -->
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="billing-email-address">Email Address <span class="text-danger">*</span></label>
																				<input class="form-control" type="email" placeholder="Enter your email" name="billing-email-address" id="billing-email-address" value="<?=$order["email"]?>" readonly = "true"/>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="billing-phone">Phone <span class="text-danger">*</span></label>
																				<input class="form-control" type="text" placeholder="(xx) xxx xxxx xxx" name="billing-phone" id="billing-phone" value="<?=$order["user_phone"]?>" readonly = "true"/>
																			</div>
																		</div>
																	</div> <!-- end row -->
																	<div class="row">
																		<div class="col-12">
																			<div class="form-group">
																				<label for="billing-address">Address</label>
																				<input class="form-control" type="text" placeholder="Enter full address" name="billing-address" id="billing-address" value="<?=$order["user_address"]?>" readonly = "true"/>
																			</div>
																		</div>
																	</div> <!-- end row -->
																	<div class="form-group">
																		<div class="custom-control custom-checkbox">
																			<input type="checkbox" class="custom-control-input" id="customCheck2" name="customCheck2" onclick="clickFunction()" />
																			<label class="custom-control-label" for="customCheck2">Ship to different address ?</label>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="billing-town-city">Town / City</label>
																				<input class="form-control" type="text" placeholder="Enter your city name" id="billing-town-city" value="Kuching" readonly = "true"/>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="billing-state">State</label>
																				<input class="form-control" type="text" placeholder="Enter your state" id="billing-state" value="Sarawak" readonly="true"/>
																			</div>
																		</div>
																	</div> <!-- end row -->
																	<div class="row">
																		<div class="col-12">
																			<div class="form-group">
																				<label>Country</label>
																				<select data-toggle="select2" title="Country" class="form-control" readonly = "true">
																					<option>Malaysia</option>																			
																				</select>
																			</div>
																		</div>
																	</div> <!-- end row -->
																	
																	<div class="row">
																		<div class="col-12">
																			<div class="form-group mt-3">
																				<label for="example-textarea">Order Notes:</label>
																				<textarea class="form-control" name="example-textarea" id="example-textarea" rows="3" placeholder="Write some note.."></textarea>
																			</div>
																		</div>
																	</div> <!-- end row -->
			
																	<div class="row mt-4">
																		<div class="col-sm-6">
																			<a href="cart.php" class="btn btn-secondary">
																				<i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
																		</div> <!-- end col -->
																	</div> <!-- end row -->
																</form>
															</div>    
														</div>
														<div class="tab-pane fade" id="custom-v-pills-shipping" role="tabpanel" aria-labelledby="custom-v-pills-shipping-tab">
															<div>
																<h4 class="header-title">Saved Address</h4>

																<p class="sub-header">The address below shows the address from billing info.</p>
			
																<div class="row">
																	<div class="col-md-12">
																		<div class="border p-3 rounded mb-3 mb-md-0">
																			<p class="mb-2"><span class="font-weight-semibold mr-2">Name:</span><output id="name_display"/></p>                                    
																			<p class="mb-2"><span class="font-weight-semibold mr-2">Address:</span><output id="address_display"/></p>
																			<p class="mb-2"><span class="font-weight-semibold mr-2">Phone:</span><output id="phone_display"/></p>
																			<p class="mb-0"><span class="font-weight-semibold mr-2">Email:</span><output id="email_display"/></p>
																		</div>
																	</div>
																</div>
																<!-- end row-->

																<h4 class="header-title mt-4">Shipping Method</h4>

																<p class="text-muted mb-3">Please choose one of the shipping method below.</p>

																<div class="row">
																	<div class="col-md-12">
																		<div class="border p-3 rounded mb-3">
																			<div class="custom-control custom-radio">
																				<input type="radio" id="shippingMethodRadio1" name="shippingMethodRadio" value="1" class="custom-control-input" checked onclick="displayDate()"/>
																				<label class="custom-control-label font-16 font-weight-bold" for="shippingMethodRadio1">DELIVERY NOW</label>
																			</div>
																			<p class="mb-0 pl-3 pt-1">Estimated 3 hours for preparing and delivering.</p>
																		</div>

																		<div class="border p-3 rounded">
																			<div class="custom-control custom-radio">
																				<input type="radio" id="shippingMethodRadio2" name="shippingMethodRadio" value="2" class="custom-control-input" onclick="displayDate()"/>
																				<label class="custom-control-label font-16 font-weight-bold" for="shippingMethodRadio2">DELIVERY ON OTHER DATE &amp TIME(NEXT DAY &amp AFTER)</label>
																			</div>
																			<p class="mb-0 pl-3 pt-1">Working Hours 10.A.M. to 10.A.M.</p>
																			<p class="mb-0 pl-3 pt-1"><input type="datetime-local" id="delivery-time" name="delivery-time" style="display:none"/></p>
																		</div>
																	</div>
																</div>
																<!-- end row-->
																
																<script>
																	var today = new Date();
																	var dd = today.getDate()+1;
																	var mm = today.getMonth()+1; //January is 0!
																	var yyyy = today.getFullYear();
																	if(dd<10){
																		dd='0'+dd
																	} 
																	if(mm<10){
																		mm='0'+mm
																	}
																	today = yyyy+'-'+mm+'-'+dd + 'T10:00';
																	document.getElementById("delivery-time").setAttribute("min", today);
																</script>

																<div class="row mt-4">
																	<div class="col-sm-6">
																		<a href="cart.php" class="btn btn-secondary">
																			<i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
																	</div> <!-- end col -->
																</div> <!-- end row -->
															</div>
														</div>
														<div class="tab-pane fade" id="custom-v-pills-payment" role="tabpanel" aria-labelledby="custom-v-pills-payment-tab">
															<div>
																<h4 class="header-title">Payment Selection</h4>
			
																<p class="sub-header">Fill the form below in order to
																	send you the order's invoice.</p>
			
																<!-- Credit/Debit Card box-->
																<div class="border p-3 mb-3 rounded">
																	<div class="float-right">
																		<i class="far fa-credit-card font-24 text-primary"></i>
																	</div>
																	<div class="custom-control custom-radio custom-control-inline">
																		<input type="radio" id="BillingOptRadio1" name="billingOptions" class="custom-control-input" checked/>
																		<label class="custom-control-label font-16 font-weight-bold" for="BillingOptRadio1">Credit / Debit Card</label>
																	</div>
																	<p class="mb-0 pl-3 pt-1">Safe money transfer using your bank account. We support Mastercard, Visa, Discover and Stripe.</p>
																	
																	<div class="row mt-4">
																		<div class="col-md-12">
																			<div class="form-group">
																				<label for="card-number">Card Number</label>
																				<input type="text" id="card-number" name="card-number" class="form-control" data-toggle="input-mask" data-mask-format="0000 0000 0000 0000" placeholder="4242 4242 4242 4242" pattern="\d*" minlength=16 maxlength=16 required/>
																			</div>
																		</div>
																	</div> <!-- end row -->
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="card-name-on">Name on card</label>
																				<input type="text" id="card-name-on" name="card-name-on" class="form-control" placeholder="Master Shreyu"/>
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label for="card-expiry-date">Expiry date</label>
																				<input type="text" id="card-expiry-date" name="card-expiry-date" class="form-control" data-toggle="input-mask" data-mask-format="00/00" placeholder="MM/YY" pattern="\^[0-1][0-2]\/[2-9][0-9]$\" minlength=5 maxlength=5 required/>
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label for="card-cvv">CVV code</label>
																				<input type="text" id="card-cvv" name="card-cvv" class="form-control" data-toggle="input-mask" data-mask-format="000" placeholder="012" pattern="\^[0-9]{3, 4}$\" minlength=3 maxlength=3 required/>
																			</div>
																		</div>
																	</div> <!-- end row -->
																</div>
																<!-- end Credit/Debit Card box-->
			
																<div class="row mt-4">
																	<div class="col-sm-6">
																		<a href="cart.php" class="btn btn-secondary">
																			<i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
																	</div> <!-- end col -->
																	<div class="col-sm-6">
																		<div class="text-sm-right mt-2 mt-sm-0">
																			<input type="submit" id="completeBtn" name="completeBtn" class="btn btn-success" value="$ Complete Order" /> 
																		</div>
																	</div> <!-- end col -->
																</div> <!-- end row-->
															</div>
														</div>
													</div>
												</form>
												<?php
													if ($_SERVER['REQUEST_METHOD'] == 'POST')
													{
														
														$tbl_payment = $db->get('tbl_payment');
														
														$db->where('tbl_payment.order_id',$orderID);
														$payment = $db->get('tbl_payment');
														
														if (empty($tbl_payment)){
															$last = "999";
														}
														else
														{
															foreach($tbl_payment as $tbl_payments)
															{
																$last = $tbl_payments['payment_id'];
															};
														};
														
														if($orderStatus == 'Cart')
														{
															//2021-04-01 expiry format
															$get_expiry = $_POST['card-expiry-date'];
															$str_expiry = str_split($get_expiry);
															$mm = $str_expiry[0] . $str_expiry[1];
															$yy = '20' . $str_expiry[3] . $str_expiry[4];
															$dd = '01';
															$expiry = $yy . '-' . $mm . '-' . $dd;
															
															$remark = '';
															if(!empty($_POST['example-textarea'])){
																$remark = $_POST['example-textarea'];
															}
															else
															{
																$remark = null;
															};
															
															$shipping = $_POST['shippingMethodRadio'];
															if($shipping == '1')
															{
																$delivery = date('Y-m-d H:i:s');
															}
															else
															{
																//java time format = 2020-10-16T20:00
																//sql time format 2020-10-13 13:34:30
																$time = $_POST['delivery-time'];
																$time2 = str_split($time);
																
																$yy = $time2[0].$time2[1].$time2[2].$time2[3];
																$mm = $time2[5].$time2[6];
																$dd = $time2[8].$time2[9];
																$hh = $time2[11].$time2[12];
																$mn = $time2[14].$time2[15];
																$sc = "00";
																
																$delivery = $yy . "-" . $mm . "-" . $dd . " " . $hh . ":" . $mn . ":" . $sc;
															};
															
															$update_order = Array(
																					'remark' => $remark, 
																					'order_datetime' =>  date('Y-m-d H:i:s'),
																					'delivery_address' => $_POST['billing-address'],
																					'delivery_datetime' => $delivery,
																					'modified_datetime' => date('Y-m-d H:i:s'),
																					'order_status' => 'Pending'
																				);
															$insert_payment = Array(
																						'payment_id' => $last+1,
																						'order_id' => $orderID,
																						'card_number' => str_replace(' ', '', $_POST['card-number']),
																						'expiry_date' => $expiry,
																						'cvc' => $_POST['card-cvv'],
																						'payment_status' => 'Confirmed',
																						'amount_price' => $sum_price,
																						'amount_point' => $sum_point
																					);
															$update_user = Array('user_reward' => ($lastPoint+($sum_price/10)));
															$db->where('tbl_user.user_id', $order['user_id']);
															$updateUser = $db->update('tbl_user',$update_user);
															$db->where('tbl_order.order_id',$orderID);
															$update = $db->update('tbl_order',$update_order);
															$insert = $db->insert('tbl_payment',$insert_payment);
															
															if($update && $insert && $updateUser)
															{
																echo '<script>',
																	'alert("Place Order successfully!\nYou can cancel the order within 5 minutes only. Please leave your comment after the order arrived.");',
																'</script>';
																$url = 'order_detail.php?order_id='.$ordeID;
																echo '<script>location.href = "'.$url.'";</script>';
															}
															else
															{
																echo '<script>',
																	'alert("Cannot place order! Please try again");',
																'</script>';
															}
														};
													};
												?>
                                            </div> <!-- end col-->
                                        </div> <!-- end row-->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                2015 - <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="">Coderthemes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <?php include "member_rightsidebar.php"?>

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <script src="../assets/libs/select2/js/select2.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>

        <script>
            $('[data-toggle="select2"]').select2();
        </script>
        
    </body>
</html>
