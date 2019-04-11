<?php 
	session_start();
	$nonavbar = '';
	$pagetitle = 'Login';

	if (isset($_SESSION['username'])) {
		header('Location:dashboard.php');
	}

	include "init.php";

	//check if user coming form http post request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedpass = md5($password);

		//check if the user exist in database

		$sql = "SELECT userid, username, password FROM users WHERE username = '$username' AND password = '$hashedpass' AND groupid = 1 LIMIT 1";

		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$count =  $result->num_rows;

		//if count > 0 database contain username

		if ($count > 0) {
			$_SESSION['username'] = $username; //SESSION name
			$_SESSION['id'] = $row['userid']; //SESSION id
			header('Location:dashboard.php');
			exit();
		}
	}

?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block btn-lg" type="submit" value="Login" />
	</form>

<?php include $tem1 . "footer.php";?>