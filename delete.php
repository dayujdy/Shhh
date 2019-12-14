<?php

	require 'config.php';
	// Second line of defense
	if ( !isset($_GET['post_id']) || empty($_GET['post_id']) ) {
		$error = "Invalid post!";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		//Delete the comments under the post first
		$sql = "DELETE FROM comments WHERE posts_id  =" . $_GET['post_id'] .";";
		$results = $mysqli->query($sql);
		if (!$results) {
			echo $mysqli->error;
			exit();
		}
		
		$sql2 = "DELETE FROM posts WHERE posts.id =" . $_GET['post_id'] .";";
		$results2 = $mysqli->query($sql2);
		if (!$results2) {
			echo $mysqli->error;
			exit();
		}

		if ($mysqli->affected_rows == 1) {
			$isDeleted = true;
		}
		$success = "Your post was successfully deleted.";
		$mysqli->close();
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Shhh | Delete</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" >
	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Caveat&display=swap" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-light">
	  <div class="container-fluid">
	  	<a class="navbar-brand" id="brand" href="home.php">Shhh</a>
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
				<a href="myprofile.php" role="button" class="btn btn-primary">Back to My Profile</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div id="footer">
		&nbsp;
	</div>

</body>
</html>