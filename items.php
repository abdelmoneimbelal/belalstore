<?php 
	ob_start();
	session_start();
	$pagetitle = 'Show item';
	include "init.php";

	$elitemid = $_GET['itemid'];

	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

	$select_item = "SELECT 	 
							item.*, cat.name AS cat_name, users.username 
						 FROM
							  item
						 INNER JOIN
						     cat ON cat.id = item.cat_id
						 INNER JOIN 
					       users ON users.userid = item.member_id	
						 WHERE 
							item_id = $elitemid";
	$result_item = $conn->query($select_item);
	$count_item =  $result_item->num_rows;

	if ($count_item > 0) {
	
	foreach ($result_item as $item ) {
?>
	<h2 class="text-center"><?= $item['name'] ?></h2>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<img class="img-responsive img-thumbnail center-block" src="des/img/Avatar4.png" alt="Avatar4.png" />
			</div>
			<div class="col-md-9 item_info">
				<h3><?= $item['name'] ?></h3>
				<p><i class="fa fa-pencil-square-o fa-fw"></i> Description: <?= $item['description'] ?></p>
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Add date</span> : <?= $item['add_date'] ?>
					</li>
					<li>
						<i class="fa fa-money fa-fw"></i>
						<span>Price</span> : $<?= $item['price'] ?>
					</li>
					<li>
						<i class="fa fa-plane fa-fw"></i>
						<span>Made in</span> : <?= $item['country_made'] ?>
				    </li>
					<li>
						<i class="fa fa-briefcase fa-fw"></i>
						<span>Category</span> : <a href="cat.php?pageid=<?= $item['cat_id'] ?>"><?= $item['cat_name'] ?></a>
					</li>
					<li>
						<i class="fa fa-plus-square fa-fw"></i>
						<span>Added by</span> : <a href="#"><?= $item['username'] ?></a>
					</li>
				</ul>
			</div>
		</div>
		<hr class="coustum_hr" />
		<div class="row">
			<div class="col-md-offset-3 addcomment">
				<h4>Add your comment</h4>
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
					<textarea></textarea>
					<input type="submit" class="btn btn-primary" value="Add comment">
				</form>
			</div>
		</div>
		<hr class="coustum_hr" />
		<div class="row">
			<div class="col-md-3">
				img
			</div>
			<div class="col-md-9">
				comment
			</div>
		</div>
	</div>

	<?php } ?>

<?php
   } else {
   		echo '<div class="text-center alert alert-danger">There\'s no such id</div>';
   }
	include $tem1 . "footer.php";
	ob_end_flush();