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
	

	//Get posts 
	$sql_p = "SELECT posts.id, datetime, username, alias, emotion, post  FROM posts
				JOIN users 
				ON users.id = users_id
				LEFT JOIN emotions
				ON emotions.id = emotions_id 
				WHERE users_id = $user_id
				ORDER BY datetime DESC;";

	$results_p = $mysqli->query($sql_p);
	if ( $results_p == false ) {
		echo $mysqli->error;
		exit();
	}

	if(isset($_POST['comment-input'])) {

		if (empty($_POST['comment-input'])){
			echo '<script>  alert("Please write something dude!"); </script>';
		}
		else{
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

			$sql_c = "INSERT INTO comments(comment, posts_id, users_id, datetime)
				VALUE('". $_POST['comment-input'] . "'," .  $_POST["post-id"]. ", " . $user_id . ",'" . $datetime . "');";

			$results_c = $mysqli->query($sql_c);
			if( !$results_c) {
				echo $mysqli->error;
				exit();
			}
			// affected_rows contains the number of rows inserted, updated, ord deleted by the cmomand
			if( $mysqli->affected_rows == 1) {
				$isInserted = true;
			}
			echo '<script>  alert("Success!"); </script>';
		}
	}
	if(isset($_GET['comment-id'])) {
		$sql_d = "DELETE FROM comments WHERE id  =" . $_GET['comment-id'] .";";
		$results_d = $mysqli->query($sql_d);
		if (!$results_d) {
			echo $mysqli->error;
			exit();
		}
		if ($mysqli->affected_rows == 1) {
			$isDeleted = true;
			echo '<script>  alert("Success!"); </script>';
		}
		
	}
	//Get comments 
	$sql_gc = "SELECT comment , comments.id AS id, alias,username, posts_id ,datetime FROM comments
				JOIN users 
				ON users.id = users_id
				ORDER BY datetime DESC;";
	$results_gc = $mysqli->query($sql_gc);
	if ( $results_gc == false ) {
		echo $mysqli->error;
		exit();
	}
	$mysqli->close();
	
?>


<!DOCTYPE html>
<html>
<head>
	<title>Shhh | My Profile</title>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" >
	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Caveat&display=swap" rel="stylesheet">
	<style>
		
		#kanye{
			font-family: 'Caveat', cursive;
			font-size: 35px;
			text-align: center;
			margin-top: 20px;
			margin-bottom: 10px;
			margin-left: 30px;
			margin-right: 30px;

		}
		#by{
			text-align: right;
			display: inline-block;
		}

		h1{
			font-family: 'Acme', sans-serif;
			margin-bottom: 10px;
		}
		.meme{
			width: 60%;
			margin-right: auto;
			margin-left: auto;
			margin-top: 20px;
			margin-bottom: 20px;
		}
		img{
			width: 100%;
		}
		#footer {
			position: relative;
		}
		.wrapper{
			min-height: 100%;

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
	        <li class="nav-item active ml-lg-5 mt-3"><a href="myprofile.php">My Profile</a></li>
	        <li class="nav-item ml-lg-5 mt-3"><a href="edit_profile.php">Edit Profile</a></li>
	        <li class="nav-item ml-lg-5 mt-3"><a href="logout.php">Log Out</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div id="kanye">
		<span id="by"><span>
	</div>
	<div class="container">
		<div class="row">
			<h1 class="col-12">My Posts:</h1>

		</div> <!-- .row -->
		<hr>
	</div> <!-- .container -->
	<div class="wrapper">
	<div class="container">
		<?php
			date_default_timezone_set('America/Los_Angeles');
			$datetime = date('Y-m-d H:i:s');

			// Create an empty array that will be passed to frontend.html
			$results_array = [];
			// Run through results, store them in the $results_array
			while( $row = $results_gc->fetch_assoc() ) {
				array_push( $results_array, $row );
			}

			$flag = false;
		?>

		
			
		<?php while( $row = $results_p->fetch_assoc() ) : ?>
			<?php $flag = true;?>
			<?php if(!empty($row['alias'])){
					$name  = $row['alias'];

				  }else{
					$name = $row['username'];
			      }
			?>
			<strong><?php echo "@" . $name; ?></strong> 
 			<?php echo "&nbsp;  &nbsp; " . $row['datetime']; ?>
 			<?php echo "&nbsp; &nbsp;"?>
 			<?php if(isset($row['emotion']) ) :?>
 				<span class= emotion><?php echo $row['emotion'] . "!";?></span>
 			<?php endif;?>
 			<br>
 			<?php echo $row['post'];?>
 			<br>
 			<p>
				<button data-toggle='collapse' data-target= <?php echo "'#comment_area" . $row["id"] . "' "; ?> aria-expanded='false' aria-controls='comment_area' class='btn btn-outline-dark mt-2 ml-0 btn-sm comment'>
					Comment
				</button>
				<?php if($row['username'] == $_SESSION['username']): ?>
					<a href="delete.php?post_id=<?php echo $row['id']?>" class="btn btn-outline-danger mt-2 ml-2 btn-sm" onclick="return confirm('You sure to delete this post?');">
					Delete</a>
				<?php endif; ?>
				

			</p>
			<div class= "collapse ml-0" id = <?php echo "'comment_area" . $row["id"] . "' "; ?>>
				<form action="" id="comment-form" method="POST">
					<textarea class="form-control" id="comment-input" name="comment-input" rows="2" placeholder="Write a comment here!"></textarea>
					<input type="hidden" name="post-id" value="<?php echo $row["id"]?>" />
					<small id="comment-error" class="invalid-feedback">Please write something dude!</small>
					<button type="submit" class="btn btn-outline-primary mt-2 ml-0" name = "submit-comment">Submit</button>
					<button type="reset" class="btn btn-outline-light mt-2">Reset</button>
				</form>
				<div class="comment-area">
					
					
					<?php foreach ($results_array as $value): ?>
						<?php if($row["id"] == $value["posts_id"]): ?>
							<hr>
							<div class="delete">
								<?php if($value['username']  == $_SESSION['username']): ?>
										
										<a href="myprofile.php?comment-id=<?php echo $value['id']?>"  class="btn btn-outline-danger mt-2 ml-2 btn-sm" onclick="return confirm('You sure to delete this comment?');">
										Delete</a>

								<?php endif; ?>
							</div>
							<i class="far fa-comment-dots ml-2"></i>
							<?php if(!empty($value['alias'])){
									$name  = $value['alias'];
								  }else{
									$name = $value['username'];
								  }
							?>
							<?php echo " &nbsp;@" . $name . ":";?>
							<br>
							<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $value["comment"];?>
							<br>
							<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $value["datetime"];?>
							
						<?php endif;?>
					<?php endforeach; ?>
				</div>
			</div>
 			<hr>
 		<?php endwhile; ?>
 		

 		<?php if(!$flag): ?>
			<div class="meme"><img src="img/meme.jpg" alt="NOPOST"></div>
		<?php endif; ?>
	

	</div>
	</div>

	<div id="footer">
		&nbsp;
	</div>


	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/c7da5373fb.js" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>

	<script>
		//jQuery's AJAX
		$.ajax({
			method: "GET",
			url: "https://api.kanye.rest",
		})
		.done( function(results){
			displayResults( results );
		})
		.fail(function() {
			console.log("ERROR");
		})

		function displayResults(results) {
			console.log(results);
			kanye = document.querySelector("#kanye");
			kanye.innerHTML =  '"'+ results.quote +'"<br><span id = "by">-----Kanye West</span>';

		}
		document.getElementById('comment-form').onsubmit = function(){
			if ( document.querySelector('#comment-input').value.trim().length == 0 ) {
				document.querySelector('#comment-input').classList.add('is-invalid');
			} else {
				document.querySelector('#comment-input').classList.remove('is-invalid');
			}
			
			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>

</body>
</html>