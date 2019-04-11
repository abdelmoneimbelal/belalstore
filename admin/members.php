<?php 
	ob_start();

	session_start();
	$pagetitle = 'Members';
	if (isset($_SESSION['username'])) {
		include 'init.php';

		$do = '';

		if (isset($_GET['do'])) {
			$do = $_GET['do'];
		} else {
			$do = 'manage';
		}

		//start manage page 

		if ($do == 'manage') {//manage Members page 

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] = 'pending') {
				$query = 'AND ragstatus = 0';
			}

		?>

			<h2 class="text-center">Manage Members</h2>
			<div class="container">
				<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Members</a>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registerd Date</td>
							<td>Control</td>
						</tr>
						<?php  
							// select all users
							$sql = "SELECT * FROM users WHERE userid != 1 $query  ORDER BY 
											 userid DESC";
							$result = $conn->query($sql);
							while($row = $result->fetch_assoc()) {
						?>
			
						<tr>
							<td> <?= $row['userid']?> </td>
							<td> <?= $row['username']?> </td>
							<td> <?= $row['email']?> </td>
							<td> <?= $row['fullname']?> </td>
							<td> <?= $row['Date']?> </td>
							<td>
								<a href="members.php?do=edit&userid=<?= $row['userid'] ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
								<a href="members.php?do=delete&userid=<?= $row['userid'] ?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
								<?php if ($row['ragstatus'] == 0) { ?>

									<a href="members.php?do=activate&userid=<?= $row['userid'] ?>" class="btn btn-info"><i class="fa fa-check"></i> Activate</a>

							<?php } ?>

							</td>
						</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>

		<?php } elseif ($do == 'add') { // Add Member ?>

				<h2 class="text-center">Add New Member</h2>
				<div class="container text-center">
					<form class="form-meb form-horizontal" action="?do=insert" method="POST">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="username" class="form-control" autocomplete="off" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password :</label>
							<div class="col-sm-10 col-md-8">
								<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" />
								<i class="show-pass fa fa-eye fa-2x"></i>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email :</label>
							<div class="col-sm-10 col-md-8">
								<input type="email" name="email" class="form-control" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="fullname" class="form-control" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-md-8">
								<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
							</div>
						</div>

					</form>
				</div>
			
		<?php 

			} elseif ($do == 'insert') {
				// insert member page

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h2 class='text-center'>Insert Member</h2>";

				echo "<div class='container text-center'>";					

					$user 	= $_POST['username'];
					$pass 	= $_POST['password'];
					$email 	= $_POST['email'];
					$full 	= $_POST['fullname'];
					$hashpass = md5($_POST['password']);

					//validate form 

					$formerrors = array();

					if (strlen($user) < 4) {
						$formerrors[] = ' Username Cant Be Less Than <strong>4 Characters</strong>';
					}

					if (strlen($user) > 20) {
						$formerrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
					}

					if (empty($user)) {
						$formerrors[] = 'Username Cant Be <strong>Empty</strong>';
					}

					if (empty($pass)) {
						$formerrors[] = 'Password Cant Be <strong>Empty</strong>';
					}					

					if (empty($full)) {
						$formerrors[] = ' Full Name Cant Be <strong>Empty</strong>';
					}

					if (empty($email)) {
						$formerrors[] = ' Email Cant Be <strong>Empty</strong>';
					}

					// loop errors

					foreach ($formerrors as $error) {
						$themsg = '<div class="alert alert-danger">' . $error . '</div>';
						redirecthome($themsg, 'back');
					}

					//check if no error

					if (empty($formerrors)) {

						//check if user in database

						$check = checkitem("username", "users", $user);

						if ($check == 1) {
							$themsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

							redirecthome($themsg, 'back');
						} else {

							$sql = "INSERT INTO users (username, password, email, fullname, ragstatus, `Date`) VALUES ('$user', '$hashpass', '$email', '$full', 0, now())" ; 

							$conn->query($sql);

							$themsg = '<div class="alert alert-success">Success Inserted</div>';

							redirecthome($themsg, 'back');
						}
					}
					
				} else {
					echo "<div class='container text-center'>";

					$themsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page</div>';

					redirecthome($themsg);
					echo "</div>";
				}

				echo "</div>";

			} elseif ($do == 'edit') {//edit page 

			//check if request

			$eluserid = $_GET['userid'];

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			$sql = "SELECT * FROM users WHERE userid = $eluserid LIMIT 1";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$count =  $result->num_rows;

			//if count > 0 database contain username

			if ($count > 0) { ?>

				<h2 class="text-center">Edit Member</h2>

				<div class="container text-center">
					<form class="form-meb form-horizontal" action="?do=update" method="POST" />
						<input type="hidden" name="userid" value="<?php echo $userid ?>" />
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control" autocomplete="off" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password :</label>
							<div class="col-sm-10 col-md-8">
								<input type="hidden" name="oldpassword" class="form-control" value="<?php echo $row['password'] ?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email :</label>
							<div class="col-sm-10 col-md-8">
								<input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="fullname" value="<?php echo $row['fullname'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-md-8">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>

					</form>
				</div>
			<?php

				//else show error message

				} else {
					echo "<div class='container text-center'>";

					$themsg = '<div class="alert alert-danger">Theres No Such ID</div>';
					redirecthome($themsg);

					echo "</div>";
				}

			} elseif ($do == 'update') { // update page

				echo "<h2 class='text-center'>Update Member</h2>";

				echo "<div class='container text-center'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$id 	= $_POST['userid'];
					$user 	= $_POST['username'];
					$email 	= $_POST['email'];
					$full 	= $_POST['fullname'];

					//password trik

					$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : md5($_POST['newpassword']);
					/*
					if (empty($_POST['newpassword'])) {
						$pass = $_POST['oldpassword'];
					} else {
						$pass = md5($_POST['newpassword']);
					}
					*/

					//validate form 
					$formerrors = array();

					if (strlen($user) < 4) {
						$formerrors[] = ' Username Cant Be Less Than <strong>4 Characters</strong>';
					}

					if (strlen($user) > 20) {
						$formerrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
					}

					if (empty($user)) {
						$formerrors[] = 'Username Cant Be <strong>Empty</strong>';
					}

					if (empty($full)) {
						$formerrors[] = ' Full Name Cant Be <strong>Empty</strong>';
					}

					if (empty($email)) {
						$formerrors[] = ' Email Cant Be <strong>Empty</strong>';
					}

					// loop errors

					foreach ($formerrors as $error) {
						$themsg = '<div class="alert alert-danger">' . $error . '</div>';
						redirecthome($themsg, 'back');
					}
					//check if no error

					if (empty($formerrors)) {

						$sql3 = "SELECT * FROM users WHERE username = '$user' AND userid != '$id'";
						$result3 = $conn->query($sql3);
						$count3 =  $result3->num_rows;
						
						if ($count3 == 1) {
							$themsg = '<div class="alert alert-danger" role="alert">Sorry this user is exist</div>';
							redirecthome($themsg, 'back'); 
						} else {
							$sql2 = "UPDATE users SET username = '$user', email = '$email', fullname = '$full', password = '$pass'  WHERE userid = '$id' ";
							$conn->query($sql2);
							$themsg = '<div class="alert alert-success">Success Update</div>';
							redirecthome($themsg, 'back');
						}

						

					}
					
				} else {
					$themsg = '<div class="alert alert-danger" role="alert">Sorry You Cant Browse This Page</div>';
					redirecthome($themsg, 'back');
				}

				echo "</div>";

			} elseif ($do == 'delete') {
				//delete member page
				echo "<h2 class='text-center'>Delete Member</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$eluserid = $_GET['userid'];

					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

					$check = checkitem("userid", "users", $userid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql = "DELETE FROM users WHERE userid = '$eluserid'";
						$conn->query("$sql") ; 

						$themsg = '<div class="alert alert-success">Success Deleted</div>';

						redirecthome($themsg,"back");

					} else {
						$themsg = '<div class="alert alert-danger" role="alert">This ID Is Not Exist</div>';
						redirecthome($themsg, 'back');
					}
			 	echo "</div>";

			} elseif ($do == 'activate') {
				echo "<h2 class='text-center'>Activate Member</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$eluserid = $_GET['userid'];

					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

					$check = checkitem("userid", "users", $userid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql = "UPDATE users SET ragstatus = 1 WHERE userid = $eluserid";
						$conn->query("$sql") ; 

						$themsg = '<div class="alert alert-success">Success Activate</div>';

						redirecthome($themsg,"back");

					} else {
						$themsg = '<div class="alert alert-danger" role="alert">This ID Is Not Exist</div>';
						redirecthome($themsg, 'back');
					}
			 	echo "</div>";
			}


		include $tem1 . "footer.php";

	} else {
		header('Location: index.php');
		exit();
	}

	ob_end_flush();

	?>