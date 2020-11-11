<?php require "../Database/init.php";
	require "../encrypt.php";?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <title>Operation Account Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/FoodEdge.ico">
		
		<!-- third party css -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

	    <!-- App css -->
	    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	    <link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
	    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

	    <!-- icons -->
	    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	    
	    <style>
        .account_row:hover {
            background-color: #f5f5f5;
        }
        </style>

    </head>

    <body>
		<?php
			if(isset($_POST['btnSave']))
			{
				$data = Array (
					'password' => encrypt_decrypt("encrypt",$_POST['pass1'])
				);
				$db->where('tbl_login.login_id',$_POST['id']);
				$id = $db->update ('tbl_login', $data);
				echo "<script> alert('Update Successful');location='operation_list.php'</script>";
			}
		
            if(isset($_POST['accountName'])&&isset($_POST['accountPhone'])&&isset($_POST['accountAddress'])&&isset($_POST['accountEmail'])&&isset($_POST['accountPassword']))
			{
                if($_FILES['image']['size']!=0)
                {
					$random_Name = date("YmdHis");
                    $file_name = "../Image/Profile/".$random_Name.'.'.explode("/",$_FILES['image']['type'])[1];
                    $file_size =$_FILES['image']['size'];
                    $file_tmp =$_FILES['image']['tmp_name'];
                    $file_type=$_FILES['image']['type'];
                    if($file_size > 2097152){
                        echo "<script> alert('File size must be excately 2 MB');location='operation_list.php'</script>";
                    }
					else move_uploaded_file($file_tmp,$file_name);
				}
				else
				{
					$file_name = "../Image/Profile/default.png";
				}
				$data = Array (
				   'email' => trim($_POST['accountEmail']),
				   'password' => $_POST['accountEmail'],
				   'role' => 'Operation',
				   'status' => 'Active'
				);
				$id = $db->insert ('tbl_login', $data);
				$data = Array (
				   'staff_profile' => $file_name,
				   'staff_name' => $_POST['accountName'],
				   'staff_phone' => $_POST['accountPhone'],
				   'staff_address' => $_POST['accountAddress'],
				   'login_id' => $id
				);
				$id = $db->insert ('tbl_staff', $data);
				echo "<script> alert('Add Successful');location='operation_list.php'</script>";
			}
		?>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include "topbar.php"?>
			<?php include "sidebar.php"?>

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
                                    <h4 class="page-title">Operation Account Management</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-lg-12">
												<div id="add-operation-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
														<div class="modal-dialog modal-lg">
															<div class="modal-content">
																<div class="modal-header">
																	<h4 class="modal-title">Add Operation Account</h4>
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																</div>
																<div class="modal-body p-4">
																	<form method="post" action="" id="add_operation" class="parsley-examples" enctype="multipart/form-data">
																		<div class="row">
																			<div class="col-md-4">
																				<div class="form-group">
																					<div class="form-group">
																						<label for="image">Upload Your Photo(Less than 2MB)</label>
																						<input type="file" name="image" id="image" class="form-control-file" accept="image/*">
																					</div>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="form-group">
																					<label for="accountName">Name<span class="text-danger">*</span></label>
																					<input type="text" name="accountName" parsley-trigger="change" data-parsley-trigger="keyup" required placeholder="Enter name" class="form-control" id="accountName">
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="form-group">
																					<label for="accountPhone">Mobile<span class="text-danger">*</span></label>
																					<input type="type" name="accountPhone" data-parsley-type="digits" data-parsley-trigger="keyup" data-parsley-length="[10,11]" parsley-trigger="change" required placeholder="Enter number" class="form-control" id="accountPhone">
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-12">
																				<div class="form-group">
																					<label for="accountAddress">Address<span class="text-danger">*</span></label>
																					<textarea class="form-control" id="accountAddress" name="accountAddress" rows="2" parsley-trigger="change" data-parsley-trigger="keyup" required placeholder="Enter address"></textarea>
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<div class="form-group">
																					<label for="accountEmail">Email address<span class="text-danger">*</span></label>
																					<input type="email" name="accountEmail" parsley-trigger="change" data-parsley-trigger="keyup" data-parsley-remote data-parsley-remote-validator='validate' data-parsley-remote-message="Email already used" required placeholder="Enter email" class="form-control" id="accountEmail">
																				</div>
																			</div>
																			<div class="col-md-6">
																				<div class="form-group">
																					<label for="accountPassword">Password<span class="text-danger">*</span></label>
																					<input type="password" name="accountPassword" parsley-trigger="change" data-parsley-trigger="keyup" required placeholder="Enter password" class="form-control" id="accountPassword">
																				</div>
																			</div>
																		</div> <!-- end row -->
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
																	<input type="submit" onclick="return confirm('Are you sure?')" id="btnAddOperation" name="btnAddOperation" class="btn btn-success waves-effect waves-light" value="Add">
																</div>
																	</form>
															</div>
														</div>
												</div><!-- /.modal -->
												<div class="text-lg-right">
													<button type="button" class="btn btn-warning waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target="#add-operation-modal"><i class="mdi mdi-plus mr-1"></i> Add New Operation Account</button>
												</div>
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Account ID</th>
														<th>Account Image</th>
                                                        <th>Account Name</th>
														<th>Account Email</th>
														<th>Status</th>
														<th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $db->join("tbl_staff", "tbl_staff.login_id=tbl_login.login_id", "LEFT");
													$db->WHERE("tbl_login.role","Operation","=");
                                                    $accounts = $db->get("tbl_login");
													//print_r("<pre>");
													//print_r($accounts);
													//print_r($db->getLastQuery());
													//print_r("</pre>");
                                                    foreach($accounts as $account)
                                                    {
                                                        ?>
                                                       <tr class="account_row" id="<?=$account['login_id']?>">
                                                            <td><?=$account["staff_id"]?></td>
                                                            <td>
                                                                <img src="<?=$account['staff_profile']?>" alt="profile-img" height="50" width="50" />
                                                            </td>
                                                            <td>
                                                                <?=$account["staff_name"]?>
                                                            </td>
															<td>
                                                                <?=$account["email"]?>
                                                            </td>
															<td>
                                                                <?=$account["status"]?>
                                                            </td>
															<td>
																<a href="account_detail.php?account_id=<?=$account['staff_id']?>"><button type="button" class="btn btn-info waves-effect waves-light mb-2 mr-2">Edit</button></a>
																<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog modal-lg">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h4 class="modal-title">Reissue Password</h4>
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																			</div>
																			<div class="modal-body p-4">
																				<form method="post" action="" class="parsley-examples" enctype="multipart/form-data">
																					<input id="id" name="id" type="hidden" value="">
																					<div class="row">
																						<div class="col-md-6">
																							<div class="form-group">
																								<div class="form-group">
																									<label for="pass1">Password<span class="text-danger">*</span></label>
																									<input id="pass1" type="password" name="pass1" placeholder="Password" required
																										   class="form-control">
																								</div>
																							</div>
																						</div>
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="passWord2">Confirm Password <span class="text-danger">*</span></label>
																								<input data-parsley-equalto="#pass1" type="password"  name="pass2" required
																									   placeholder="Password" class="form-control" id="passWord2">
																							</div>
																						</div>
																					</div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
																				<button type="submit" onclick="return confirm('Are you sure?')" id="btnSave" name="btnSave" class="btn btn-success waves-effect waves-light">Save changes</button>
																			</div>
																				</form>
																		</div>
																	</div>
																</div><!-- /.modal -->
																<button type="button" class="btn btn-success waves-effect waves-light mb-2 mr-2 reissue" data-toggle="modal" data-target="#con-close-modal" value="<?=$account['login_id']?>">Reissue Password</button>
																<?php
																	if($account['status']=="Active")
																	{
																		?>
																			<a href="account_status.php?account_id=<?=$account['login_id']?>&action=terminate" onclick="return confirm('Are you sure?')" ><button type="button" class="btn btn-danger waves-effect waves-light mb-2 mr-2">Terminate</button></a>
																		<?php
																	}
																	else
																	{
																		?>
																			<a href="account_status.php?account_id=<?=$account['login_id']?>&action=active" onclick="return confirm('Are you sure?')" ><button type="button" class="btn btn-warning waves-effect waves-light mb-2 mr-2">Active</button></a>
																		<?php
																	}
																?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
													?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        
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
		
		<script>
		var uploadField = document.getElementById("image");

		uploadField.onchange = function() {
			if(this.files[0].size > 2097152){
			   alert("File is too big!");
			   this.value = "";
			};
		};
		</script>

        <!-- Right Sidebar -->
        <?php include "right_sidebar.php"?>
        <!-- /Right-bar -->

        <!-- Vendor js -->
        <script src="../assets/js/vendor.min.js"></script>

        <!-- third party js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="../assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="../assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script src="../assets/js/pages/datatables.init.js"></script>
		
		<!-- Plugin js-->
        <script src="../assets/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="../assets/js/pages/form-validation.init.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.min.js"></script>
		
		<script>
		$(document).ready(function(){
			$('#basic-datatable tbody tr .reissue').on('click', function () {
				var data = $(this).closest('tr').attr('id');
				$("#id").val(data);
			});
		});
		</script>
		
		<script>
			$("#add_operation").parsley();
			window.Parsley.addAsyncValidator('validate', function (xhr) {
				return 200 === xhr.status;
			}, 'check_duplicate.php');
			
			
			
		</script>
        
    </body>
</html>
