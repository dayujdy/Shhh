<?php

require 'config.php';
// Second line of defense PHP
if ( !isset($_POST['post']) || empty($_POST['post']) ) {
	$error = "Please write something dude!";
}
else {
	
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');
	if( isset($_POST["emotions_id"]) && !empty($_POST["emotions_id"]) ) {	
		$emotions_id = $_POST["emotions_id"];
	}
	else {
		$emotions_id = "null";
	}

	//Get user id 
	$sql_u = "SELECT id FROM users WHERE username = '" .$_SESSION['username'] ."';";
	$results_u = $mysqli->query($sql_u);
	if ( $results_u == false ) {
		echo $mysqli->error;
		exit();
	}
	$row = $results_u->fetch_assoc();
	$user_id = $row['id'];

	//Get current datetime
	date_default_timezone_set('America/Los_Angeles');
	$datetime = date('Y-m-d H:i:s');

	$sql = "INSERT INTO posts(datetime, emotions_id, users_id, post)
		VALUE('". $datetime . "'," . $emotions_id . ", " . $user_id . ",'" . $_POST['post'] . "');";

	$results = $mysqli->query($sql);
	if( !$results) {
		echo $mysqli->error;
		exit();
	}
	// affected_rows contains the number of rows inserted, updated, ord deleted by the cmomand
	if( $mysqli->affected_rows == 1) {
		$isInserted = true;
	}
	$success = "You just successfully posted!";
	$mysqli->close();

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shhh | Post Confirmation</title>
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
		<?php if ( isset($error) && !empty($error) ) : ?>
			<div class="row">
				<h1 class="col-12 mt-4">Oops!</h1>
			</div> <!-- .row -->
		<?php endif; ?>

		<?php if ( isset($success) && !empty($success) ) : ?>
			<div class="row">
				<h1 class="col-12 mt-4">:)</h1>
			</div> <!-- .row -->
		<?php endif; ?>

	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				
				<?php if ( isset($error) && !empty($error) ) : ?>

					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>

				<?php endif; ?>

				<?php if ( isset($success) && !empty($success) ) : ?>

					<div class="text-success">
						
						<?php echo $success; ?>
					</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="home.php" role="button" class="btn btn-primary">Back to Home Page</a>
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