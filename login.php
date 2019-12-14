<?php
require 'config.php';

	// If user attempted to log in (aka submitted the form)
if( isset($_POST['username']) && isset($_POST['password']) ){
		
	if( empty($_POST['username']) || empty($_POST['password']) ) {
		$error = "Please enter a username and password ";
	}
	
	else {
		// Authenticate this user by connection to the DB
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$usernameInput = $_POST["username"];
		// hash the password that user typed in
		$passwordInput = hash("sha256", $_POST["password"]);
		// Look up the user table, see if there is a username/password match
		$sql = "SELECT * FROM users 
			WHERE username = '" . $usernameInput . "' AND password = '" . $passwordInput . "';";

		$results = $mysqli->query($sql);
		if(!$results) {
			echo $mysqli->error;
			exit();
		}

		if($results->num_rows > 0) {
			// Log them in
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $usernameInput;
			// Redirect user to the homepage
			header('Location: home.php');
		}
		else {
			$error = "Invalid username or password";
		}
	}
	
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shhh | Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" >
	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
	<style>
		.container{
			margin-top: 50px;

		}
		img{
			width:20%;
			display: block;
			margin-left: auto;
			margin-right: auto;
			margin-bottom: 20px;
		}
	</style>
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
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="navbar-nav ml-lg-3">
	       	<li class="nav-item ml-md-5 mt-2"><a href="index.php">Home</a></li>
	        <li class="nav-item ml-md-5 mt-2"><a href="register.php">Register</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container">
		<img src="img/logo.png" alt="logo">
		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			

			<div class="form-group row">
				<label for="username-id" class="col-sm-4 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-4 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-5">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-2  col-md-3 col-lg-4"></div>
				<div class="col-sm-5 mt-3 ml-0">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="index.php" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->
		</form>

		<div class="row">
			<div class="col-sm-9 col-lg-8 ml-sm-auto">
				<a href="register.php">Create an account</a>
			</div>
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