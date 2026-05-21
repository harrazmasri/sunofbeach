<?php include "include/admin_header.php" ?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include "include/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Admin</small>
                        </h1>
                        <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Room ID</th>
            <th>Branch</th>
            <th>Category</th>
            <th>Customer Name</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Amount</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM booking";
        $select_bookings=mysqli_query($con, $query);
        while($row=mysqli_fetch_assoc($select_bookings)){
            $booking_id=$row['Booking_id'];
            $room_id=$row['room_id'];
            $cust_id=$row['cust_id'];
            $branch_id=$row['branch_id'];
            $query= "SELECT * FROM hotel WHERE branch_id={$branch_id}";
            $branch=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($branch)){
                $branch_name=$row['branch_name'];
            }
            echo "<tr><td>{$booking_id}</td>";
            echo "<td>{$room_id}</td>";
            echo "<td>{$branch_name}</td>";
            $query = "SELECT * FROM simple WHERE room_id={$room_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $category='Simple';
                }
            $query = "SELECT * FROM deluxe WHERE room_id={$room_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $category='Deluxe';
                }
            $query = "SELECT * FROM suite WHERE room_id={$room_id}";
                $select_category=mysqli_query($con, $query);
                 while($row=mysqli_fetch_assoc($select_category)){
                    $category='Suite';
                }
            echo "<td>{$category}</td>";
            $query = "SELECT * FROM customer WHERE cust_id={$cust_id}";
            $customer=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($customer)){
                $f_name=$row['f_name'];
                $l_name=$row['l_name'];
            }
            echo "<td>{$f_name} {$l_name}</td>";
            $query = "SELECT * FROM forr WHERE booking_id={$booking_id}";
            $dates=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($dates)){
                $check_in_date=$row['check_in_date'];
                $check_out_date=$row['check_out_date'];
            }
            echo "<td>{$check_in_date}</td>";
            echo "<td>{$check_out_date}</td>";
            $query = "SELECT * FROM bill WHERE cust_id={$cust_id}";
            $bill=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($bill)){
                $amount=$row['Amount'];
            }
            echo "<td>{$amount}</td>";
            echo "<td><a href='booking.php?delete={$booking_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
if(isset($_GET['delete'])){
    $delete_booking_id=$_GET['delete'];
    $query="DELETE FROM booking WHERE Booking_id={$delete_booking_id}";
    $delete_query=mysqli_query($con, $query);
    $query="DELETE FROM bill WHERE cust_id={$cust_id}";
    $delete_query=mysqli_query($con, $query);
    header("Location: booking.php");
}
?>

                    </div>
                 </div>       
            </div>
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
