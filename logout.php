<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shhh | Logout</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet">
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
	    <div class="collapse navbar-collapse" id="myNavbar">
	       <ul class="navbar-nav ml-lg-3">
	        <li class="nav-item ml-md-5 mt-2"><a href="register.php">Register</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Logout</h1>
			<div class="col-12">You are now logged out.</div>
			<div class="col-12 mt-3">You can go to <a href="index.php">home page</a> or <a href="login.php">log in</a> again.</div>
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