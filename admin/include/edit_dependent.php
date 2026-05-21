<?php

if(isset($_GET['p_id'])){
	$the_dep_id=$_GET['p_id'];
}

$query="SELECT * FROM dependents WHERE dep_id={$the_dep_id}";
$select_deps_by_id=mysqli_query($con,$query);

while($row=mysqli_fetch_assoc($select_deps_by_id)){
	$dep_name=$row['dep_name'];
	$passport_no=$row['passport_no'];
}

if(isset($_POST['update_dep'])){
	$dep_name=$_POST['dep_name'];
	$passport_no=$_POST['passport_no'];

	$query="UPDATE dependents SET dep_name ='{$dep_name}', passport_no='{$passport_no}'  WHERE dep_id ={$the_dep_id}"; 

	$update_dep=mysqli_query($con,$query);
	if(!$update_dep){
		die("query failed" . mysqli_error($con));
	}
}
	
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="dep_name">First Name</label>
		<input type="text" value="<?php echo $dep_name; ?>" class="form-control" name="dep_name" required>
	</div>
	<div class="form-group">
		<label for="passport_no">Passport Number</label>
		<input type="text" class="form-control" value="<?php echo $passport_no; ?>" name="passport_no" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_dep" value="Update dependents">
	</div>
</form>