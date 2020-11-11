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
			
			$db->where("tbl_login.role","Operation");
			$operation = $db->get("tbl_login");
		?>
		
		<?php
			$actual_sales_total = 0;
			$sales_1 = 0;
			$sales_2 = 0;
			$sales_3 = 0;
			$sales_4 = 0;
			$sales_5 = 0;
			$sales_6 = 0;
			$sales_7 = 0;
			$sales_8 = 0;
			$sales_9 = 0;
			$sales_10 = 0;
			$sales_11 = 0;
			$sales_12 = 0;
			$cust_1 = 0;
			$cust_2 = 0;
			$cust_3 = 0;
			$cust_4 = 0;
			$cust_5 = 0;
			$cust_6 = 0;
			$cust_7 = 0;
			$cust_8 = 0;
			$cust_9 = 0;
			$cust_10 = 0;
			$cust_11 = 0;
			$cust_12 = 0;
			$today = new DateTime();
			$today_Year = $today->format("Y");
			foreach($members as $order)
			{
				$date = new DateTime($order['order_datetime']);
				$orderDate = $date->format("Y-m");
				$orderYear = $date->format("Y");
				$orderMonth = $date->format("m");
				if($orderYear == $today_Year && $order['payment_status']=="Confirmed")
				{
					if($orderMonth == "01")
					{
						$sales_1 += $order['amount_price'];
						$cust_1++;
					}else if($orderMonth == "02")
					{
						$sales_2 += $order['amount_price'];
						$cust_2++;
					}else if($orderMonth == "03")
					{
						$sales_3 += $order['amount_price'];
						$cust_3++;
					}else if($orderMonth == "04")
					{
						$sales_4 += $order['amount_price'];
						$cust_4++;
					}else if($orderMonth == "05")
					{
						$sales_5 += $order['amount_price'];
						$cust_5++;
					}else if($orderMonth == "06")
					{
						$sales_6 += $order['amount_price'];
						$cust_6++;
					}else if($orderMonth == "07")
					{
						$sales_7 += $order['amount_price'];
						$cust_7++;
					}else if($orderMonth == "08")
					{
						$sales_8 += $order['amount_price'];
						$cust_8++;
					}else if($orderMonth == "09")
					{
						$sales_9 += $order['amount_price'];
						$cust_9++;
					}else if($orderMonth == "10")
					{
						$sales_10 += $order['amount_price'];
						$cust_10++;
					}else if($orderMonth =="11")
					{
						$sales_11 += $order['amount_price'];
						$cust_11++;
					}else if($orderMonth == "12")
					{
						$sales_12 += $order['amount_price'];
						$cust_12++;
					}
				}
			}
		?>
		
		<script>
			window.onload = function () {

				var chart = new CanvasJS.Chart("chartContainer", {
					animationEnabled: true,
					theme: "light2",
					title: {
						text: "Monthly Sales & Customer Data"
					},
					axisX: {
						valueFormatString: "MMM"
					},
					axisY: {
						prefix: "RM",
						labelFormatter: addSymbols
					},
					toolTip: {
						shared: true
					},
					legend: {
						cursor: "pointer",
						itemclick: toggleDataSeries
					},
					data: [
					{
						type: "line",
						name: "Sales",
						showInLegend: true,
						xValueFormatString: "MMM YYYY",
						yValueFormatString: "RM#,##0",
						dataPoints: [
							
							{ x: new Date(<?=$today_Year?>, 0), y: <?=$sales_1?> },
							{ x: new Date(<?=$today_Year?>, 1), y: <?=$sales_2?> },
							{ x: new Date(<?=$today_Year?>, 2), y: <?=$sales_3?> },
							{ x: new Date(<?=$today_Year?>, 3), y: <?=$sales_4?> },
							{ x: new Date(<?=$today_Year?>, 4), y: <?=$sales_5?> },
							{ x: new Date(<?=$today_Year?>, 5), y: <?=$sales_6?> },
							{ x: new Date(<?=$today_Year?>, 6), y: <?=$sales_7?> },
							{ x: new Date(<?=$today_Year?>, 7), y: <?=$sales_8?> },
							{ x: new Date(<?=$today_Year?>, 8), y: <?=$sales_9?> },
							{ x: new Date(<?=$today_Year?>, 9), y: <?=$sales_10?>},
							{ x: new Date(<?=$today_Year?>, 10), y: <?=$sales_11?> },
							{ x: new Date(<?=$today_Year?>, 11), y: <?=$sales_12?> }
						]
					},
					{
						type: "line",
						name: "Number of Customer",
						showInLegend: true,
						xValueFormatString: "MMM YYYY",
						yValueFormatString: "#,##0",
						dataPoints: [
							
							{ x: new Date(<?=$today_Year?>, 0), y: <?=$cust_1?> },
							{ x: new Date(<?=$today_Year?>, 1), y: <?=$cust_2?> },
							{ x: new Date(<?=$today_Year?>, 2), y: <?=$cust_3?> },
							{ x: new Date(<?=$today_Year?>, 3), y: <?=$cust_4?> },
							{ x: new Date(<?=$today_Year?>, 4), y: <?=$cust_5?> },
							{ x: new Date(<?=$today_Year?>, 5), y: <?=$cust_6?> },
							{ x: new Date(<?=$today_Year?>, 6), y: <?=$cust_7?> },
							{ x: new Date(<?=$today_Year?>, 7), y: <?=$cust_8?> },
							{ x: new Date(<?=$today_Year?>, 8), y: <?=$cust_9?> },
							{ x: new Date(<?=$today_Year?>, 9), y: <?=$cust_10?>},
							{ x: new Date(<?=$today_Year?>, 10), y: <?=$cust_11?> },
							{ x: new Date(<?=$today_Year?>, 11), y: <?=$cust_12?> }
						]
					}]
				});
				chart.render();

				function addSymbols(e) {
					var suffixes = ["", "K", "M", "B"];
					var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

					if(order > suffixes.length - 1)                	
						order = suffixes.length - 1;

					var suffix = suffixes[order];      
					return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
				}

				function toggleDataSeries(e) {
					if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
						e.dataSeries.visible = false;
					} else {
						e.dataSeries.visible = true;
					}
					e.chart.render();
				}

			}
		</script>

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
														if($member['payment_status'] == "Confirmed")
														{
															$total += (int)$member['amount_price'];
														}
													}
												?>
                                                <h3 class="text-dark mt-1">RM<span data-plugin="counterup"><?=$total?>.00</span></h3>
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
                                <div class="widget-rounded-circle card-box" style = "height:120px">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded bg-soft-success">
                                                <i class="dripicons-user-group font-24 avatar-title text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
												<?php
													$total_operate = 0;
													foreach($operation as $operate)
													{
														$total_operate++;
													}
												?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?=$total_operate?></span></h3>
                                                <p class="text-muted mb-1">Operation Account</p>
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
                                <div class="card-box pb-0" style="height: 675px">
                                    <?php
										$pre_sales = 0;
										$cur_sales = 0;
										$today = new DateTime();
										$todayM = $today->format("Y-m");
										$prevM = $today->modify("-1 month")->format("Y-m");
										foreach($members as $order)
										{
											$date = new DateTime($order['order_datetime']);
											$orderDate = $date->format("Y-m");
											if($orderDate == $todayM && $order['payment_status']=="Confirmed")
											{
												$cur_sales += $order['amount_price'];
											}else if($orderDate == $prevM && $order['payment_status']=="Confirmed")
											{
												$pre_sales += $order['amount_price'];
											}
										}
									?>
                                    <h4 class="header-title mb-3">Sales Analytics</h4>

                                    <div class="row text-center">
                                        <div class="col-md-7">
                                            <p class="text-muted mb-0 mt-3">Previous Month</p>
                                            <h2 class="font-weight-normal mb-3">
                                                <small class="mdi mdi-checkbox-blank-circle text-secondary align-middle mr-1"></small>
                                                <span>RM<?=$pre_sales?>.00</span>
                                            </h2>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-muted mb-0 mt-3">Current Month</p>
                                            <h2 class="font-weight-normal mb-3">
                                                <small class="mdi mdi-checkbox-blank-circle text-info align-middle mr-1"></small>
                                                <span>RM<?=$cur_sales?>.00</span>
                                            </h2>
                                        </div>
                                    </div>
									
									<div id="chartContainer" style="width: 100%;"></div>
									<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->

                            <div class="col-xl-5">
								<div class = "row">
									<div class="col-xl">
										<div class="card-box">
											<div class="card-widgets">
												<a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
											</div>
											<h4 class="header-title mb-0">Sales</h4>

											<div id="cardCollpase2" class="collapse pt-0 show">
												<div class="widget-chart text-center" dir="ltr">
													<h5 class="text-muted mt-1">Total sales made today</h5>
													<?php
														//'2016-01-01'
														$sales = 0;
														$refund = 0;
														$pending = 0;
														$get = new DateTime();
														$today = $get->format("Y-m-d");
														foreach($members as $order)
														{
															$date = new DateTime($order['order_datetime']);
															$orderDate = $date->format("Y-m-d");
															if($orderDate == $today && $order['payment_status']=="Confirmed")
															{
																$sales += $order['amount_price'];
															}else if($orderDate == $today && $order['payment_status']=="Refunded")
															{
																$refund += $order['amount_price'];
															}else if($order['payment_status']=="Waiting for Refund")
															{
																$pending += $order['amount_price'];
															}
														}
													?>
													<h2>
														<?php
															if($sales>0)
															{
																?>
																<i class="fa fa-caret-up text-success mr-1"></i>
																<?php
															}else if($sales == 0)
															{
																?>
																<i class="fa fa-minus text-secondary mr-1"></i>
																<?php
															}
														?>
														RM<?=$sales?>.00</h2>
													<div class = "row mt-3">
														<div class="col-6">
															<p class="text-muted font-15 mb-1 text-truncate">Refund today</p>
															<h4>
																<?php
																	if($refund>0)
																	{
																		?>
																		<i class="fa fa-caret-up text-danger mr-1"></i>
																		<?php
																	}else if($refund == 0)
																	{
																		?>
																		<i class="fa fa-minus text-secondary mr-1"></i>
																		<?php
																	}
																?>
																RM<?=$refund?>.00
															</h4>
														</div>
														<div class="col-5">
															<p class="text-muted font-15 mb-1 text-truncate">Pending Refund</p>
															<h4>
																<?php
																	if($pending>0)
																	{
																		?>
																		<i class="fa fa-caret-up text-danger mr-1"></i>
																		<?php
																	}else if($pending == 0)
																	{
																		?>
																		<i class="fa fa-minus text-secondary mr-1"></i>
																		<?php
																	}
																?>
																RM<?=$pending?>.00
															</h4>
														</div>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								
								<div class = "row">
									<div class="col-xl">
										<div class="card-box">
											<div class="card-widgets">
												<a data-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase3"><i class="mdi mdi-minus"></i></a>
											</div>
											<h4 class="header-title mb-0">Reviews</h4>

											<div id="cardCollpase3" class="collapse pt-3 show">
												<div class="widget-chart text-center" dir="ltr"  style="position: relative;height: 345px; overflow: auto; display: block;">
													<div class="row mt-1">
														<table id="basic-datatable" class="table dt-responsive nowrap w-100">
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
																				<td>
																					<a href="product_detail.php?product_id=<?=$order['product_id']?>" />
																					<p>
																						<img src="<?=$order['product_image']?>" height="50px" alt="product-pic"/>
																					</p><?=$order['product_name']?> (<?=$size[0]?>)
																				</td>
																				<td>
																					<p><?=$order['comment']?></p>
																					<p>Rate: <?=$order['rating']?></p>
																				</td>
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
									<div class="card-widgets">
										<a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
									</div>
                                    <h4 class="header-title mb-3">Transaction History</h4>

                                    <div id="cardCollpase4" class="collapse pt-3 show">
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
														$getMember = $members;
														function sortFunction( $a, $b ) {
															return strtotime($b["order_datetime"]) - strtotime($a["order_datetime"]);
														}
														usort($getMember, "sortFunction");
														foreach($getMember as $member)
														{
															?>
																<tr onclick="window.location='payment_detail.php?payment_id=<?=$member['payment_id']?>'" style="cursor: pointer;">
																	<td>
																		<img src="<?php echo $member['user_profile']?>" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
																		<p><span><?php echo $member['user_name'] ?></span></p>
																	</td>
																	<td>
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
																	<td>RM <?=($member['amount_price'])?>.00</td>
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
										</div><!-- end table-responsive -->
									</div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
							<div class="col-xl-6">
                                <div class="card-box">
									<div class="card-widgets">
										<a data-toggle="collapse" href="#cardCollpase5" role="button" aria-expanded="false" aria-controls="cardCollpase5"><i class="mdi mdi-minus"></i></a>
									</div>
                                    <h4 class="header-title mb-3">Stock List</h4>

                                    <div id="cardCollpase5" class="collapse pt-3 show">
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
														$db->join("tbl_product_detail","tbl_product_detail.product_id=tbl_product.product_id","INNER");
														$products=$db->get("tbl_product");
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
																				<a href="product_detail.php?product_id=<?=$product['product_id']?>" />
																				<img src="<?=$product['product_image']?>" alt="product-pic" height="50"/>
																				<p><span><?=$product['product_name']?></span></p>
																			</td>
																			<td><?=$product['product_detail_size']?></td>
																			<td>RM <?=$product['product_detail_price']?>.00</td>
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
																			<td>RM <?=$product['product_detail_price']?>.00</td>
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
									</div>
                                </div> <!-- end card-box-->
                            </div>
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