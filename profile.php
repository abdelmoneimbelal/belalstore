<?php 
	ob_start();
	session_start();
	$pagetitle = 'Profile';
	include "init.php";
	if (isset($_SESSION['user'])) {	
	
	$sql = "SELECT * FROM users WHERE username = '$sessionuser'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	
?>
	<h2 class="text-center">My Profile</h2>

	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My Information</div>
				<div class="panel-body">
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-unlock-alt fa-fw"></i>
							<span>Login Name :</span> <?= $row['username'] ?>
						</li> 
						<li>
							<i class="fa fa-envelope-o fa-fw"></i>
							<span>Email :</span> <?= $row['email'] ?>
						</li>
						<li>
							<i class="fa fa-user fa-fw"></i>
							<span>Full Name :</span> <?= $row['fullname'] ?>
						</li>
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Ragister Date :</span> <?= $row['Date'] ?>
						</li>
						<li>
							<i class="fa fa-tags  fa-fw"></i>
							<span>Fav Catgory:</span> 
						</li>
					</ul>	 		
				</div>
			</div>
		</div>
	</div>
	<div class="my_ads block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My Ads</div>
					<div class="panel-body">
						<?php
							if (!empty(getitems('member_id', $row['userid']))){
								echo '<div class="row">';
								foreach (getitems('member_id', $row['userid']) as $item) {
								 	echo '<div class="col-sm-6 col-md-3">';
								 		echo'<div class="thumbnail item_box">';
								 			echo'<span class="price">$'. $item['price'] .'</span>';
								 			echo '<img class="img-responsive" src="des/img/Avatar4.png" alt="Avatar4.png" />';
								 			echo '<div class="caption">';
								 				echo '<h3><a href="items.php?itemid=' . $item['item_id'] .'">'. $item['name'] .'</a></h3>';
								 				/*echo '<p>'. $item['description'] .'</p>';*/
								 			echo '</div>';
								 		echo'</div>';
								 	echo'</div>';	
								 }
								 echo '</div>'; 
							} else {
								echo '<div class="text-center alert alert-info">There\'s no ads to show, create <a href="new_ad.php">new ad</a></div>';
							}
						?>
				</div>
			</div>
		</div>
	</div>
	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">Latest Comments</div>
				<div class="panel-body">
					<?php 
						$userid = $row['userid'];
						$sql2 = "SELECT comment FROM comments WHERE user_id = '$userid' ";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_all(MYSQLI_ASSOC);
						if (! empty($row2)) {
							foreach ($row2 as $comment) {
								echo '<p>'. $comment['comment'] .'</p>';
							}
						} else {
							echo '<div class="text-center alert alert-info">There\'s no comments to show</div>';
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