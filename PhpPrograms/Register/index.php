<?php 

include 'config.php';
session_start(); 
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
}

$emailErr = $passErr = "";
$email = $password = "";

if (isset($_POST['submit'])) {


	if (empty($_POST["email"])) {
		$emailErr = 'Email is required';
	} else if (!preg_match( "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" ,$_POST["email"])) {
		$emailErr = 'Invalid email format';
	} else {
		$email = $_POST["email"];
	}

	if (empty($_POST["password"])) {
		$passErr =  'Password is required';
	} else {
		$password = md5($_POST['password']);
	}


	if ( ($email != "") && ($password != "") ) {
		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'"; 
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['username'] = $row['username'];
			header("Location: welcome.php");
		} else {
			echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
		}
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

	<title>Login</title>
</head>
<body>

	<div class="container">
	<a href="http://localhost/covid/Let's%20friendly%20button/index.html" class="button button-accent"> Back</a>
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>">
				<span class="error"><?php echo $emailErr;?></span>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name = "password" >
				<span class="error"><?php echo $passErr; ?> </span>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
		</form>
	</div>
</body>
</html>
