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
                        <?php 
                        if(isset($_GET['source'])){
                            $source=$_GET['source'];
                        }
                        else{
                            $source='';
                        }
                        switch($source){
                            
                            case 'edit_dependent';
                            include "include/edit_dependent.php";
                            break;
                            
                            default:
                            include "include/view_all_dependents.php";
                            break;
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
