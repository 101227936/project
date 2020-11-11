<?php
	//require "../encrypt.php";
	ob_start();
	session_start();
	
	$_SESSION['user_id']=1;
	
	$db->join("tbl_user", "tbl_order.user_id=tbl_user.user_id", "LEFT");
	$db->where("tbl_order.user_id",$_SESSION['user_id'],"=");
	$order=$db->get("tbl_order");
	$name=$order[0]["user_name"];
	$image=$order[1]["user_profile"];
	
	
	if (isset($_SESSION['role']))
	{
		if ($_SESSION['role']=="Operation")
		{
			header("location: ../Operation/order_list.php");
		}
		else if ($_SESSION['role']=="Management")
		{
			header("location: ../Management/management_dashboard.php");
		}
	}else 
	{
		session_destroy();
		header("location: ../Landing/landing.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<link href="../assets/css/customize.css" rel="stylesheet" type="text/css"/>

		<div class="navbar-custom" style="background-color:black">
			<div class="container-fluid">
				<ul class="list-unstyled topnav-menu float-right mb-0">
					<li class="dropdown d-none d-lg-inline-block">
						<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
							<i class="fe-maximize noti-icon"></i>
						</a>
					</li>

					<li class="dropdown notification-list topbar-dropdown">
						<a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
							<img src="<?php echo $image;?>" alt="user-image" class="rounded-circle">
							<span class="pro-user-name ml-1">
								<?php echo $name;?><i class="mdi mdi-chevron-down" ></i> 
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
							<!-- item-->
							<a href="Customer_profile.php" class="dropdown-item notify-item">
								<i class="fe-user"></i>
								<span>My Account</span>
							</a>

							<!-- item-->
							<a href="order_list.php" class="dropdown-item notify-item">
								<i class="mdi mdi-order-bool-ascending-variant"></i>
								<span>My Orders</span>
							</a>
							
							<!-- item-->
							<a href="subscribe_newsletter.php" class="dropdown-item notify-item">
								<i class="mdi mdi-tag-outline"></i>
								<span>My newsletter</span>
							</a>

							<div class="dropdown-divider"></div>

							<!-- item-->
							<a href="../Landing/landing.php?logout=1" onclick="return confirm('Are you sure want to logout?')" class="dropdown-item notify-item">
								<i class="fe-log-out"></i>
								<span>Logout</span>
							</a>
						</div>
					</li>
				</ul> 

				<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
					<li>
						<button class="button-menu-mobile waves-effect waves-light">
							<i class="fe-menu"></i>
						</button>
					</li>

					<li>
						<!-- Mobile menu toggle (Horizontal Layout)-->
						<a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
							<div class="lines">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</a>
						<!-- End mobile menu toggle-->
					</li>   
				</ul>
				
				<div class="logo-box">
                        <a href="" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="../Image/foodedge.png" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="../Image/foodedge.png" alt="" class="logo2">
                            </span>
                        </a>
                </div>
			</div>
		</div>
	</body>
</html>