<?php
	ob_start();
	session_start();

	$_SESSION['staff_id']=1;

	$db->where("tbl_staff.staff_id",$_SESSION['staff_id'],"=");
	$staff=$db->get("tbl_staff");
	$name=$staff[0]["staff_name"];
	
	if (isset($_SESSION['role']))
	{
		if ($_SESSION['role']=="Operation")
		{
			header("location: ../Operation/order_list.php");
		}
		else if ($_SESSION['role']=="Member")
		{
			header("location: ../Member/main_menu.php");
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
	</head>
	
	<body>
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
							<span class="pro-user-name ml-1">
								<?php echo $name;?><i class="mdi mdi-chevron-down" ></i> 
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
							<!-- item-->
							<a href="" class="dropdown-item notify-item">
								<i class="fe-user"></i>
								<span>My Account</span>
							</a>

							<div class="dropdown-divider"></div>

							<!-- item-->
							<a href="../Landing/landing.php?logout=3" onclick="return confirm('Are you sure want to logout?')" class="dropdown-item notify-item">
								<i class="fe-log-out"></i>
								<span>Logout</span>
							</a>
						</div>
					</li>

					<li class="dropdown notification-list">
						<a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
							<i class="fe-settings noti-icon color_animation"></i>
						</a>
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