
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>DOB</th>
            <th>Branch</th>
            <th>Specialization</th>
            <th>Salary</th>
            <th>Delete</th>
            <th>Edit/View</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM employee";
        $select_bookings=mysqli_query($con, $query);
        while($row=mysqli_fetch_assoc($select_bookings)){
            $emp_id=$row['emp_id'];
            $emp_email=$row['emp_email'];
            $emp_phone=$row['emp_phone'];
            $f_name=$row['f_name'];
            $l_name=$row['l_name'];
            $emp_dob=$row['emp_dob'];
            $branch_id=$row['branch_id'];
            $query = "SELECT * FROM hotel WHERE branch_id={$branch_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $branch_name=$row['branch_name'];
                }

            $query = "SELECT * FROM manager WHERE emp_id={$emp_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $specialization="Manager";
                    $salary=$row['salary'];
                }
            $query = "SELECT * FROM receptionist WHERE emp_id={$emp_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $specialization="Receptionist";
                    $salary=$row['salary'];
                }
            $query = "SELECT * FROM kitchen_staff WHERE emp_id={$emp_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $specialization="Kitchen staff";
                    $salary=$row['salary'];
                }
            $query = "SELECT * FROM room_service WHERE emp_id={$emp_id}";
            $select_category=mysqli_query($con, $query);
             while($row=mysqli_fetch_assoc($select_category)){
                $specialization="Room service";
                $salary=$row['salary'];
              }
            echo "<tr><td>{$emp_id}</td>";
            echo "<td>{$f_name} {$l_name}</td>";
            echo "<td>{$emp_email}</td>";
            echo "<td>{$emp_phone}</td>";
            echo "<td>{$emp_dob}</td>";
            echo "<td>{$branch_name}</td>";
            echo "<td>{$specialization}</td>";
            echo "<td>{$salary}</td>";
            echo "<td><a href='employees.php?delete={$emp_id}'>Delete</a></td>";
            echo "<td><a href='employees.php?source=edit_employee&p_id={$emp_id}&cat={$specialization}'>Edit/View</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
if(isset($_GET['delete'])){
    $delete_employee_id=$_GET['delete'];
    $query="DELETE FROM employee WHERE emp_id={$delete_employee_id}";
    $delete_query=mysqli_query($con, $query);
    header("Location: employees.php");
}
?>

