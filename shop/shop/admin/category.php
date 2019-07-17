<?php

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'shop';

$conn = mysqli_connect($host, $username, $password, $db_name); // connect to db

if (isset($_POST['add'])) {
	$name = $_POST['category_name'];
	$desc = $_POST['category_description'];

	$query = "INSERT INTO category (CategoryName, Description) VALUES ('{$name}', '{$desc}')";

	$result = mysqli_query($conn, $query);

	if ($result) {
		$message = "Category Added successfully";
	}
}

if (isset($_POST['update'])) {
	$id = $_GET['edit'];
	$name = $_POST['category_name'];
	$desc = $_POST['category_description'];

	$query = "UPDATE category SET CategoryName = '{$name}', Description = '{$desc}' WHERE CategoryID = {$id}";

	$result = mysqli_query($conn, $query);

	if ($result) {
		$message = "Category Updated successfully";
	}
}

if (isset($_GET['delete'])) {
	$id = $_GET['delete'];

	$query = "DELETE FROM category WHERE CategoryID = {$id}";

	$result = mysqli_query($conn, $query);

	if ($result) $message = "Category Deleted successfully";
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
	<div id="wrapper">
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Home</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav" id="active">
                <li><a href="category.php">Category</a></li>
                <li><a href="product.php">Product</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-user">
                <li class="dropdown messages-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Messages <span class="badge">2</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">2 New Messages</li>
                        <li class="message-preview">
                            <a href="#">
                                <span class="avatar"></span>
                                <span class="message">Security alert</span>
                            </a>
                            <a href="logout.php">Log Out</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#">Go to Inbox <span class="badge">2</span></a></li>
                    </ul>
                </li>
                <li class="dropdown user-dropdown">
                    <ul class="dropdown-menu">
                        <li><a href="#"> Profile</a></li>
                        <!-- <li><a href="#">gear"> Settings</a></li> -->
                        <li class="divider"></li>
                        <li><a href="logout.php"> Log Out</a></li>

                    </ul>
                </li>
                <!-- <li class="divider-vertical"></li>
                <li>
                    <form class="navbar-search">
                        <input type="text" placeholder="Search" class="form-control">
                    </form>
                </li> -->
            </ul>
        </div>
    </nav>
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="col-md-12">
					<div class="row">
						<div class="page-header">
							<h1>Category</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-6">
							<?php
						if(!empty($message)) {
							echo "<h4 class='bg bg-warning' style='text-align: center; padding: 10px;'>{$message}</h4>";
						}
					?>
							<?php 
								if(isset($_GET['edit'])):

								$query = "SELECT * FROM category WHERE CategoryID = {$_GET['edit']}";

								$result = mysqli_query($conn, $query);

								$row = mysqli_fetch_assoc($result); 
							?>
							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="category_name">Category Name</label>
									<input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $row['CategoryName']; ?>">
								</div>

								<div class="form-group">
									<label for="category_description">Category Description</label>
									<input type="text" class="form-control" name="category_description" id="category_description" value="<?php echo $row['Description']; ?>">
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="update" value="Update Category">
								</div>
							</form>
							<?php else: ?>

							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="category_name">Category Name</label>
									<input type="text" class="form-control" name="category_name" id="category_name">
								</div>

								<div class="form-group">
									<label for="category_description">Category Description</label>
									<input type="text" class="form-control" name="category_description" id="category_description">
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="add" value="Add Category">
								</div>
							</form>
						<?php endif; ?>
						</div>

						<div class="col-xs-6">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>S.N.</th>
										<th>Name</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = "SELECT * FROM category";

										$result = mysqli_query($conn, $query);

										while ($row = mysqli_fetch_assoc($result)):
									?>
									<tr>
										<td><?php echo $row['CategoryID']; ?></td>
										<td><?php echo $row['CategoryName']; ?></td>
										<td><?php echo substr($row['Description'], 0, 30).'....'; ?></td>
										<td><a href="?edit=<?php echo $row['CategoryID']; ?>" class="btn btn-primary" style="text-decoration: none;">Edit</a></td>
										<td><a onclick="return confirm('Are you sure?');" href="?delete=<?php echo $row['CategoryID']; ?>" class="btn btn-danger" style="text-decoration: none;">Delete</a></td>
									</tr>
								<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</html>