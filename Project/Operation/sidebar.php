<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

	<div class="h-100" data-simplebar>

		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul id="side-menu">

				<li class="menu-title">Navigation</li>
	
				<li>
					<a href="#sidebarOrders" data-toggle="collapse">
						<i class="mdi mdi-order-bool-ascending-variant"></i>
						<span class="menu-arrow"></span>
						<span> Orders </span>
					</a>
					<div class="collapse" id="sidebarOrders">
						<ul class="nav-second-level">
							<li>
								<a href="order_list.php">Order List</a>
							<ul class="nav-second-level">
								<li>
									<?php
										$db->join("tbl_order_detail", "tbl_order.order_id=tbl_order_detail.order_id", "LEFT");
														$db->join("tbl_product_detail", "tbl_order_detail.product_detail_id=tbl_product_detail.product_detail_id", "LEFT");
														$db->join("tbl_product", "tbl_order_detail.product_id=tbl_product.product_id", "LEFT");
														$db->join("tbl_payment", "tbl_order.order_id=tbl_payment.order_id", "LEFT");
														
														$db->where("tbl_order_detail.product_id", "0","!=");
														$db->where("order_status", "Cart","!=");
														$db->where("TIMESTAMPDIFF(MINUTE, order_datetime, now())",5,">");
														$db->groupBy ("tbl_order_detail.order_id");
														$cols = Array ("*","ABS(TIMESTAMPDIFF(HOUR,now(),modified_datetime)) as hour" , "sum(tbl_product_detail.product_detail_price*tbl_order_detail.quantity) as total");
														$orders = $db->get("tbl_order",null, $cols);
															
										foreach($orders as $order)
										{								
									?>
									<li>
										<a href="order_detail.php?order_id=<?=$order["order_id"]?>"><?="Order detail (".$order["order_id"].")"?></a>
									</li>
									<?php
										}
									?>
								</li>
							</ul>
							</li>
						</ul>
					</div>
				</li>
				
				<li>
					<a href=".php">
						<i data-feather="info"></i>
						<span> About Us </span>
					</a>
				</li>
				
				<li>
					<a href=".php">
						<i data-feather="user"></i>
						<span> Contact Us </span>
					</a>
				</li>

				</li>
			</ul>	
		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
