<?php 

include 'connect.php';

$nameErr = $emailErr = $commentErr = "";
$name = $email = $comment = "";

if (isset($_POST['submit'])) { // Check press or not Post Comment Button

	if (empty($_POST["name"])) {
		$nameErr = 'Name is required';
	} else {
		$name = $_POST["name"];
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			$nameErr = 'Only letters and white space allowed';
		}
	}


	if (empty($_POST["email"])) {
		$emailErr = 'Email is required';
	} else {
		$email = $_POST["email"];
		// check if e-mail address is well-formed
		if (!preg_match( "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" ,$email)) {
			$emailErr = 'Invalid email format';
		}
	}


	if (empty($_POST["comment"])) {
		$commentErr =  'Comment is required';
	} else {
		$comment = $_POST["comment"];
	}


    if (($name != "") && ($email != "") && ($comment != "")){
		$sql = "INSERT INTO comments (name, email, comment)
		VALUES ('$name', '$email', '$comment')";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Comment added successfully.')</script>";
		} else {
			echo "<script>alert('Comment does not add.')</script>";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Comments</title>
</head>
<body>
<a href="http://localhost/covid/Let's%20friendly%20button/index.html" class="button button-accent"> Back to Home Page</a> 

	<div class="wrapper">

		<form method="post" action="" class= "form">
		<p><span class="error">* All Fields are required</span></p>
			<div class="row">

				<div class="input-group">
				<label for="name">Name:</label>
				<span class="error"><?php echo $nameErr;?></span>
                <input type="text"id="name" placeholder="Enter Name" name="name">
                

				
				</div>

				<div class="input-group">

				<label for="email">Email:</label>
				<span class="error"><?php echo $emailErr;?></span>
                <input type="email" id="email" placeholder="Enter email" name="email">
                
					
				</div>

			</div>

			<div class="input-group textarea">
			    <label for="comment">Comment:</label>
				<span class="error"><?php echo $commentErr;?></span>
                <textarea id="comment" name="comment" placeholder="Enter your Comment"></textarea>
                
			</div>


			<div class="input-group">
				<button name="submit" class="btn">Post Comment</button>
			</div>

		</form>

		<div class="prev-comments">
			<?php 
			
			$sql = "SELECT * FROM comments";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {

			?>
			<div class="single-item">
				<h4><?php echo $row['name']; ?></h4>
				<a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
				<p><?php echo $row['comment']; ?></p>
			</div>
			<?php

				}
			}
			
			?>
		</div>

	</div>
</body>
</html>