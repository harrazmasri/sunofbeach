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
                            <small><?php echo $_SESSION['user'] ?></small>
                    </h1>
                </div>
            </div>
                <!-- /.row -->

                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bed fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php 
                        $query="SELECT * FROM rooms";
                        $select_all_rooms=mysqli_query($con, $query);
                        $post_count=mysqli_num_rows($select_all_rooms);
                            echo "<div class='huge'>$post_count</div>"
                        ?>
                        <div>Rooms</div>
                    </div>
                </div>
            </div>
            <a href="rooms.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user-friends fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <?php 
                        $query="SELECT * FROM customer";
                        $select_all_customers=mysqli_query($con, $query);
                        $customer_count=mysqli_num_rows($select_all_customers);
                            echo "<div class='huge'>$customer_count</div>"
                        ?>
                      <div>Customers</div>
                    </div>
                </div>
            </div>
            <a href="customers.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php 
                        $query="SELECT * FROM employee";
                        $select_all_employees=mysqli_query($con, $query);
                        $employee_count=mysqli_num_rows($select_all_employees);
                            echo "<div class='huge'>$employee_count</div>"
                        ?>
                        <div> Employees</div>
                    </div>
                </div>
            </div>
            <a href="employees.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php 
                        $query="SELECT * FROM Booking";
                        $select_all_bookings=mysqli_query($con, $query);
                        $booking_count=mysqli_num_rows($select_all_bookings);
                            echo "<div class='huge'>$booking_count</div>"
                        ?>
                         <div>Bookings</div>
                    </div>
                </div>
            </div>
            <a href="booking.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php 
$query="SELECT * FROM simple";
$select_all_simple_rooms=mysqli_query($con, $query);
$simple_count=mysqli_num_rows($select_all_simple_rooms);

$query="SELECT * FROM deluxe";
$select_all_deluxe_rooms=mysqli_query($con, $query);
$deluxe_count=mysqli_num_rows($select_all_deluxe_rooms);

$query="SELECT * FROM suite";
$select_all_suite_rooms=mysqli_query($con, $query);
$suite_count=mysqli_num_rows($select_all_suite_rooms);

$query="SELECT * FROM hotel";
$select_all_branches=mysqli_query($con, $query);
$branch_count=mysqli_num_rows($select_all_branches);

$query="SELECT * FROM login";
$select_all_users=mysqli_query($con, $query);
$user_count=mysqli_num_rows($select_all_users);
?>
                <!-- /.row -->
                <div class="row">
                    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Database', 'Count', { role: 'style' }],
          <?php 
          $element_text=['Branches', 'Simple Rooms', 'Deluxe Rooms', 'Suite Rooms', 'Customers', 'Employees', 'Bookings', 'Users'];
          $element_count=[$branch_count, $simple_count, $deluxe_count, $suite_count, $customer_count, $employee_count, $booking_count, $user_count];
          $color_list=['#003f5c', '#58508d', '#58508d', '#58508d', '#bc5090', '#ff6361', '#ffa600', '#f95d6a'];
          for($i=0; $i<8; $i++){
            echo "['{$element_text[$i]}'". ", ". "{$element_count[$i]}, ". "'{$color_list[$i]}'], " ;
          }
          ?>
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
        <div id="columnchart_material" style="width: auto; height: 500px;"></div>

                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
