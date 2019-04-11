<?php
 include '../../connect.php';

if (isset($_POST['id'])) {
		$porduct_id = $_POST['id'];
		$comment = $_POST['comment'];

		$add_to_comment_query = "INSERT INTO comments (comment) VALUES ('$comment')";
		$result = $conn->query($add_to_comment_query);
		if(!$result) {
			echo "ERORR";
		}

		                
       $sql = "SELECT * FROM comments ORDER BY c_id DESC LIMIT 20";
       $result = $conn->query($sql);
       foreach ($result as $comments) {
       	echo $comments['comment'] . '</br>';
       }

}
