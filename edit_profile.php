<?php 
	require 'config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	//Get user id 
	$sql_u = "SELECT id FROM users WHERE username = '" .$_SESSION['username'] ."';";
	$results_u = $mysqli->query($sql_u);
	if ( $results_u == false ) {
		echo $mysqli->error;
		exit();
	}
	$row = $results_u->fetch_assoc();
	$user_id = $row['id'];



	$sql = "SELECT alias FROM users
			WHERE id = $user_id;";

	$results_a = $mysqli->query($sql);
	if( !$results_a ) {
		echo $mysqli->error;
		exit();
	}
	
	$row_a = $results_a->fetch_assoc();



	

	if (isset($_POST["alias"]) && isset($_POST["password"]) ){
		if (empty($_POST["alias"]) && empty($_POST["password"])){
			echo '<script>  alert("Please type something dude!"); </script>';
		}else {
			if( !empty($_POST["alias"]) ) {
				
				$sql_prepared = "UPDATE users SET alias = ? WHERE id = $user_id;";
				$statement = $mysqli->prepare($sql_prepared);
				
				$statement->bind_param("s", $_POST["alias"]);

				// Execute the prepared statement
				$executed = $statement->execute();
				// Returns false if error w/ executing the statement
				if(!$executed) {
					echo $mysqli->error;
				}
				
				// If succesful, $statement->affected_rows will return 1
				if($statement->affected_rows == 1) {
					$isUpdated = true;
				}
				$statement->close();
				$flagA = true;

			}	
			if( !empty($_POST["password"]) ) {

				$password = hash("sha256", $_POST['password']);
				
				$sql_prepared = "UPDATE users SET password = ? WHERE id = $user_id;";
				$statement = $mysqli->prepare($sql_prepared);
				
				$statement->bind_param("s", $password);

				// Execute the prepared statement
				$executed = $statement->execute();
				// Returns false if error w/ executing the statement
				if(!$executed) {
					echo $mysqli->error;
				}
				
				// If succesful, $statement->affected_rows will return 1
				if($statement->affected_rows == 1) {
					$isUpdated = true;
				}
				$statement->close();
				$flagP = true;
			}

			if (isset($flagA) && isset($flagP) ){
				echo '<script>  alert("Your alias and password were successfully edited. :)"); </script>';
			}elseif (isset($flagA) ) {
				echo '<script>  alert("Your alias was successfully edited. :)"); </script>';
			}elseif(isset($flagP) ) {
				echo '<script>  alert("Your password was successfully edited. :)"); </script>';
			}
		}
	}
	
	
	$mysqli->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Shhh | Edit Profile</title>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" >
	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Caveat&display=swap" rel="stylesheet">
	<style>
		h1{
			font-family: 'Acme', sans-serif;
			margin-bottom: 10px;
			margin-top: 25px;
		}
		.row{
			margin-top: 20px;
		}
		.alias, .password{
			font-family: 'Acme', sans-serif;
			font-size: 20px;
		}
		form{
			margin-top: 50px;
		}

	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light">
	  <div class="container-fluid">
	  	<a class="navbar-brand" id="brand" href="home.php">Shhh</a>
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>                      
	      </button>
	    </div>
	    
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="navbar-nav ml-xl-5">
	      	<li class="nav-item ml-lg-5 mt-1 hello">Hello <?php echo $_SESSION['username']; ?>!</li>
	        <li class="nav-item ml-lg-5 mt-3"><a href="home.php">Main Page</a></li>
	        <li class="nav-item ml-lg-5 mt-3"><a href="myprofile.php">My Profile</a></li>
	        <li class="nav-item active ml-lg-5 mt-3"><a href="edit_profile.php">Edit Profile</a></li>
	        <li class="nav-item ml-lg-5 mt-3"><a href="logout.php">Log Out</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container">
		<div class="row">
			<h1 class="col-8">Edit Profile:</h1>
		</div> <!-- .row -->
		<form action="" id="edit-form" method="POST">

			<div class="form-group row">
				<label for="alias" class="col-sm-5 col-form-label text-sm-right alias">Edit your alias: </label>
				<div class="col-sm-7">
					<?php 
					if (isset($row_a['alias']) && !empty($row_a['alias'])){
						$alias = $row_a['alias']; 
					}else{
						$alias = "";
					}
					?>
					<input type="text" class="form-control col-5" id="alias" name="alias" value="<?php echo $alias?>">
					
				</div>

			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="password" class="col-sm-5 col-form-label text-sm-right password">Edit your password: </label>
				<div class="col-sm-7">
					<input type="text" class="form-control col-5" id="password" name="password">
					<small id="edit-error" class="invalid-feedback">Please write something dude!</small>
					
				</div>
			</div> <!-- .form-group -->
			
			<div class="form-group row">
					<div class="col-sm-5"></div>
					<div class="col-sm-7 mt-2">
						
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light ml-3">Reset</button>
					</div>
			</div> <!-- .form-group -->

		</form>
		
	</div> <!-- .container -->

	<div id="footer">
		&nbsp;
	</div>
	<script>
		document.getElementById('edit-form').onsubmit = function(){

			if ( document.querySelector('#alias').value.trim().length == 0 && document.querySelector('#password').value.trim().length == 0 ) {
				document.querySelector('#password').classList.add('is-invalid');
			} else {
				document.querySelector('#password').classList.remove('is-invalid');
			}
			
			// return false prevents the form from being submitted
			// If length is greater than zero, then it means validation has failed. Invert the response and can use that to prevent form from being submitted.
			
			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>

</body>
</html>