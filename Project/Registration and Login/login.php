<?php
									require '../Database/init.php';
									if (issest($_SESSION['user_id']))
									{
										login_id = $_SESSION['user_id']
										
										if ($_SESSION['user_role']=="Managment")
										{
											$login_role = $_SESSION['user_role'];
										}
										else if ($_SESSION['user_role']=="Operation")
										{
											$login_role = $_SESSION['user_role'];
										}
										else if ($_SESSION['user_role']=="Member")
										{
											$login_role = $_SESSION['user_role'];
										}
									}
									else $login_status = false;
?>