<?php

if(isset($_POST['create_manager'])){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$emp_email=$_POST['emp_email'];
	$emp_phone=$_POST['emp_phone'];
	$emp_dob=$_POST['emp_dob'];
	$salary=$_POST['salary'];
	$branch_id=$_POST['branch_id'];
	$dept_name=$_POST['dept_name'];

	$query="INSERT INTO employee(f_name, l_name, emp_email, emp_phone, emp_dob, branch_id)";
	$query .="VALUES('{$f_name}', '{$l_name}', '{$emp_email}', '{$emp_phone}', '{$emp_dob}', '{$branch_id}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	$query="SELECT * FROM employee WHERE emp_id=(SELECT MAX(emp_id) FROM employee)";

	$select_id=mysqli_query($con,$query);
	while($row=mysqli_fetch_assoc($select_id)){
        $emp_id=$row['emp_id'];
    }

	$query="INSERT INTO manager(emp_id, dept_name, salary)";
	$query .="VALUES('{$emp_id}', '{$dept_name}', '{$salary}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	echo "Employee created: " . " " . "<a href='employees.php'>View employees</a>";
}

if(isset($_POST['create_kitchen_staff'])){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$emp_email=$_POST['emp_email'];
	$emp_phone=$_POST['emp_phone'];
	$emp_dob=$_POST['emp_dob'];
	$salary=$_POST['salary'];
	$branch_id=$_POST['branch_id'];
	$expertise=$_POST['expertise'];

	$query="INSERT INTO employee(f_name, l_name, emp_email, emp_phone, emp_dob, branch_id)";
	$query .="VALUES('{$f_name}', '{$l_name}', '{$emp_email}', '{$emp_phone}', '{$emp_dob}', '{$branch_id}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	$query="SELECT * FROM employee WHERE emp_id=(SELECT MAX(emp_id) FROM employee)";

	$select_id=mysqli_query($con,$query);
	while($row=mysqli_fetch_assoc($select_id)){
        $emp_id=$row['emp_id'];
    }

	$query="INSERT INTO kitchen_staff(emp_id, expertise, salary)";
	$query .="VALUES('{$emp_id}', '{$expertise}', '{$salary}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	echo "Employee created: " . " " . "<a href='employees.php'>View employees</a>";
}

if(isset($_POST['create_receptionist'])){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$emp_email=$_POST['emp_email'];
	$emp_phone=$_POST['emp_phone'];
	$emp_dob=$_POST['emp_dob'];
	$salary=$_POST['salary'];
	$branch_id=$_POST['branch_id'];
	$counter_no=$_POST['counter_no'];

	$query="INSERT INTO employee(f_name, l_name, emp_email, emp_phone, emp_dob, branch_id)";
	$query .="VALUES('{$f_name}', '{$l_name}', '{$emp_email}', '{$emp_phone}', '{$emp_dob}', '{$branch_id}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	$query="SELECT * FROM employee WHERE emp_id=(SELECT MAX(emp_id) FROM employee)";

	$select_id=mysqli_query($con,$query);
	while($row=mysqli_fetch_assoc($select_id)){
        $emp_id=$row['emp_id'];
    }

	$query="INSERT INTO receptionist(emp_id, counter_no, salary)";
	$query .="VALUES('{$emp_id}', '{$counter_no}', '{$salary}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	echo "Employee created: " . " " . "<a href='employees.php'>View employees</a>";
}

if(isset($_POST['create_room_service'])){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$emp_email=$_POST['emp_email'];
	$emp_phone=$_POST['emp_phone'];
	$emp_dob=$_POST['emp_dob'];
	$salary=$_POST['salary'];
	$branch_id=$_POST['branch_id'];
	$floor=$_POST['floor'];

	$query="INSERT INTO employee(f_name, l_name, emp_email, emp_phone, emp_dob, branch_id)";
	$query .="VALUES('{$f_name}', '{$l_name}', '{$emp_email}', '{$emp_phone}', '{$emp_dob}', '{$branch_id}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	$query="SELECT * FROM employee WHERE emp_id=(SELECT MAX(emp_id) FROM employee)";

	$select_id=mysqli_query($con,$query);
	while($row=mysqli_fetch_assoc($select_id)){
        $emp_id=$row['emp_id'];
    }

	$query="INSERT INTO room_service(emp_id, floor, salary)";
	$query .="VALUES('{$emp_id}', '{$floor}', '{$salary}')";

	$create_emp_query=mysqli_query($con,$query);
	confirm($create_emp_query);

	echo "Employee created: " . " " . "<a href='employees.php'>View employees</a>";
}

?>

<style>
	#manager, #kitchen_staff, #receptionist, #room_service {
		display: none;
	}
	.dropdown {
		border: 0;
		outline: 0;
		background: none;
	}
	.plus {
		margin-right: 50px;
	}
</style>

<h2><button class="dropdown" onclick="toggle_visibility('manager')"><span class="plus">+</span>Manager </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="manager">
	<div class="form-group">
		<label for="f_name">First Name</label>
		<input type="text" class="form-control" name="f_name" required>
	</div>
	<div class="form-group">
		<label for="l_name">Last Name</label>
		<input type="text" class="form-control" name="l_name" required>
	</div>
	
	<div class="form-group">
		<label for="emp_email">Email</label>
		<input type="email" class="form-control" name="emp_email" required>
	</div>
	<div class="form-group">
		<label for="emp_phone">Phone</label>
		<input type="text" class="form-control" name="emp_phone" required>
	</div>
	<div class="form-group">
		<label for="emp_dob">DOB</label>
		<input type="date" class="form-control" name="emp_dob" required>
	</div>
	<select name="branch_id">
			<?php 
			$query = "SELECT * FROM hotel";
            $room_branch=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($room_branch)){
                $branch_id=$row['branch_id'];
                $branch_name=$row['branch_name'];
                echo "<option value='{$branch_id}'>{$branch_name}</option>";
            }
			?>
	</select> <br>
	<div class="form-group">
		<label for="salary">Salary</label>
		<input type="text" class="form-control" name="salary" required>
	</div>
	<div class="form-group">
		<label for="dept_name">Department</label>
		<input type="text" class="form-control" name="dept_name" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_manager" value="Add Employee">
	</div>
</form>

<h2><button class="dropdown" onclick="toggle_visibility('receptionist')"><span class="plus">+</span>Receptionist </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="receptionist">
	<div class="form-group">
		<label for="f_name">First Name</label>
		<input type="text" class="form-control" name="f_name" required>
	</div>
	<div class="form-group">
		<label for="l_name">Last Name</label>
		<input type="text" class="form-control" name="l_name" required>
	</div>
	
	<div class="form-group">
		<label for="emp_email">Email</label>
		<input type="email" class="form-control" name="emp_email" required>
	</div>
	<div class="form-group">
		<label for="emp_phone">Phone</label>
		<input type="text" class="form-control" name="emp_phone" required>
	</div>
	<div class="form-group">
		<label for="emp_dob">DOB</label>
		<input type="date" class="form-control" name="emp_dob" required>
	</div>
	<select name="branch_id">
			<?php 
			$query = "SELECT * FROM hotel";
            $room_branch=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($room_branch)){
                $branch_id=$row['branch_id'];
                $branch_name=$row['branch_name'];
                echo "<option value='{$branch_id}'>{$branch_name}</option>";
            }
			?>
	</select> <br>
	<div class="form-group">
		<label for="salary">Salary</label>
		<input type="text" class="form-control" name="salary" required>
	</div>
	<div class="form-group">
		<label for="counter_no">Counter</label>
		<input type="text" class="form-control" name="counter_no" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_receptionist" value="Add Employee">
	</div>
</form>

<h2><button class="dropdown" onclick="toggle_visibility('room_service')"><span class="plus">+</span>Room Service </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="room_service">
	<div class="form-group">
		<label for="f_name">First Name</label>
		<input type="text" class="form-control" name="f_name" required>
	</div>
	<div class="form-group">
		<label for="l_name">Last Name</label>
		<input type="text" class="form-control" name="l_name" required>
	</div>
	
	<div class="form-group">
		<label for="emp_email">Email</label>
		<input type="email" class="form-control" name="emp_email" required>
	</div>
	<div class="form-group">
		<label for="emp_phone">Phone</label>
		<input type="text" class="form-control" name="emp_phone" required>
	</div>
	<div class="form-group">
		<label for="emp_dob">DOB</label>
		<input type="date" class="form-control" name="emp_dob" required>
	</div>
	<select name="branch_id">
			<?php 
			$query = "SELECT * FROM hotel";
            $room_branch=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($room_branch)){
                $branch_id=$row['branch_id'];
                $branch_name=$row['branch_name'];
                echo "<option value='{$branch_id}'>{$branch_name}</option>";
            }
			?>
	</select> <br>
	<div class="form-group">
		<label for="salary">Salary</label>
		<input type="text" class="form-control" name="salary" required>
	</div>
	<div class="form-group">
		<label for="floor">Floor</label>
		<input type="text" class="form-control" name="floor" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_room_service" value="Add Employee">
	</div>
</form>

<h2><button class="dropdown" onclick="toggle_visibility('kitchen_staff')"><span class="plus">+</span>Kitchen Staff </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="kitchen_staff">
	<div class="form-group">
		<label for="f_name">First Name</label>
		<input type="text" class="form-control" name="f_name" required>
	</div>
	<div class="form-group">
		<label for="l_name">Last Name</label>
		<input type="text" class="form-control" name="l_name" required>
	</div>
	
	<div class="form-group">
		<label for="emp_email">Email</label>
		<input type="email" class="form-control" name="emp_email" required>
	</div>
	<div class="form-group">
		<label for="emp_phone">Phone</label>
		<input type="text" class="form-control" name="emp_phone" minlength="10" maxlength="10" required>
	</div>
	<div class="form-group">
		<label for="emp_dob">DOB</label>
		<input type="date" class="form-control" name="emp_dob" required>
	</div>
	<select name="branch_id">
			<?php 
			$query = "SELECT * FROM hotel";
            $room_branch=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($room_branch)){
                $branch_id=$row['branch_id'];
                $branch_name=$row['branch_name'];
                echo "<option value='{$branch_id}'>{$branch_name}</option>";
            }
			?>
	</select> <br>
	<div class="form-group">
		<label for="salary">Salary</label>
		<input type="text" class="form-control" name="salary" required>
	</div>
	<div class="form-group">
		<label for="expertise">Expertise</label>
		<input type="text" class="form-control" name="expertise" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_kitchen_staff" value="Add Employee">
	</div>
</form>

<script type="text/javascript">
	function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
  	}
</script>

