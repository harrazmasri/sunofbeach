<?php

if(isset($_POST['create_user'])){
	$username=$_POST['username'];
	$user_firstname=$_POST['user_firstname'];
	$user_lastname=$_POST['user_lastname'];
	$user_email=$_POST['user_email'];
	$user_image=$_FILES['user_image']['name'];
	$user_image_temp=$_FILES['user_image']['tmp_name'];
	$password=$_POST['password'];

	move_uploaded_file($user_image_temp, "../images/$user_image");

	$query="INSERT INTO login(username, user_firstname, user_lastname, user_image, user_email, password)";
	$query .="VALUES('{$username}', '{$user_firstname}', '{$user_lastname}', '{$user_image}','{$user_email}', '{$password}')";

	$create_user_query=mysqli_query($con,$query);
	confirm($create_user_query);

	echo "User created: " . " " . "<a href='users.php'>View Users</a>";
}

?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" required>
	</div>
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" class="form-control" name="user_firstname" required>
	</div>
	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" name="user_lastname" required>
	</div>
	<div class="form-group">
		<label for="user_image">User Image</label>
		<input type="file" name="user_image">
	</div>
	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="email" class="form-control" name="user_email" required>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_user" value="Add User">
	</div>
</form>