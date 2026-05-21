<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Dependent ID</th>
            <th>Name</th>
            <th>Passport Number</th>
            <th>Customer ID</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM dependents";
        $select_bookings=mysqli_query($con, $query);
        while($row=mysqli_fetch_assoc($select_bookings)){
            $cust_id=$row['cust_id'];
            $dep_id=$row['dep_id'];
            $dep_name=$row['dep_name'];
            $passport_no=$row['passport_no'];
            echo "<tr><td>{$dep_id}</td>";
            echo "<td>{$dep_name}</td>";
            echo "<td>{$passport_no}</td>";
            echo "<td>{$cust_id}</td>";
            echo "<td><a href='dependents.php?delete={$dep_id}'>Delete</a></td>";
            echo "<td><a href='dependents.php?source=edit_dependent&p_id={$dep_id}'>Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
if(isset($_GET['delete'])){
    $delete_dep_id=$_GET['delete'];
    $query="DELETE FROM dependents WHERE dep_id={$delete_dep_id}";
    $delete_query=mysqli_query($con, $query);    
    header("Location: dependents.php");
}
?>
