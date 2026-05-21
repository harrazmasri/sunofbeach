<?php

if(isset($_POST['create_simple'])){
	$room_no=$_POST['room_no'];
	$branch_id=$_POST['branch_id'];
	$wifi=$_POST['wifi'];

	$query="SELECT * FROM rooms WHERE room_id=(SELECT MAX(room_id) FROM rooms)";
	$select_room_id=mysqli_query($con, $query);
	while($row=mysqli_fetch_assoc($select_room_id)){
		$room_id=$row['room_id'];
		}
	$room_id=$room_id+1;
	
	$query="INSERT INTO rooms(room_id, room_no, branch_id)";
	$query .="VALUES('{$room_id}', '{$room_no}', '{$branch_id}')";

	$create_room_query=mysqli_query($con,$query);
	confirm($create_room_query);

	$query="INSERT INTO simple(room_id, wifi)";
	$query .="VALUES('{$room_id}', '{$wifi}')";

	$create_room_query=mysqli_query($con,$query);
	confirm($create_room_query);

	echo "Room created: " . " " . "<a href='rooms.php'>View Rooms</a>";
}

if(isset($_POST['create_deluxe'])){
	$room_no=$_POST['room_no'];
	$branch_id=$_POST['branch_id'];
	$wifi=$_POST['wifi'];
	$balcony=$_POST['balcony'];

	$query="SELECT * FROM rooms WHERE room_id=(SELECT MAX(room_id) FROM rooms)";
	$select_room_id=mysqli_query($con, $query);
	while($row=mysqli_fetch_assoc($select_room_id)){
		$room_id=$row['room_id'];
		}
	$room_id=$room_id+1;
	
	$query="INSERT INTO rooms(room_id, room_no, branch_id)";
	$query .="VALUES('{$room_id}', '{$room_no}', '{$branch_id}')";

	$create_room_query=mysqli_query($con,$query);
	confirm($create_room_query);

	$query="INSERT INTO deluxe(room_id, wifi, balcony)";
	$query .="VALUES('{$room_id}', '{$wifi}', {$balcony})";

	$create_room_query=mysqli_query($con,$query);
	confirm($create_room_query);

	echo "Room created: " . " " . "<a href='rooms.php'>View Rooms</a>";
}

if(isset($_POST['create_suite'])){
	$room_no=$_POST['room_no'];
	$branch_id=$_POST['branch_id'];
	$wifi=$_POST['wifi'];
	$jacuzzi=$_POST['jacuzzi'];

	$query="SELECT * FROM rooms WHERE room_id=(SELECT MAX(room_id) FROM rooms)";
	$select_room_id=mysqli_query($con, $query);
	while($row=mysqli_fetch_assoc($select_room_id)){
		$room_id=$row['room_id'];
		}
	$room_id=$room_id+1;
	
	$query="INSERT INTO rooms(room_id, room_no, branch_id)";
	$query .="VALUES('{$room_id}', '{$room_no}', '{$branch_id}')";

	$create_room_query=mysqli_query($con,$query);
	confirm($create_room_query);

	$query="INSERT INTO suite(room_id, wifi, jacuzzi)";
	$query .="VALUES('{$room_id}', '{$wifi}', {$jacuzzi})";

	$create_room_query=mysqli_query($con,$query);
	confirm($create_room_query);

	echo "Room created: " . " " . "<a href='rooms.php'>View Rooms</a>";
}

?>

<style>
	#simple, #deluxe, #suite {
		display: none;
	}
	.dropdown {
		border: 0;
		outline: 0;
		background: none;
	}
	.plus {
		margin-right: 30px;
	}
</style>

<h2><button class="dropdown" onclick="toggle_visibility('simple')"><span class="plus">+</span>Simple </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="simple">
	<div class="form-group">
		<label for="room_no">Room Number</label>
		<input type="text" class="form-control" name="room_no" required>
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
		<label for="wifi">Wifi Password</label>
		<input type="text" class="form-control" name="wifi" required>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_simple" value="Add Room">
	</div>
</form>

<h2><button class="dropdown" onclick="toggle_visibility('deluxe')"><span class="plus">+</span>Deluxe </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="deluxe">
	<div class="form-group">
		<label for="room_no">Room Number</label>
		<input type="text" class="form-control" name="room_no" required>
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
		<label for="wifi">Wifi Password</label>
		<input type="text" class="form-control" name="wifi" required>
	</div>
	<label for="balcony">Balcony</label>
	<select name="balcony">
		<option value="0">No</option>
		<option value="1">Yes</option>
		?>
	</select> <br>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_deluxe" value="Add Room">
	</div>
</form>

<h2><button class="dropdown" onclick="toggle_visibility('suite')"><span class="plus">+</span>Suite </button></h2>
<form action="" method="post" enctype="multipart/form-data" id="suite">
	<div class="form-group">
		<label for="room_no">Room Number</label>
		<input type="text" class="form-control" name="room_no" required>
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
		<label for="wifi">Wifi Password</label>
		<input type="text" class="form-control" name="wifi" required>
	</div>
	<label for="jacuzzi">Jacuzzi</label>
	<select name="jacuzzi">
		<option value="0">No</option>
		<option value="1">Yes</option>
		?>
	</select> <br>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_suite" value="Add Room">
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

