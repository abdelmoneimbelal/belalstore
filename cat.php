<?php 
	session_start();
	include "init.php"; ?>

	<div class="container">
		<h2 class="text-center">Sow cat</h2>
		<div class="row">
			<?php
				$pageid = $_GET['pageid'];

				foreach (getitems('Cat_id', $pageid) as $item) {
				 	echo '<div class="col-sm-6 col-md-3">';
				 		echo'<div class="thumbnail item_box">';
				 			echo'<span class="price">$'. $item['price'] .'</span>';
				 			echo '<img class="img-responsive" src="des/img/Avatar4.png" alt="Avatar4.png" />';
				 			echo '<div class="caption">';
				 				echo '<h3><a href="items.php?itemid=' . $item['item_id'] .'">'. $item['name'] .'</a></h3>';

				 				 /*$str = '<p>'. $item['description'] .'</p>';

				 				if (strlen($str) > 40) {
										echo $str = substr($str, 0, 40) . '...';
									} else {
										echo '<p>'. $item['description'] .'</p>';
									}*/
				 				
				 			echo '</div>';
				 		echo'</div>';
				 	echo'</div>';	
				 } 
			?>
		</div>
	</div>

<?php include $tem1 . "footer.php"; ?>