<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

	<div class="h-100" data-simplebar>
		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul id="side-menu">

				<li class="menu-title">Food and Beverages Management</li>
	
				<li>
					<a href="#sidebarProduct" data-toggle="collapse">
						<i class="mdi mdi-package-variant"></i>
						<span class="menu-arrow"></span>
						<span> Products </span>
					</a>
					<div class="collapse" id="sidebarProduct">
						<ul class="nav-second-level">
							<li>
								<a href="product_list.php">Product List</a>
							<ul class="nav-second-level">
								<li>
									<?php
										$products = $db->get("tbl_product");
															
										foreach($products as $product)
										{								
									?>
									<li>
										<a href="product_detail.php?product_id=<?=$product["product_id"]?>"><?="Product detail (".$product["product_id"].")"?></a>
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
					<a href="#sidebarRedeem" data-toggle="collapse">
						<i class="mdi mdi-gift"></i>
						<span class="menu-arrow"></span>
						<span> Product Redeem</span>
					</a>
					<div class="collapse" id="sidebarRedeem">
						<ul class="nav-second-level">
							<li>
								<a href="redeem_list.php">Product Redeem List</a>
							<ul class="nav-second-level">
								<li>
									<?php
										$products = $db->get("tbl_product_redeem");
															
										foreach($products as $product)
										{								
									?>
									<li>
										<a href="redeem_detail.php?product_redeem_id=<?=$product["product_redeem_id"]?>"><?="Product redeem detail (".$product["product_redeem_id"].")"?></a>
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
				
				
			</ul>
			
			<ul id="side-menu">
				<li class="menu-title">Dashboard Management</li>
				<li>
					<a href="management_dashboard.php">
						<i class="mdi mdi-view-dashboard"></i>
						<span>Dashboard</span>
					</a>
				</li>
			</ul>
			
			<ul id="side-menu">
				<li class="menu-title">Operation Account Management</li>
				<li>
					<a href="#">
						<i class="mdi mdi-account"></i>
						<span> Operation Account</span>
					</a>
				</li>
			</ul>
			
			<ul id="side-menu">
				<li class="menu-title">Payment Refund Management</li>
				<li>
					<a href="#">
						<i class="mdi mdi-credit-card-refund"></i>
						<span> Payment Refund</span>
					</a>
				</li>
			</ul>
		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
