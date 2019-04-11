<?php 

	//function to get catgroeis from database

	function getcat() {

		global $conn;
		$sql3 = "SELECT * FROM cat ORDER BY id ASC";
		$result3 = $conn->query($sql3);
		$row3 = $result3->fetch_all(MYSQLI_ASSOC);
		return $row3;

	}

	//function to get items from database

	function getitems($where, $value) {

		global $conn;
		$sql4 = "SELECT * FROM item WHERE $where = '$value' ORDER BY item_id DESC";
		$result4 = $conn->query($sql4);
		$row4 = $result4->fetch_all(MYSQLI_ASSOC);
		return $row4;

	}	

	// check if user activeted function

	function checkuserstatus($user) {
		global $conn;
		$sql5 = "SELECT username, ragstatus FROM users WHERE username = '$user' AND ragstatus = 0";
		$result5 = $conn->query($sql5);
		$count5 =  $result5->num_rows;
		return $count5;
	}

	//function to check item in database

	function checkitem($select, $from, $value) {

		global $conn;

		$sql = "SELECT $select FROM $from WHERE $select = '$value'";

		$result = $conn->query($sql);
		$count =  $result->num_rows;		
		return $count;

	}




	






	// get title function

	function gettitle() {
		global $pagetitle;

		if (isset($pagetitle)) {
			echo $pagetitle;

		} else {
			echo "Default";
		}
	}


	// redirect function

	function redirecthome($themsg, $url = null, $seconds = 3) { 

			if ($url === null) {
				$url= 'index.php';
				$link = 'Homepage';

		} else {
			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
				$url = $_SERVER['HTTP_REFERER'];
				$link = 'Previous Page';

			} else {
				$url= 'index.php';
				$link = 'Homepage';
			}
		}

		?>

		<?php echo $themsg ?>

		<div class="alert alert-info">You Will Be Redirect To <?php echo $link ?> After <?php echo $seconds ?> Seconds</div>

		<?php	
			header("refresh:$seconds;url=$url");
			exit();

		}


	//function to check item in database

	/*function checkitem($select, $from, $value) {

		global $conn;

		$sql = "SELECT $select FROM $from WHERE $select = '$value'";

		$result = $conn->query($sql);
		$count =  $result->num_rows;		
		return $count;

	}*/

	// function count items

	function countitems($item, $tabel) {

		global $conn;

		$sql1 = "SELECT $item FROM $tabel";
		$result1 = $conn->query($sql1);
		$count1 =  $result1->num_rows;
		return $count1;
	}


	//function to get latest items from database


	function getlatest($select, $tabel, $order, $limit = 5) {

		global $conn;
		$sql2 = "SELECT $select FROM $tabel ORDER BY $order DESC LIMIT $limit";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_all(MYSQLI_ASSOC);
		return $row2;

	}

