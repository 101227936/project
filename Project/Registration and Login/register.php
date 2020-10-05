<?php
									require '../Database/init.php';
									if (issest($_SESSION['user_id']))
									{
										$user_name = $_POST['user_name'];
										$email_id = $_POST['email_id'];
										$user_password = $_POST['password'];
										$duplicate=mysqli_query($conn,"select * from tbl_login where email_id='$email_id'");
										
										if (mysqli_num_rows($duplicate)>0)
										{
										echo "User Already Exist! ";
										}
									}
									else $login_status = false;
								?>