<?php require "../Database/init.php"?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Management Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <!-- plugin css -->
        <link href="../assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

	    <!-- App css -->
	    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	    <link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
	    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

	    <!-- icons -->
	    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
		<!--
			view the statistic of the company operation such as revenue and number of customer, 
			the sale of the food and beverage monthly, 
			payment transaction record, 
			the review of the food or beverage, 
			stock of food and beverages
		-->
		<?php
			$db->join("tbl_user", "tbl_user.login_id=tbl_login.login_id", "INNER");
			$db->join("tbl_order","tbl_order.user_id=tbl_user.user_id","INNER");
			$db->join("tbl_payment","tbl_payment.order_id=tbl_order.order_id","INNER");
			$db->where("tbl_login.role", "Member");
			$db->where("tbl_login.status","Active");
			$members = $db->get("tbl_login");
			
			$db->join("tbl_user", "tbl_user.login_id=tbl_login.login_id", "INNER");
			$db->join("tbl_order","tbl_order.user_id=tbl_user.user_id","INNER");
			$db->join("tbl_order_detail","tbl_order_detail.order_id=tbl_order.order_id","INNER");
			$db->join("tbl_product","tbl_product.product_id=tbl_order_detail.product_id","INNER");
			$db->join("tbl_product_detail","tbl_product_detail.product_detail_id=tbl_order_detail.product_detail_id","INNER");
			$db->where("tbl_login.role", "Member");
			$db->where("tbl_login.status","Active");
			$orders = $db->get("tbl_login");
			
			$db->join("tbl_product_detail","tbl_product_detail.product_id=tbl_product.product_id","INNER");
			$products=$db->get("tbl_product");
		?>

        <!-- Begin page -->
        <div id="wrapper">
            <?php include "topbar.php"?>
			<?php include "sidebar.php"?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

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
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded bg-soft-primary">
                                                <i class="dripicons-wallet font-24 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
												<?php
													$total = 0;
													foreach($members as $member)
													{
														$total += (int)$member['amount_price'];
													}
												?>
                                                <h3 class="text-dark mt-1">$<span data-plugin="counterup"><?=$total?>.00</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Total Revenue</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded bg-soft-info">
                                                <i class="dripicons-store font-24 avatar-title text-info"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
												<?php
													$total_order = 0;
													foreach($members as $member)
													{
														$total_order ++;
													}
												?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?=$total_order?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Orders</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded bg-soft-success">
                                                <i class="dripicons-basket font-24 avatar-title text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
												<?php
													$total_cart = 0;
													foreach($orders as $order)
													{
														if($order['order_status']=='Cart')
														{
															$total_cart ++;
														}
													}
												?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?=$total_cart?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Cart</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-3">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded bg-soft-warning">
                                                <i class="dripicons-user-group font-24 avatar-title text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
												<?php
													$users = $db->get('tbl_user');
													$total_user = 0;
													foreach($users as $user)
													{
														$total_user++;
													}
												?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?=$total_user?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">User Account</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->

						
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="card-box pb-2" style="height: 600px">
                                    <!--
									<div class="float-right d-none d-md-inline-block">
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-xs btn-light">Today</button>
                                            <button type="button" class="btn btn-xs btn-light">Weekly</button>
                                            <button type="button" class="btn btn-xs btn-secondary">Monthly</button>
                                        </div>
                                    </div>
									-->
                                    <h4 class="header-title mb-3">Sales Analytics</h4>

                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <p class="text-muted mb-0 mt-3">Current Week</p>
                                            <h2 class="font-weight-normal mb-3">
                                                <small class="mdi mdi-checkbox-blank-circle text-primary align-middle mr-1"></small>
                                                <span>$58,254</span>
                                            </h2>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-muted mb-0 mt-3">Previous Week</p>
                                            <h2 class="font-weight-normal mb-3">
                                                <small class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                                                <span>$69,524</span>
                                            </h2>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-muted mb-0 mt-3">Targets</p>
                                            <h2 class="font-weight-normal mb-3">
                                                <small class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                                                <span>$95,025</span>
                                            </h2>
                                        </div>
                                    </div>

                                    <div id="revenue-chart" class="apex-charts mt-3" data-colors="#6658dd,#1abc9c"></div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->

                            <div class="col-xl-5">
								<div class = "row">
									<div class="col-xl">
										<div class="card-box" style="width: auto">
											<h4 class="header-title mb-0">Sales</h4>
											<div class="widget-chart text-center" dir="ltr">
												<h5 class="text-muted mt-1">Total sales made today</h5>
												<?php
													//'2016-01-01'
													$sales = 0;
													$get = new DateTime();
													$today = $get->format("Y-m-d");
													foreach($members as $order)
													{
														$date = new DateTime($order['order_datetime']);
														$orderDate = $date->format("Y-m-d");
														if($orderDate == $today && $order['payment_status']=="Confirmed")
														{
															$sales += $order['amount_price'];
														}
													}
												?>
												<h2>$<?=$sales?>.00</h2>
												
												<div class="row mt-2">
													<div class="col-4">
														<p class="text-muted font-15 mb-1 text-truncate">Target</p>
														<h4><i class="fe-arrow-down text-danger mr-1"></i>$7.8k</h4>
													</div>
													<div class="col-4">
														<p class="text-muted font-15 mb-1 text-truncate">Last week</p>
														<h4><i class="fe-arrow-up text-success mr-1"></i>$1.4k</h4>
													</div>
													<div class="col-4">
														<p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
														<h4><i class="fe-arrow-down text-danger mr-1"></i>$15k</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class = "row">
									<div class="col-xl">
										<div class="card-box"  style="position: relative;height: 370px;overflow: auto;display: block;">

											<h4 class="header-title mb-0">Reviews</h4>

											<div class="widget-chart text-center" dir="ltr">
												<div class="row mt-1">
													<table class="table table-centered table-hover mb-0">
														<thead>
															<tr>
																<th class="border-top-0">OrderID</th>
																<th class="border-top-0">Product</th>
																<th class="border-top-0">Review</th>
																<th class="border-top-0">Date</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($orders as $order)
																{
																	if($order['comment'] != null)
																	{
																		$order_date = new DateTime($order['order_datetime']);
																		$order_Date = $order_date->format('d.m.Y');
																		$size = str_split($order['product_detail_size']);
																		?>
																		<tr>
																			<td><?=$order['order_id']?></td>
																			<td><p><img src="<?=$order['product_image']?>" height="50px" alt="product-pic"/></p><?=$order['product_name']?> (<?=$size[0]?>)</td>
																			<td><?=$order['comment']?></td>
																			<td><?=$order_Date?></td>
																		</tr>
																		<?php
																	}
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div> <!-- end card-box -->
									</div>
								</div>
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Transaction History</h4>

                                    <div style="position: relative;height: 700px;overflow: auto;display: block;">
                                        <table class="table table-centered table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Name</th>
                                                    <th class="border-top-0">Card</th>
                                                    <th class="border-top-0">Date</th>
                                                    <th class="border-top-0">Amount</th>
                                                    <th class="border-top-0">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
													foreach($members as $member)
													{
														?>
															<tr>
																<td>
																	<img src="<?php echo $member['user_profile']?>" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
																	<p><span><?php echo $member['user_name'] ?></span></p>
																</td>
																<td>
																	<img src="../assets/images/cards/visa.png" alt="user-card" height="24" />
																	<?php
																		$num = $member['card_number'];
																		$last = substr($num, -4);
																	?>
																	<span class="ml-2">**** <?=$last?></span>
																</td>
																<td><?php
																		$date = new DateTime($member['order_datetime']);
																		$sDate = $date->format("d.m.Y");
																		echo $sDate;
																	?>
																</td>
																<td>$ <?=($member['amount_price'])?>.00</td>
																<?php
																	if($member['payment_status']=='Waiting for Refund')
																	{
																		?>
																			<td><span class="badge badge-pill badge-warning">Pending Refund</span></td>
																		<?php
																	}else if($member['payment_status']=='Refunded')
																	{
																		?>
																			<td><span class="badge badge-pill badge-danger">Refunded</span></td>
																		<?php
																	}else if($member['payment_status']=='Confirmed')
																	{
																		?>
																			<td><span class="badge badge-pill badge-success">Confirmed</span></td>
																		<?php
																	}
																?>
															</tr>
														<?php
													}
												?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->

                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
							<div class="col-xl-6">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Stock List</h4>

                                    <div style="position: relative;height: 700px;overflow: auto;display: block;">
                                        <table class="table table-centered table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Category</th>
                                                    <th class="border-top-0">Product</th>
                                                    <th class="border-top-0">Size</th>
                                                    <th class="border-top-0">Price</th>
                                                    <th class="border-top-0">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
													$cnt = 0;
													foreach($products as $product)
													{
														?>
															<?php
																if($cnt%3==0)
																{
																	?>
																	<tr>
																		<td rowspan="3"><?=$product['product_type']?></td>
																		<td rowspan="3" style="width:120px">
																			<img src="<?=$product['product_image']?>" alt="product-pic" height="50" />
																			<p><span><?=$product['product_name']?></span></p>
																		</td>
																		<td><?=$product['product_detail_size']?></td>
																		<td>$ <?=$product['product_detail_price']?>.00</td>
																		<?php
																			if(strtolower($product['product_detail_status'])=='not available')
																			{
																				?>
																				<td><span class="badge bg-soft-danger text-danger"><?=$product['product_detail_status']?></span></td>
																				<?php
																			}
																			else if(strtolower($product['product_detail_status'])=='available')
																			{
																				?>
																				<td><span class="badge bg-soft-success text-success"><?=$product['product_detail_status']?></span></td>
																				<?php
																			}
																		?>
																	</tr>
																<?php
																}else
																{
																	?>
																	<tr>
																		<td><?=$product['product_detail_size']?></td>
																		<td>$ <?=$product['product_detail_price']?>.00</td>
																		<?php
																			if(strtolower($product['product_detail_status'])=='not available')
																			{
																				?>
																				<td><span class="badge bg-soft-danger text-danger"><?=$product['product_detail_status']?></span></td>
																				<?php
																			}
																			else if(strtolower($product['product_detail_status'])=='available')
																			{
																				?>
																				<td><span class="badge bg-soft-success text-success"><?=$product['product_detail_status']?></span></td>
																				<?php
																			}
																		?>
																	</tr>
																	<?php
																}
														$cnt++;
													}
												?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end card-box-->
                            </div>
							<!--
                            <div class="col-xl-6">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Recent Products</h4>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Product</th>
                                                    <th class="border-top-0">Size</th>
                                                    <th class="border-top-0">Added Date</th>
                                                    <th class="border-top-0">Amount</th>
                                                    <th class="border-top-0">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
													foreach($orders as $order)
													{
														if($order['order_status']!='Cart')
														{
															?>
																<tr>
																	<td>
																		<img src="<?=$order['product_image']?>" alt="product-pic" height="36" />
																		<span class="ml-2"><?=$order['product_name']?></span>
																	</td>
																	<td><?=$order['product_detail_size']?></td>
																	<td>
																		<?php
																		$date = new DateTime($order['order_datetime']);
																		$sDate = $date->format("d.m.Y");
																		echo $sDate;
																		?>
																	</td>
																	<td>$ <?=$order['product_detail_price']?>.00</td>
																	<?php
																		if($order['order_status']=='Reject')
																		{
																			?>
																			<td><span class="badge bg-soft-danger text-danger"><?=$order['order_status']?></span></td>
																			<?php
																		}
																		else if($order['order_status']=='Pending')
																		{
																			?>
																			<td><span class="badge bg-soft-warning text-warning"><?=$order['order_status']?></span></td>
																			<?php
																		}
																		else
																		{
																			?>
																			<td><span class="badge bg-soft-success text-success"><?=$order['order_status']?></span></td>
																			<?php
																		}
																	?>
																</tr>
															<?php
														}
													}													
												?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
									<!--
                                </div> <!-- end card-box-->
									<!--
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
					<?php include "footer.php"?>
                <!-- end Footer -->

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

        <!-- Third Party js-->
        <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Plugins js-->
        <script src="../assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

        <!-- Dashboard init js -->
        <script src="../assets/js/pages/ecommerce-dashboard.init.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
        
    </body>
</html>