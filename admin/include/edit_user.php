<?php


if(isset($_GET['u_id'])){
	$the_user_id=$_GET['u_id'];
}

$query="SELECT * FROM login WHERE id={$the_user_id}";
$select_users_by_id=mysqli_query($con,$query);

while($row=mysqli_fetch_assoc($select_users_by_id)){
	$username=$row['username'];
	$user_firstname=$row['user_firstname'];
	$user_lastname=$row['user_lastname'];
	$user_email=$row['user_email'];
	$user_image=$row['user_image'];
	$password=$row['password'];


}
if(isset($_POST['update_user'])){
	$username=$_POST['username'];
	$user_firstname=$_POST['user_firstname'];
	$user_lastname=$_POST['user_lastname'];
	$user_email=$_POST['user_email'];
	$user_image=$_FILES['user_image']['name'];
	$user_image_temp=$_FILES['user_image']['tmp_name'];
	$password=$_POST['password'];

	move_uploaded_file($user_image_temp, "../images/$user_image");
	if(empty($user_image)){
		$query="SELECT * FROM login WHERE id={$the_user_id}";
		$select_image=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($select_image)){
			$user_image=$row['user_image'];
		}
	}

	$query="UPDATE login SET username ='{$username}', user_firstname ='{$user_firstname}', user_lastname ='{$user_lastname}', user_email ='{$user_email}', password ='{$password}', user_image ='{$user_image}' WHERE id ={$the_user_id}"; 

	$update_user=mysqli_query($con,$query);
	if(!$update_user){
		die("query failed" . mysqli_error($con));
	}
	
	header("Location: users.php");
}
	
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" value="<?php echo $username; ?>" name="username" required>
	</div>
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname" required>
	</div>
	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname" required>
	</div>
	<div class="form-group">
		<br><img width='100' src="../images/<?php echo $user_image ?>" ><br>
		<label for="user_image">User Image</label>
		<input type="file" name="user_image">
	</div>
	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email" required>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control" value="<?php echo $password; ?>" name="password" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_user" value="Update User">
	</div>
</form>