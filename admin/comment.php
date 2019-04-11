<?php 
	ob_start();

	session_start();
	$pagetitle = 'Comments';
	if (isset($_SESSION['username'])) {
		include 'init.php';

		$do = '';

		if (isset($_GET['do'])) {
			$do = $_GET['do'];
		} else {
			$do = 'manage';
		}

		//start manage page 

		if ($do == 'manage') {//manage Comments page ?>

			<h2 class="text-center">Manage Comments</h2>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>
						<?php  
							// select all users
							$sql = "SELECT
										 comments.*,item.name AS item_name,users.username 

									FROM 
										 comments
									INNER JOIN
										 item
									ON	  
										 item.item_id = comments.item_id
									INNER JOIN	 
										 users
									ON
										 users.userid = comments.user_id
									ORDER BY 
											 c_id DESC";
							$result = $conn->query($sql);
							while($row = $result->fetch_assoc()) {
						?>
			
						<tr>
							<td> <?= $row['c_id']?> </td>
							<td>

							 <?php $str = $row['comment'];
							if (strlen($str) > 60) {
										echo $str = substr($str, 0, 60) . '...';
									} else {
										echo $str;
									}

							 ?> 


							</td>
							<td> <?= $row['item_name']?> </td>
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

		<?php } elseif ($do == 'edit') {//edit page 

			//check if request

			$elcomid = $_GET['comid'];

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

			$sql2 = "SELECT * FROM comments WHERE c_id = $elcomid LIMIT 1";
			$result2 = $conn->query($sql2);
			$row = $result2->fetch_assoc();
			$count =  $result2->num_rows;

			//if count > 0 database contain username

			if ($count > 0) { ?>

				<h2 class="text-center">Edit Comment</h2>
				<div class="container">
					<form class="form-horizontal" action="?do=update" method="POST" />
						<input type="hidden" name="comid" value="<?php echo $comid ?>" />
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment :</label>
							<div class="col-sm-10 col-md-8">
								<textarea class="textarea_com form-control" name="comment">
									<?= $row['comment']?>
								</textarea>
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

				echo "<h2 class='text-center'>Update Comment</h2>";

				echo "<div class='container text-center'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$comid 		= $_POST['comid'];
					$comment 	= $_POST['comment'];
	
					
					$sql2 = "UPDATE comments SET comment = '$comment' WHERE c_id = '$comid'";

					$conn->query($sql2);
					
					$themsg = '<div class="alert alert-success">Success Update</div>';

					redirecthome($themsg, 'back');
					
				} else {
					$themsg = '<div class="alert alert-danger" role="alert">Sorry You Cant Browse This Page</div>';
					redirecthome($themsg, 'back');
				}

				echo "</div>";

			} elseif ($do == 'delete') {
				//delete member page
				echo "<h2 class='text-center'>Delete Comment</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$elcomid = $_GET['comid'];

					$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

					$check = checkitem("c_id", "comments", $comid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql3 = "DELETE FROM comments WHERE c_id = '$elcomid'";
						$conn->query("$sql3") ; 

						$themsg = '<div class="alert alert-success">Success Deleted</div>';

						redirecthome($themsg,"back");

					} else {
						$themsg = '<div class="alert alert-danger" role="alert">This ID Is Not Exist</div>';
						redirecthome($themsg, 'back');
					}
			 	echo "</div>";

			} elseif ($do == 'approve') {
				echo "<h2 class='text-center'>Approve Member</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$elcomid = $_GET['comid'];

					$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

					$check = checkitem("c_id", "comments", $comid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql4 = "UPDATE comments SET status = 1 WHERE c_id = $elcomid";
						$conn->query("$sql4") ; 

						$themsg = '<div class="alert alert-success">Success Approve</div>';

						redirecthome($themsg,"back");

					} else {
						$themsg = '<div class="alert alert-danger" role="alert">This ID Is Not Exist</div>';
						redirecthome($themsg);
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