<?php


if(isset($_GET['p_id'])){
	$the_emp_id=$_GET['p_id'];
}

if(isset($_GET['cat'])){
	$category=$_GET['cat'];
}

$query="SELECT * FROM employee WHERE emp_id={$the_emp_id}";
$select_emps_by_id=mysqli_query($con,$query);

while($row=mysqli_fetch_assoc($select_emps_by_id)){
	$f_name=$row['f_name'];
	$l_name=$row['l_name'];
	$emp_email=$row['emp_email'];
	$emp_phone=$row['emp_phone'];
	$dob=$row['emp_dob'];
	$branch_id=$row['branch_id'];
}

if($category=="Receptionist"){
	$query="SELECT * FROM receptionist WHERE emp_id={$the_emp_id}";
	$select_emps_by_id=mysqli_query($con,$query);

	while($row=mysqli_fetch_assoc($select_emps_by_id)){
		$salary=$row['salary'];
		$counter_no=$row['counter_no'];
	}
}
if($category=="Kitchen staff"){
	$query="SELECT * FROM kitchen_staff WHERE emp_id={$the_emp_id}";
	$select_emps_by_id=mysqli_query($con,$query);

	while($row=mysqli_fetch_assoc($select_emps_by_id)){
		$salary=$row['salary'];
		$expertise=$row['expertise'];
	}
}
if($category=="Manager"){
	$query="SELECT * FROM manager WHERE emp_id={$the_emp_id}";
	$select_emps_by_id=mysqli_query($con,$query);

	while($row=mysqli_fetch_assoc($select_emps_by_id)){
		$salary=$row['salary'];
		$dept_name=$row['dept_name'];
	}
}
if($category=="Room service"){
	$query="SELECT * FROM room_service WHERE emp_id={$the_emp_id}";
	$select_emps_by_id=mysqli_query($con,$query);

	while($row=mysqli_fetch_assoc($select_emps_by_id)){
		$salary=$row['salary'];
		$floor=$row['floor'];
	}
}

if(isset($_POST['update_emp'])){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$emp_email=$_POST['emp_email'];
	$emp_phone=$_POST['emp_phone'];
	$dob=$_POST['dob'];
	$salary=$_POST['salary'];

	$query="UPDATE employee SET f_name ='{$f_name}', l_name ='{$l_name}', emp_email ='{$emp_email}', emp_dob='{$dob}', emp_phone='{$emp_phone}' WHERE emp_id ={$the_emp_id}"; 

	$update_emp=mysqli_query($con,$query);
	if(!$update_emp){
		die("query failed" . mysqli_error($con));
	}

	if($category=="Receptionist"){
	$counter_no=$_POST['counter_no'];
	$query="UPDATE receptionist SET salary ='{$salary}', counter_no ='{$counter_no}' WHERE emp_id ={$the_emp_id}"; 

	$update_emp=mysqli_query($con,$query);
	if(!$update_emp){
		die("query failed" . mysqli_error($con));
	}
}

	if($category=="Kitchen staff"){
		$expertise=$_POST['expertise'];
		$query="UPDATE kitchen_staff SET salary ='{$salary}', expertise ='{$expertise}' WHERE emp_id ={$the_emp_id}"; 

		$update_emp=mysqli_query($con,$query);
		if(!$update_emp){
			die("query failed" . mysqli_error($con));
		}
	}

	if($category=="Manager"){
		$dept_name=$_POST['dept_name'];
		$query="UPDATE manager SET salary ='{$salary}', dept_name ='{$dept_name}' WHERE emp_id ={$the_emp_id}"; 

		$update_emp=mysqli_query($con,$query);
		if(!$update_emp){
			die("query failed" . mysqli_error($con));
		}
	}

	if($category=="Room service"){
		$floor=$_POST['floor'];
		$query="UPDATE room_service SET salary ='{$salary}', floor ='{$floor}' WHERE emp_id ={$the_emp_id}"; 

		$update_emp=mysqli_query($con,$query);
		if(!$update_emp){
			die("query failed" . mysqli_error($con));
		}
	}

	header("Location: employees.php");
}
	
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="f_name">First Name</label>
		<input type="text" value="<?php echo $f_name; ?>" class="form-control" name="f_name">
	</div>
	<div class="form-group">
		<label for="l_name">Last Name</label>
		<input type="text" class="form-control" value="<?php echo $l_name; ?>" name="l_name">
	</div>
	
	<div class="form-group">
		<label for="emp_email">Email</label>
		<input type="email" class="form-control" value="<?php echo $emp_email; ?>" name="emp_email">
	</div>
	<div class="form-group">
		<label for="emp_phone">Phone</label>
		<input type="text" class="form-control" value="<?php echo $emp_phone; ?>" name="emp_phone"  minlength="10" maxlength="10">
	</div>
	<div class="form-group">
		<label for="dob">DOB</label>
		<input type="date" class="form-control" value="<?php echo $dob; ?>" name="dob">
	</div>
	<?php if($category=="Receptionist"){ ?>
		<div class="form-group">
			<label for="salary">Salary</label>
			<input type="text" class="form-control" value="<?php echo $salary; ?>" name="salary">
		</div>
		<div class="form-group">
			<label for="counter_no">Counter Number</label>
			<input type="text" class="form-control" value="<?php echo $counter_no; ?>" name="counter_no">
		</div>
	<?php } ?>
	<?php if($category=="Kitchen staff"){ ?>
		<div class="form-group">
			<label for="salary">Salary</label>
			<input type="text" class="form-control" value="<?php echo $salary; ?>" name="salary">
		</div>
		<div class="form-group">
			<label for="expertise">Expertise</label>
			<input type="text" class="form-control" value="<?php echo $expertise; ?>" name="expertise">
		</div>
	<?php } ?>
	<?php if($category=="Manager"){ ?>
		<div class="form-group">
			<label for="salary">Salary</label>
			<input type="text" class="form-control" value="<?php echo $salary; ?>" name="salary">
		</div>
		<div class="form-group">
			<label for="dept_name">Department Name</label>
			<input type="text" class="form-control" value="<?php echo $dept_name; ?>" name="dept_name">
		</div>
	<?php } ?>
	<?php if($category=="Room service"){ ?>
		<div class="form-group">
			<label for="salary">Salary</label>
			<input type="text" class="form-control" value="<?php echo $salary; ?>" name="salary">
		</div>
		<div class="form-group">
			<label for="floor">Floor</label>
			<input type="text" class="form-control" value="<?php echo $floor; ?>" name="floor">
		</div>
	<?php } ?>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_emp" value="Update employee">
	</div>
</form>