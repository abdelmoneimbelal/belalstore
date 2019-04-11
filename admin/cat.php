<?php 

	ob_start();

	session_start();

	$pagetitle = 'Categories';

	if (isset($_SESSION['username'])) {

		include 'init.php';

		$do = '';

		if (isset($_GET['do'])) {
			$do = $_GET['do'];
		} else {
			$do = 'manage';
		}

		//start manage page 

		if ($do == 'manage') { 

			$sort = 'ASC';

			$sort_array = array('ASC', 'DESC');

			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
				$sort = $_GET['sort'];
			}
			
			$sql2 = "SELECT * FROM cat ORDER BY ordering $sort";
			$result2 = $conn->query($sql2);
			$cats = $result2->fetch_all(MYSQLI_ASSOC); ?>

			<h2 class="text-center">Manage Categories</h2>
			<div class="container categories">
				<a href="cat.php?do=add" class="add_cat btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> Manage Categories
						<div class="option pull-right">
							<i class="fa fa-sort"></i> Ordering: [
							<a class="<?php if ($sort == 'ASC') {echo 'active';}?>" href="?sort=ASC">ASC</a> |
							<a class="<?php if ($sort == 'DESC') {echo 'active';}?>" href="?sort=DESC">DESC</a> ]
							<i class="fa fa-eye"></i> View: [ <span class="active" data-view="full">Full</span> | 
							<span data-view="classic">Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
						<?php 

							foreach ($cats as $cat) { 

								echo "<div class='cat'>"; ?>

									<div class="hidden_but">
										<a href="cat.php?do=edit&catid=<?php echo $cat['id'];?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
										<a href="cat.php?do=delete&catid=<?php echo $cat['id'];?>" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> Delete</a>
									</div>

								<?php

									echo '<h3>' . $cat['name'] . '</h3>';
									echo '<div class="full_viwe">';
										echo '<p>'; if ($cat['description'] == '') {
											echo "This category has no description";
										} else {echo $cat['description'];}  echo "</p>";

										if ( $cat['visibility'] == 1) {
											echo '<span class="visibil"><i class="fa fa-eye"></i> Hidden</span>';
										}

										if ( $cat['allow_comment'] == 1) {
											echo '<span class="com"><i class="fa fa-close"></i> Comment Disabled</span>';
										} 

										if ( $cat['allow_ads'] == 1) {
											echo '<span class="ads"><i class="fa fa-close"></i> Ads Disabled</span>';
										} 
									echo '</div>';  
								echo "</div>";

								echo "<hr />";

							}

						?>
					</div>
				</div>
			</div>

        <?php

		} elseif ($do == 'add') { ?>

				<h2 class="text-center">Add New Category</h2>
				<div class="container">
					<form class="form-meb form-horizontal" action="?do=insert" method="POST">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="name" class="form-control" autocomplete="off" placeholder="Category Name" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description :</label>
							<div class="col-sm-10 col-md-8">
								<textarea class="textarea_main form-control" name="description"></textarea>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Ordering :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="ordering" class="form-control" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible :</label>
							<div class="col-sm-10 col-md-8">
								<div>
									<input id="vis_yes" type="radio" name="visible" value="0" checked />
									<label for="vis_yes">Yes</label>
								</div>
								<div>
									<input id="vis_no" type="radio" name="visible" value="1" />
									<label for="vis_no">No</label>
								</div>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting :</label>
							<div class="col-sm-10 col-md-8">
								<div>
									<input id="com_yes" type="radio" name="comment" value="0" checked />
									<label for="com_yes">Yes</label>
								</div>
								<div>
									<input id="com_no" type="radio" name="comment" value="1" />
									<label for="com_no">No</label>
								</div>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads :</label>
							<div class="col-sm-10 col-md-8">
								<div>
									<input id="ads_yes" type="radio" name="ads" value="0" checked />
									<label for="ads_yes">Yes</label>
								</div>
								<div>
									<input id="ads_no" type="radio" name="ads" value="1" />
									<label for="ads_no">No</label>
								</div>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-md-8">
								<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
							</div>
						</div>

					</form>
				</div>

		<?php 


		} elseif ($do == 'insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			echo "<h2 class='text-center'>Insert Category</h2>";

			echo "<div class='container text-center'>";					

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$visible 	= $_POST['visible'];
				$comment 	= $_POST['comment'];
				$ads 		= $_POST['ads'];

					//check if Category in database

					$check = checkitem("name", "cat", $name);

					if ($check == 1) {
						$themsg = '<div class="alert alert-danger">Sorry This Category Is Exist</div>';

						redirecthome($themsg, 'back');
					} else {

						$sql = "INSERT INTO cat (name, description, ordering, visibility, allow_comment, allow_ads) VALUES ('$name', '$desc', '$order', '$visible', '$comment','$ads')" ; 

						$conn->query($sql);

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

			$elid = $_GET['catid'];

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			$sql = "SELECT * FROM cat WHERE id = $elid";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$count =  $result->num_rows;

			//if count > 0 database contain username

			if ($count > 0) { ?>

				<h2 class="text-center">Edit Category</h2>
				<div class="container">
					<form class="form-meb form-horizontal" action="?do=update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>" />
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="name" class="form-control" required="required" value="<?php echo $row['name'];?>" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description :</label>
							<div class="col-sm-10 col-md-8">
								<textarea class="textarea_main form-control" name="description"><?php echo $row['description'];?></textarea>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Ordering :</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="ordering" class="form-control" value="<?php echo $row['ordering'];?>" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible :</label>
							<div class="col-sm-10 col-md-8">
								<div>
									<input id="vis_yes" type="radio" name="visibility" value="0" <?php if ($row['visibility'] == 0) { echo "checked";} ?> />
									<label for="vis_yes">Yes</label>
								</div>
								<div>
									<input id="vis_no" type="radio" name="visibility" value="1" <?php if ($row['visibility'] == 1) { echo "checked";} ?> />
									<label for="vis_no">No</label>
								</div>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting :</label>
							<div class="col-sm-10 col-md-8">
								<div>
									<input id="com_yes" type="radio" name="commenting" value="0" <?php if ($row['allow_comment'] == 0) { echo "checked";} ?> />
									<label for="com_yes">Yes</label>
								</div>
								<div>
									<input id="com_no" type="radio" name="commenting" value="1" <?php if ($row['allow_comment'] == 1) { echo "checked";} ?> />
									<label for="com_no">No</label>
								</div>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads :</label>
							<div class="col-sm-10 col-md-8">
								<div>
									<input id="ads_yes" type="radio" name="ads" value="0" <?php if ($row['allow_ads'] == 0) { echo "checked";} ?> />
									<label for="ads_yes">Yes</label>
								</div>
								<div>
									<input id="ads_no" type="radio" name="ads" value="1" <?php if ($row['allow_ads'] == 1) { echo "checked";} ?> />
									<label for="ads_no">No</label>
								</div>
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
			

		} elseif ($do == 'update') {

							echo "<h2 class='text-center'>Update Member</h2>";

				echo "<div class='container text-center'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$id 		= $_POST['catid'];
					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$order		= $_POST['ordering'];
					$visible	= $_POST['visibility'];
					$comment 	= $_POST['commenting'];
					$ads 		= $_POST['ads'];

					//validate form 
					$UPDATE = '';

					//check if no error

					if (empty($UPDATE)) {
						$sql2 = "UPDATE cat SET name = '$name', description = '$desc', ordering = '$order', visibility = '$visible', allow_comment = '$comment', allow_ads = '$ads'  WHERE id = '$id' ";

						$conn->query($sql2);
						
						$themsg = '<div class="alert alert-success">Success Update</div>';

						redirecthome($themsg, 'back');

					}
					
				} else {
					$themsg = '<div class="alert alert-danger" role="alert">Sorry You Cant Browse This Page</div>';
					redirecthome($themsg, 'back');
				}

				echo "</div>";
			

		} elseif ($do == 'delete') {
			
				echo "<h2 class='text-center'>Delete Category</h2>";

				echo "<div class='container text-center'>";

					//check if request

					$elcatid = $_GET['catid'];

					$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

					$check = checkitem("id", "cat", $catid);
					
					//if count > 0 database contain username

					if ($check > 0) { 

						$sql = "DELETE FROM cat WHERE id = '$elcatid'";
						$conn->query("$sql") ; 

						$themsg = '<div class="alert alert-success">Success Deleted</div>';

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