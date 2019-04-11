<?php 

	ob_start();

	session_start();

	$pagetitle = 'Items';

	if (isset($_SESSION['username'])) {

		include 'init.php';

		$do = '';

		if (isset($_GET['do'])) {
			$do = $_GET['do'];
		} else {
			$do = 'manage';
		}

		//start manage page 

		if ($do == 'manage') { ?>

			<h2 class="text-center">Manage Items</h2>
			<div class="container">
				<a href="item.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Items</a>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>
						<?php  
							// select all users
							$sql8 = "SELECT
										 item.*, cat.name AS cat_name, users.username 
									 FROM
										  item
									 INNER JOIN
									     cat ON cat.id = item.cat_id
									 INNER JOIN 
								       users ON users.userid = item.member_id
								     ORDER BY 
											 item_id DESC";
							$result8 = $conn->query($sql8);
							while($row = $result8->fetch_assoc()) {
						?>
			
						<tr>
							<td> <?= $row['item_id']?> </td>
							<td> <?= $row['name']?> </td>
							<td> <?= $row['description']?> </td>
							<td> <?= $row['price']?> </td>
							<td> <?= $row['add_date']?> </td>
							<td> <?= $row['cat_name']?> </td>
							<td> <?= $row['username']?> </td>
							<td>
								<a href="item.php?do=edit&itemid=<?= $row['item_id'] ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>

								<a href="item.php?do=delete&itemid=<?= $row['item_id'] ?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
								<?php if ($row['approve'] == 0) { ?>

									<a href="item.php?do=approve&itemid=<?= $row['item_id'] ?>" class="btn btn-info"><i class="fa fa-check"></i> Approve</a>

							<?php } ?>
							</td>
						</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>

		<?php  				

		} elseif ($do == 'add') { ?>

				<h2 class="text-center">Add New Item</h2>
				<div class="container">
					<form class="form-meb form-horizontal" action="?do=insert" method="POST">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="name" class="form-control"placeholder="Item Name" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description :</label>
							<div class="col-sm-10 col-md-8">
								<textarea class="textarea_main form-control" name="description"></textarea>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="price" class="form-control"placeholder="Item Price" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="country" class="form-control"placeholder="Country Made" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status :</label>
							<div class="col-sm-10 col-md-8">
								<select name="status">
									<option value="0">...</option>
									<option value="1">New</option>
									<option value="2">Like New</option>
									<option value="3">Uesd</option>
									
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member :</label>
							<div class="col-sm-10 col-md-8">
								<select name="member">
									<option value="0">...</option>
									<?php 
										$sql6 = "SELECT * FROM users";
										$result6 = $conn->query($sql6);
										while($row = $result6->fetch_assoc()) { ?>
											<option value="<?php echo $row['userid'] ?>">
												<?php echo $row['username'] ?></option>
									<?php		
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category :</label>
							<div class="col-sm-10 col-md-8">
								<select name="category">
									<option value="0">...</option>
									<?php 
										$sql7 = "SELECT * FROM cat";
										$result7 = $conn->query($sql7);
										while($row = $result7->fetch_assoc()) { ?>
											<option value="<?php echo $row['id'] ?>">
												<?php echo $row['name'] ?></option>
									<?php		
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-md-8">
								<input type="submit" value="Add Item" class="btn btn-primary btn-md" />
							</div>
						</div>
					</form>
				</div>

		<?php 

		} elseif ($do == 'insert') {
		
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h2 class='text-center'>Insert Item</h2>";

				echo "<div class='container text-center'>";					

					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$price 		= $_POST['price'];
					$country 	= $_POST['country'];
					$status 	= $_POST['status'];
					$member 	= $_POST['member'];
					$cat 		= $_POST['category'];

					//validate form 

					$formerrors = array();

					if (empty($name)) {
						$formerrors[] = 'Name Cant Be <strong>Empty</strong>';
					}

					if (empty($desc)) {
						$formerrors[] = 'Description Cant Be <strong>Empty</strong>';
					}

					if (empty($price)) {
						$formerrors[] = 'Price Cant Be <strong>Empty</strong>';
					}					

					if (empty($country)) {
						$formerrors[] = 'Country Name Cant Be <strong>Empty</strong>';
					}

					if ($status == 0) {
						$formerrors[] = 'You must choose the <strong>status</strong>';
					}

					if ($member == 0) {
						$formerrors[] = 'You must choose the <strong>member</strong>';
					}

					if ($cat == 0) {
						$formerrors[] = 'You must choose the <strong>category</strong>';
					}

					// loop errors

					foreach ($formerrors as $error) {
						$themsg = '<div class="alert alert-danger">' . $error . '</div>';
						redirecthome($themsg, 'back');
					}

					//check if no error

					if (empty($formerrors)) {

							$sql5 = "INSERT INTO item (name, description, price, 	country_made, status, add_date, cat_id, member_id) VALUES ('$name', '$desc', '$price', '$country', '$status', now(), '$cat', '$member')" ; 

							$conn->query($sql5);

							$themsg = '<div class="alert alert-success">Success Inserted</div>';

							redirecthome($themsg, 'back');
					}
					
				} else {
					echo "<div class='container text-center'>";

					$themsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page</div>';

					redirecthome($themsg, 'back');
					echo "</div>";
				}

				echo "</div>";			

		} elseif ($do == 'edit') {

			//check if request

			$elitemid = $_GET['itemid'];

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			$sql9 = "SELECT * FROM item WHERE item_id = $elitemid";
			$result9 = $conn->query($sql9);
			$row = $result9->fetch_assoc();
			$count =  $result9->num_rows;

			//if count > 0 database contain username

			if ($count > 0) { ?>

				<h2 class="text-center">Edit Item</h2>

				<div class="container text-center">
					<form class="form-horizontal" action="?do=update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="name" class="form-control"placeholder="Item Name" required="required" value="<?= $row['name'] ?>" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description :</label>
							<div class="col-sm-10 col-md-8">
								<textarea class="textarea_main form-control" name="description"><?= $row['description'] ?></textarea>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="price" class="form-control"placeholder="Item Price" required="required" value="<?= $row['price'] ?>" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="country" class="form-control"placeholder="Country Made" required="required" value="<?= $row['country_made'] ?>" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status :</label>
							<div class="col-sm-10 col-md-8">
								<select name="status">
									<option value="1" <?php if ($row['status'] == 1) {
										echo "selected";
									}  ?>>New</option>
									<option value="2" <?php if ($row['status'] == 2) {
										echo "selected";
									}  ?>>Like New</option>
									<option value="3" <?php if ($row['status'] == 3) {
										echo "selected";
									}  ?>>Uesd</option>
									
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member :</label>
							<div class="col-sm-10 col-md-8">
								<select name="member">
									<?php 
										$sql6 = "SELECT * FROM users";
										$result6 = $conn->query($sql6);
										$row6 = $result6->fetch_all(MYSQLI_ASSOC);
										foreach ($row6 as $user) {
												echo "<option value='" . $user['userid'] . "'"; 
												if ($row['member_id'] == $user['userid']) {
													echo 'selected';
												} echo ">"
												. $user['username'] .
												"</option>";
											}	
									?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category :</label>
							<div class="col-sm-10 col-md-8">
								<select name="category">
									<?php 
										$sql7 = "SELECT * FROM cat";
										$result7 = $conn->query($sql7);
										$row7 = $result7->fetch_all(MYSQLI_ASSOC);
										foreach ($row7 as $cat) {
												echo "<option value='" . $cat['id'] . "'"; 
												if ($row['cat_id'] == $cat['id']) {
													echo 'selected';
												} echo ">"
												. $cat['name'] .
												"</option>";	
											}
									?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-md-8">
								<input type="submit" value="Save Item" class="btn btn-primary btn-md" />
							</div>
						</div>
					</form>
					<h2 class="text-center">Manage [ <?= $row['name'] ?> ] Comments</h2>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php  
								// select all users
								$sql = "SELECT
											 comments.*,users.username 
										FROM 
											 comments
										INNER JOIN	 
											 users
										ON
											 users.userid = comments.user_id
										WHERE	 
											 item_id = $itemid";
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc()) {
							?>
				
							<tr>
								<td> <?= $row['comment']?> </td>
								<td> <?= $row['username']?> </td>
								<td> <?= $row['comment_date']?> </td>
								<td>
									<a href="comment.php?do=edit&comid=<?= $row['c_id'] ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
									<a href="comment.php?do=delete&comid=<?= $row['c_id'] ?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
									<?php if ($row['status'] == 0) { ?>

										<a href="comment.php?do=approve&comid=<?= $row['c_id'] ?>" class="btn btn-info"><i class="fa fa-check"></i> Approve</a>

								<?php } ?>

								</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			<?php

				//else show error message

				} else {
					echo "<div class='container text-center'>";

					$themsg = '<div class="alert alert-danger">Theres No Such ID</div>';
					redirecthome($themsg);

					echo "</div>";
				}			
			

		} elseif ($do == 'update') {

				echo "<h2 class='text-center'>Update Item</h2>";

				echo "<div class='container text-center'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$id 		= $_POST['itemid'];
					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$price 		= $_POST['price'];
					$country 	= $_POST['country'];
					$status 	= $_POST['status'];
					$member 	= $_POST['member'];
					$cat 		= $_POST['category'];

					//validate form 

					$formerrors = array();

					if (empty($name)) {
						$formerrors[] = 'Name Cant Be <strong>Empty</strong>';
					}

					if (empty($desc)) {
						$formerrors[] = 'Description Cant Be <strong>Empty</strong>';
					}

					if (empty($price)) {
						$formerrors[] = 'Price Cant Be <strong>Empty</strong>';
					}					

					if (empty($country)) {
						$formerrors[] = 'Country Name Cant Be <strong>Empty</strong>';
					}

					if ($status == 0) {
						$formerrors[] = 'You must choose the <strong>status</strong>';
					}

					if ($member == 0) {
						$formerrors[] = 'You must choose the <strong>member</strong>';
					}

					if ($cat == 0) {
						$formerrors[] = 'You must choose the <strong>category</strong>';
					}


					// loop errors

					foreach ($formerrors as $error) {
						$themsg = '<div class="alert alert-danger">' . $error . '</div>';
						redirecthome($themsg, 'back');
					}
					//check if no error

					if (empty($formerrors)) {
						$sql8 = "UPDATE item SET name = '$name', description = '$desc', price = '$price', country_made = '$country', status = '$status', member_id = '$member', cat_id = '$cat'  WHERE item_id = '$id'";

						$conn->query($sql8);
						
						$themsg = '<div class="alert alert-success">Success Update</div>';

						redirecthome($themsg, 'back');

					}
					
				} else {
					$themsg = '<div class="alert alert-danger" role="alert">Sorry You Cant Browse This Page</div>';
					redirecthome($themsg, 'back');
				}

				echo "</div>";			
			

		} elseif ($do == 'delete') {
			
				echo "<h2 class='text-center'>Delete Item</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$elitemid = $_GET['itemid'];

					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

					$check = checkitem("item_id", "item", $itemid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql = "DELETE FROM item WHERE item_id = '$elitemid'";
						$conn->query("$sql") ; 

						$themsg = '<div class="alert alert-success">Success Deleted</div>';

						redirecthome($themsg,"back");

					} else {
						$themsg = '<div class="alert alert-danger" role="alert">This ID Is Not Exist</div>';
						redirecthome($themsg, 'back');
					}
			 	echo "</div>";			

		} elseif ($do == 'approve') {

				echo "<h2 class='text-center'>Approve Item</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$elitemid = $_GET['itemid'];

					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

					$check = checkitem("item_id", "item", $itemid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql9 = "UPDATE item SET approve = 1 WHERE item_id = $elitemid";
						$conn->query("$sql9") ; 

						$themsg = '<div class="alert alert-success">Success Approved</div>';

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