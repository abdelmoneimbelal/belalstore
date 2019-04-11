<?php 
	ob_start();

	session_start();
	if (isset($_SESSION['username'])) {

		$pagetitle = 'Dashboard';

		include 'init.php';


		?>

		<div class="home_stats">
			<div class="container text-center">
				<h2>Dashboard</h2>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st_Members">
							<i class="fa fa-users"></i>
							<div class="info">
								Total Members
								<span><a href="members.php"><?PHP echo countitems('userid', 'users') ?></a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st_Pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
								Pending Members
								<span><a href="members.php?do=manage&page=Pending"><?= checkitem('ragstatus', 'users', 0)?></a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st_Items">	
							<i class="fa fa-tag"></i>
							<div class="info">
								Total Items
								<span><a href="item.php"><?PHP echo countitems('item_id', 'item') ?></a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st_Comments">
							<i class="fa fa-comments"></i>
							<div class="info">
								Total Comments
								<span>
									<span><a href="comment.php"><?PHP echo countitems('c_id', 'comments') ?></a></span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="latest">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i> Latest Registerd Users 
								<span class="toggle_info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled thelatest">
									<?php 

										$latestusers = getlatest("*", "users", "userid", 5);

										foreach ($latestusers as $user) {
											echo '<li>' . $user['fullname'] . '<span class="btn btn-success pull-right"><a href="members.php?do=edit&userid=' . $user['userid'] . '"><i class="fa fa-edit"></i> Edit
											</a></span></li>';
										}	
									?>
								</ul>
							</div>
						</div>
					</div>
					<!-- start latest comments -->
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> Latest Items
								<span class="toggle_info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled thelatest">
									<?php 
										$latestitem = getlatest("*", "item", "item_id", 5);

										foreach ($latestitem as $items) {
											echo '<li>' . $items['name'] . '<span class="btn btn-success pull-right"><a href="item.php?do=edit&itemid=' . $items['item_id'] . '"><i class="fa fa-edit"></i> Edit
											</a></span></li>';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i> Latest Comments
								<span class="toggle_info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
									$sql = "SELECT
											 comments.*,users.username 
										FROM 
											 comments
										INNER JOIN	 
											 users
										ON
											 users.userid = comments.user_id
										ORDER BY 
											 c_id DESC
										LIMIT 5";
									$result = $conn->query($sql);
									$row = $result->fetch_all(MYSQLI_ASSOC); 

									foreach ($row as $comment) {
										echo '<div class="com_box">';
											echo '<a href="members.php?do=edit&userid='. $comment['user_id'].'"><span class="member_n">' 
													. $comment['username'] .
												 '</span></a>';
											echo '<p class="member_c">' 
													. $comment['comment'] .
												 '</p>';	 	 
										echo '</div>';
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- End latest comments -->
			</div>
		</div>
 
		<?php
		
		include $tem1 . "footer.php";

	} else {
		header('Location: index.php');
		exit();
	}

	ob_end_flush();

	?>