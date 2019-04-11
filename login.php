<?php 
	ob_start();
	session_start();
	$pagetitle = 'Login';
	if (isset($_SESSION['user'])) {
		header('Location:index.php');
	}
	include "init.php"; 
	//check if user coming form http post request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['login'])) {
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$hashpass = md5($pass);

			//check if the user exist in database

			$sql = "SELECT userid, username, password FROM users WHERE username = '$user' AND password = '$hashpass'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$count =  $result->num_rows;

			//if count > 0 database contain username

			if ($count > 0) {
				$_SESSION['user'] = $user; //SESSION name
				$_SESSION['uid'] = $row['userid']; //SESSION user id
				header('Location:index.php');
				exit();
			}
		} else {
			$fromerrors = array();
			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$hashpass = md5($password);
			$password2 	= $_POST['password2'];
			$email 		= $_POST['email'];

			if (isset($username)) {
				$filteruser = filter_var($username , FILTER_SANITIZE_STRING);
				if (strlen($filteruser) < 4) {
					$fromerrors[] = ' Username Cant Be Less Than <strong>4 Characters</strong>';
				}
			}
			if (isset($password) && isset($password2)) {
				if (empty($password)) {
					$fromerrors[] = 'Sorry password cant be empty';
				}	
				if (md5($password) !== md5($password2)) {
					$fromerrors[] = 'Sorry password is not match';
				}
			}
			if (isset($email)) {
				$filteremail = filter_var($email, FILTER_SANITIZE_EMAIL);
				if (filter_var($filteremail, FILTER_VALIDATE_EMAIL) != true) {
					$fromerrors[] = 'This email is not vaild';
				}
			}

			//check if user add

			if (empty($formerrors)) {

				//check if user in database

				$check = checkitem("username", "users", $username);

				if ($check == 1) {
					$fromerrors[] = 'Sorry This user is exist';

				} else {

					$sql = "INSERT INTO users (username, password, email, ragstatus, `Date`) VALUES ('$username', '$hashpass', '$email', 0, now())" ; 

					$conn->query($sql);

					$succesmsg = 'Congrats you are now ragisterd user';

				}
			}
		}
	}
?>

	<div class="container login_page">
		<h2 class="text-center">
			<span class="selected" data-class="login">Login</span> |
			<span data-class="signup"">Signup</span>
		</h2>
		<!--start login form-->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="input_con">
				<input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" />
			</div>
			<div class="input_con">	
				<input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password" />
			</div>	
			<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
		</form>
		<!--start signup form-->		
		<form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="input_con">
				<input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" />
			</div>	
			<div class="input_con">	
				<input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password" />
			</div>	
			<div class="input_con">	
				<input class="form-control" type="password" name="password2" placeholder="Type a password again" autocomplete="new-password"  />
			</div>	
			<div class="input_con">	
				<input class="form-control" type="email" name="email" placeholder="Email"  />
			</div>	
			<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
		</form>
		<div class="the_errors text-center">
			<?php 
				if (!empty($fromerrors)) {
					// loop errors
					foreach ($fromerrors as $error) {
						echo '<div class="alert alert-danger">' . $error . '</div>';
					}
				}
				if (isset($succesmsg)) {
					echo '<div class="alert alert-success">'. $succesmsg .'</div>';
				}
			?>
		</div>
	</div>

<?php
	 include $tem1 . "footer.php"; 
	 ob_end_flush();