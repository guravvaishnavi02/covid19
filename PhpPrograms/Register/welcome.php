<?php 

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>  
    <a href="http://localhost/covid/Let's%20friendly%20button/index.html" class="button button-accent"> Back to Home Page</a> 
    <a href="logout.php">Logout</a>

</body>
</html>