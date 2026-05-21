<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Country</th>
            <th>DOB</th>
            <th>Passport Number</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM customer";
        $select_bookings=mysqli_query($con, $query);
        while($row=mysqli_fetch_assoc($select_bookings)){
            $cust_id=$row['cust_id'];
            $cust_email=$row['cust_email'];
            $cust_phone=$row['cust_phone'];
            $f_name=$row['f_name'];
            $l_name=$row['l_name'];
            $country=$row['country'];
            $dob=$row['dob'];
            $passport_no=$row['passport_no'];
            echo "<tr><td>{$cust_id}</td>";
            echo "<td>{$f_name} {$l_name}</td>";
            echo "<td>{$cust_email}</td>";
            echo "<td>{$cust_phone}</td>";
            echo "<td>{$country}</td>";
            echo "<td>{$dob}</td>";
            echo "<td>{$passport_no}</td>";
            echo "<td><a href='customers.php?delete={$cust_id}'>Delete</a></td>";
            echo "<td><a href='customers.php?source=edit_customer&p_id={$cust_id}'>Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
if(isset($_GET['delete'])){
    $delete_customer_id=$_GET['delete'];
    $query="DELETE FROM customer WHERE cust_id={$delete_customer_id}";
    $delete_query=mysqli_query($con, $query);    
    header("Location: customers.php");
}
?>
