<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="../images/title.png" style="height: 30px; width: 200px;"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="../index.php">Home Page</a></li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['user'] ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#rooms_dropdown"><i class="fa fa-fw fa-bed"></i> Rooms <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="rooms_dropdown" class="collapse">
                            <li>
                                <a href="rooms.php?source=add_room">Add Rooms</a>
                            </li>
                            <li>
                                <a href="./rooms.php">View Rooms</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="booking.php"><i class="fa fa-fw fa-list"></i> Bookings</a>
                    </li>
                    <li>
                        <a href="customers.php"><i class="fa fa-fw fa-user-friends"></i> Customers</a>
                    </li>
                    <li>
                        <a href="dependents.php"><i class="fa fa-fw fa-user-shield"></i> Dependents</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#employees_dropdown"><i class="fa fa-fw fa-file-text"></i> Employees <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="employees_dropdown" class="collapse">
                            <li>
                                <a href="employees.php?source=add_employee">Add Employees</a>
                            </li>
                            <li>
                                <a href="./employees.php">View All Employees</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-user"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse">
                            <li>
                                <a href="users.php?source=add_user">Add User</a>
                            </li>
                            <li>
                                <a href="users.php">View All Users</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-file"></i> Profile</a>
                    </li> 
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>