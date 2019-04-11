<?php 
	ob_start();
	session_start();
	$pagetitle = 'Create new item';
	include "init.php";
	if (isset($_SESSION['user'])) {	

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$fromerrors = array();

			$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
		    $useid		= $_SESSION['uid'];

			if (strlen($name) < 4) {
				$fromerrors[] = 'Item title must be at least 4 characters';
			}

			if (strlen($desc) < 10) {
				$fromerrors[] = 'Item description must be at least 10 characters';
			}

			if (strlen($country) < 2) {
				$fromerrors[] = 'Item country must be at least 4 characters';
			}

			if (empty($price)) {
				$fromerrors[] = 'Item price must be not empty';
			}

			if (empty($status)) {
				$fromerrors[] = 'Item status must be not empty';
			}

			if (empty($category)) {
				$fromerrors[] = 'Item category must be not empty';
			}

			//check if no error

			if (empty($formerrors)) {

				$sql5 = "INSERT INTO item (name, description, price, 	country_made, status, add_date, cat_id, member_id) VALUES ('$name', '$desc', '$price', '$country', '$status', now(), '$category', $useid)" ; 

				$items = $conn->query($sql5);
				if ($items) {
				echo '<div class="text-center alert alert-success">Success item add</div>';

				}

			}
		}	
?>
	<h3 class="text-center"><?php echo $pagetitle ?></h3>
	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"><?php echo $pagetitle ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8">
							<form class="form-meb form-horizontal form_item" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Name </label>
									<div class="col-sm-10 col-md-9">
										<input type="text" name="name" class="form-control live" placeholder="Item Name" required="required" data-class=".live_title" />
									</div>
								</div>
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Description </label>
									<div class="col-sm-10 col-md-9">
										<textarea class="textarea_main form-control live" name="description" data-class=".live_desc" ></textarea>
									</div>
								</div>
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Price </label>
									<div class="col-sm-10 col-md-9">
										<input type="text" name="price" class="form-control live" placeholder="Item Price" required="required" data-class=".live_price" />
									</div>
								</div>
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Country </label>
									<div class="col-sm-10 col-md-9">
										<input type="text" name="country" class="form-control"placeholder="Country Made" required="required" />
									</div>
								</div>
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Status </label>
									<div class="col-sm-10 col-md-9">
										<select name="status">
											<option value="0">...</option>
											<option value="1">New</option>
											<option value="2">Like New</option>
											<option value="3">Uesd</option>
											
										</select>
									</div>
								</div>
								<div class="form-group form-group-lg">
									<label class="col-sm-3 control-label">Category </label>
									<div class="col-sm-10 col-md-9">
										<select name="category">
											<option value="0">...</option>
											<?php 
												$sql7 = "SELECT * FROM cat";
												$result7 = $conn->query($sql7);
												while($row = $result7->fetch_assoc()) { ?>
													<option value="<?php echo $row['id'] ?>">
														<?php echo $row['name'] ?>
													</option>
											<?php		
												}
											?>
										</select>
									</div>
								</div>
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-3 col-sm-10 col-md-9">
										<input type="submit" value="Add Item" class="btn btn-primary btn-md" />
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-4">
							<div class="thumbnail item_box live_preiveiw">
					 			<span class="price">
					 				$<span class="live_price">0</span>
					 			</span>
					 			 <img class="img-responsive" src="des/img/Avatar4.png" alt="Avatar4.png" />
					 			 <div class="caption">
					 				 <h3 class="live_title">Title</h3>
					 				 <p class="live_desc">bescription</p>
					 			 </div>
					 		</div>
						</div>
					</div>
					<!--start looping erroes-->		
					<?php 
						if (!empty($fromerrors)) {
							foreach ($fromerrors as $errors) {
								echo '<div class="text-center alert alert-danger">' . $errors . '</div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
   } else {
   	header('Location: login.php');
   }

 include $tem1 . "footer.php";
 ob_end_flush();