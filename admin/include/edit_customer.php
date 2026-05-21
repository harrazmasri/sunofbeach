<?php

if(isset($_GET['p_id'])){
	$the_cust_id=$_GET['p_id'];
}

$query="SELECT * FROM customer WHERE cust_id={$the_cust_id}";
$select_custs_by_id=mysqli_query($con,$query);

while($row=mysqli_fetch_assoc($select_custs_by_id)){
	$f_name=$row['f_name'];
	$l_name=$row['l_name'];
	$cust_email=$row['cust_email'];
	$cust_phone=$row['cust_phone'];
	$country=$row['country'];
	$dob=$row['dob'];
	$passport_no=$row['passport_no'];
}

if(isset($_POST['update_cust'])){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$cust_email=$_POST['cust_email'];
	$cust_phone=$_POST['cust_phone'];
	$country=$_POST['country'];
	$dob=$_POST['dob'];
	$passport_no=$_POST['passport_no'];

	$query="UPDATE customer SET f_name ='{$f_name}', l_name ='{$l_name}', cust_email ='{$cust_email}', dob='{$dob}', country='{$country}', cust_phone='{$cust_phone}', passport_no='{$passport_no}'  WHERE cust_id ={$the_cust_id}"; 

	$update_cust=mysqli_query($con,$query);
	if(!$update_cust){
		die("query failed" . mysqli_error($con));
	}
}
	
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="f_name">First Name</label>
		<input type="text" value="<?php echo $f_name; ?>" class="form-control" name="f_name" required>
	</div>
	<div class="form-group">
		<label for="l_name">Last Name</label>
		<input type="text" class="form-control" value="<?php echo $l_name; ?>" name="l_name" required>
	</div>
	
	<div class="form-group">
		<label for="cust_email">Email</label>
		<input type="email" class="form-control" value="<?php echo $cust_email; ?>" name="cust_email" required>
	</div>
	<div class="form-group">
		<label for="cust_phone">Phone</label>
		<input type="text" class="form-control" value="<?php echo $cust_phone; ?>" name="cust_phone" minlength="10" maxlength="10" required>
	</div>
	<div class="form-group">
		<label for="country">Country</label>
		<input type="text" class="form-control" value="<?php echo $country; ?>" name="country" required>
	</div>
	<div class="form-group">
		<label for="dob">DOB</label>
		<input type="date" class="form-control" value="<?php echo $dob; ?>" name="dob" required>
	</div>
	<div class="form-group">
		<label for="passport_no">Passport Number</label>
		<input type="text" class="form-control" value="<?php echo $passport_no; ?>" name="passport_no" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_cust" value="Update customer">
	</div>
</form>