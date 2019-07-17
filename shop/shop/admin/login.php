<?php

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'shop';

$conn = mysqli_connect($host, $username, $password, $db_name); // connect to db

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// clean data
	$username = htmlspecialchars(strip_tags(trim($_POST['username'])));
	$password = htmlspecialchars(strip_tags(trim($_POST['password'])));

	$query = "SELECT * FROM user WHERE username = '{$username}' AND password = '{$password}'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		if($row['status'] == 1) {
			$_SESSION['login'] = 'Loggged in';
			header("Location: category.php");
		} else {
			$message = "Sorry but you are not active";
		}
	} else {
		$message = "Please kindly Input the correct details";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css" type="text/css">
	<title>Fadil's Admin</title>
</head>
<body>
	<div class="container">
		<div class="form-gap"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<?php
						if(!empty($message)) {
							echo "<h4 class='bg bg-warning' style='text-align: center; padding: 10px;'>{$message}</h4>";
						}
					?>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="text-center">
								<h3><i class="glyphicon glyphicon-user"></i></h3>
								<h2 class="text-center">Login</h2>
								<div class="panel-body">
									<form action="" class="form" id="login-form" role="form" autocomplete="off" method="post">
										<div class="form-group">
											<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span><input type="text" class="form-control" name="username" placeholder="Enter Username"></div>
										</div>

										<div class="form-group">
											<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span><input type="password" class="form-control" name="password" placeholder="Enter Password"></div>
										</div>

										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="Login">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<h5 class="text-center">Copyright &copy; 2018 | Designed by Fadil</h5>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>