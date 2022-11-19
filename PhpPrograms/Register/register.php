<?php 

include 'config.php';

session_start();

$nameErr = $emailErr = $passErr = $cpassErr = "";
$username = $email = $password = $cpassword = "";


if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {

	if (empty($_POST["username"])) {
		$nameErr = "Username is required";
	} else if (!preg_match("/^[a-zA-Z0-9_.-]*$/", $username)) {
		$nameErr = "Only letters, numbers and _ . - allowed";
	} else {
		$username = $_POST["username"];
	}


	if (empty($_POST["email"])) {
		$emailErr = 'Email is required';
	} else if (!preg_match( "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" ,$_POST["email"])) {
		$emailErr = 'Invalid email format';
	} else {
		$email = $_POST["email"];
	}

	if (empty($_POST["password"])) {
		$passErr =  'Password is required';
	} else if (strlen($_POST["password"]) < 7){
		$passErr = 'Password should have minimum lenght 8';
	} else {
		$password = md5($_POST['password']);
	}

	if (empty($_POST["cpassword"])) {
		$cpassErr =  'Confirm Password';
	} else if ($_POST['password'] != $_POST['cpassword']){
		$cpassErr = 'Password Not Matched.';
	} else{
		$cpassword = md5($_POST['cpassword']);
	}


	if (($username != "") && ($email != "") && ($password != "")) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0) {
			$sql = "INSERT INTO users (username, email, password)
					VALUES ('$username', '$email', '$password')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo "<script>alert('Wow! User Registration Completed.')</script>";
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}
		} else {
			$emailErr = 'Woops! Email Already Exists.';
		}
	} else {
		echo "<script>alert('Woops! Something Wrong Went.')</script>";
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Register Form - Pure Coding</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
		<p><span class="error">* All Fields are required</span></p>
			
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>">
				<span class="error"><?php echo $nameErr;?></span>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>">
				<span class="error"><?php echo $emailErr;?></span>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="">
	            <span class="error"><?php echo $passErr;?></span>
			</div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="">
				<span class="error"><?php echo $cpassErr;?></span>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>