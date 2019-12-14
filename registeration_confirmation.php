<?php
require 'config.php';
// Second line of defense, PHP
if ( !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
}
else {
	// Let's add this user to the new user table!
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	// Sanitize user input
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = hash("sha256", $_POST['password']);

	$sql_registered = "SELECT * FROM users
		WHERE username = '" . $username . "';";

	$results_registered = $mysqli->query($sql_registered);
	if(!$results_registered) {
		echo $mysqli->error;
		exit();
	}

	// If more than 0 result came back, it means the username or email already exists in the users table.
	if($results_registered->num_rows > 0) {
		$error = "Username or email has been already taken. Please choose another one.";
	}
	else {
		// Otherwise, insert this user into the users table.
		$sql = "INSERT INTO users(username, password)
				VALUES('" . $username . "','" . $password . "');";
	
		$results = $mysqli->query($sql);
		if(!$results) {
			echo $mysqli->error;
		}	
	}
	$mysqli->close();	
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shhh | Registeration Confirmation</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" >
	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
	
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-light">
	  <div class="container-fluid">
	  	<a class="navbar-brand" id="brand" href="index.php">Shhh</a>
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>                      
	      </button>
	    </div>
	  </div>
	</nav>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><?php echo $_POST['username']; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="login.php" role="button" class="btn btn-primary">Login</a>
			<a href="index.php" role="button" class="btn btn-light">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->
<div id="footer">
	&nbsp;
</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/c7da5373fb.js" crossorigin="anonymous"></script>

</body>
</html>