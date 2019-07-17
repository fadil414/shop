<?php

// if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) header("Location: login.php");

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'shop';

$conn = mysqli_connect($host, $username, $password, $db_name); // connect to db

if (isset($_POST['add'])) {
	$name = $_POST['product_name'];
	$manufacturer = $_POST['manufacturer'];
	$price = $_POST['price'];
	$tmp_img = $_FILES['image']['tmp_name'];
	$image = 'img/'.$_FILES['image']['name'].time();
	$stock = $_POST['stock'];
	$category = $_POST['category'];

	move_uploaded_file($tmp_img, '../'.$image);

	$query = "INSERT INTO product (ProductName, Manufacturer, Unitprice, Image, Stock, CategoryID) ";
	$query .= "VALUES ('{$name}', '{$manufacturer}', {$price}, '{$image}', {$stock}, {$category})";

	$result = mysqli_query($conn, $query);

	if ($result) $message = "Product Added Successfully";
}

if (isset($_POST['update'])) {
	$name = $_POST['product_name'];
	$manufacturer = $_POST['manufacturer'];
	$price = $_POST['price'];
	$stock = $_POST['stock'];
	$category = $_POST['category'];

	if (empty($_FILES['image']['name'])) {
		$query = "SELECT Image FROM product WHERE ProductID = {$_GET['edit']}";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
		$image = $row['Image'];
	} else {
		$tmp_img = $_FILES['image']['tmp_name'];
		$image = 'img/'.$_FILES['image']['name'].time();
		move_uploaded_file($tmp_img, '../'.$image);
	}

	$query = "UPDATE product SET ProductName = '{$name}', ";
	$query .= "Manufacturer = '{$manufacturer}', ";
	$query .= "Unitprice = {$price}, ";
	$query .= "Image = '{$image}', ";
	$query .= "Stock = {$stock}, ";
	$query .= "CategoryID = {$category} ";
	$query .= "WHERE ProductID = {$_GET['edit']}";

	$result = mysqli_query($conn, $query);

	if ($result) $message = "Product Updated Successfully";
}

if (isset($_GET['delete'])) {
	$query = "SELECT Image FROM product WHERE ProductID = {$_GET['delete']}";

	$result = mysqli_query($conn, $query);

	$row = mysqli_fetch_assoc($result);

	unlink('../'.$row['Image']);

	$query = "DELETE FROM product WHERE ProductID = {$_GET['delete']}";

	$result = mysqli_query($conn, $query);

	if ($result) $message = "Product Deleted Successfully";
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
                        <li><a href="index.php?url=login"> Log Out</a></li>

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
							<h1>Product</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-4">
							<?php
						if(!empty($message)) {
							echo "<h4 class='bg bg-warning' style='text-align: center; padding: 10px;'>{$message}</h4>";
						}
					?>
							<?php 
								if(isset($_GET['edit'])):

								$query = "SELECT * FROM product p JOIN category c ON p.CategoryID = c.CategoryID WHERE p.ProductID = {$_GET['edit']}";

								$result = mysqli_query($conn, $query);

								$row = mysqli_fetch_assoc($result); 
							?>
							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="product_name">Product Name</label>
									<input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $row['ProductName']; ?>">
								</div>

								<div class="form-group">
									<label for="manufacturer">Manufacturer</label>
									<input type="text" name="manufacturer" class="form-control" id="manufacturer" value="<?php echo $row['Manufacturer']; ?>">
								</div>

								<div class="form-group">
									<label for="price">Unit Price</label>
									<input type="text" name="price" class="form-control" id="price" value="<?php echo $row['Unitprice']; ?>">
								</div>

								<div class="form-group">
									<img src="../<?php echo $row['Image']; ?>" alt="Product Img" height="50"><br>
									<label for="image">Image</label>
									<input type="file" id="image" name="image">
								</div>

								<div class="form-group">
									<label for="stock">Stock</label>
									<input type="number" class="form-control" name="stock" value="<?php echo $row['Stock']; ?>">
								</div>

								<div class="form-group">
									<label for="category">Choose category</label>
									<?php
										$query = "SELECT * FROM category";

										$result = mysqli_query($conn, $query);
									?>
									<select name="category" id="category" class="form-control">
										<option value="">Choose a category</option>
										<?php $catId = $row['CategoryID']; ?>
										<?php while ($row = mysqli_fetch_assoc($result)): ?>
										<?php if ($row['CategoryID'] == $catId): ?>
											<option selected value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
										<?php else: ?>
											<option value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
										<?php endif; ?>
										<?php endwhile; ?>
									</select>
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="update" value="Update Product">
								</div>
							</form>
							<?php else: ?>

							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="product_name">Product Name</label>
									<input type="text" class="form-control" name="product_name" id="product_name">
								</div>

								<div class="form-group">
									<label for="manufacturer">Manufacturer</label>
									<input type="text" name="manufacturer" class="form-control" id="manufacturer">
								</div>

								<div class="form-group">
									<label for="price">Unit Price</label>
									<input type="text" name="price" class="form-control" id="price">
								</div>

								<div class="form-group">
									<label for="image">Image</label>
									<input type="file" id="image" name="image">
								</div>

								<div class="form-group">
									<label for="stock">Stock</label>
									<input type="number" class="form-control" name="stock">
								</div>

								<div class="form-group">
									<label for="category">Choose category</label>
									<?php
										$query = "SELECT * FROM category";

										$result = mysqli_query($conn, $query);
									?>
									<select name="category" id="category" class="form-control">
										<option value="">Choose a category</option>
										<?php while ($row = mysqli_fetch_assoc($result)): ?>
											<option value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
										<?php endwhile; ?>
									</select>
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="add" value="Add Product">
								</div>
							</form>
						<?php endif; ?>
						</div>

						<div class="col-xs-8">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>S.N.</th>
										<th>Name</th>
										<th>Manufacturer</th>
										<th>Price</th>
										<th>Image</th>
										<th>Stock</th>
										<th>Category</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query = "SELECT * FROM product p JOIN category c ON p.CategoryID = c.CategoryID";

										$result = mysqli_query($conn, $query);

										while ($row = mysqli_fetch_assoc($result)):
									?>
									<tr>
										<td><?php echo $row['ProductID']; ?></td>
										<td><?php echo $row['ProductName']; ?></td>
										<td><?php echo $row['Manufacturer']; ?></td>
										<td>$<?php echo round($row['Unitprice']); ?></td>
										<td><img src="../<?php echo $row['Image']; ?>" alt="Product Img" height="50"></td>
										<td><?php echo $row['Stock']; ?></td>
										<td><?php echo $row['CategoryName']; ?></td>
										<td><a href="?edit=<?php echo $row['ProductID']; ?>" class="btn btn-primary" style="text-decoration: none;">Edit</a></td>
										<td><a onclick="return confirm('Are you sure?');" href="?delete=<?php echo $row['ProductID']; ?>" class="btn btn-danger" style="text-decoration: none;">Delete</a></td>
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