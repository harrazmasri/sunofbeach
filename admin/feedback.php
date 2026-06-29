<?php include "include/admin_header.php"; ?>

<div id="wrapper">

    <?php include "include/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Manage Customer Feedback</small>
                    </h1>

                    <?php
                    if(isset($_GET['source'])){
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }

                    // ==========================================
                    // FUNGSI DELETE (HAPUS) FEEDBACK
                    // ==========================================
                    if(isset($_GET['delete'])){
                        $delete_feedback_id = mysqli_real_escape_string($con, $_GET['delete']);
                        
                        $query = "DELETE FROM feedback WHERE feedback_id = {$delete_feedback_id}";
                        $delete_query = mysqli_query($con, $query);
                        
                        if($delete_query) {
                            header("Location: feedback.php");
                        } else {
                            die("Query Failed: " . mysqli_error($con));
                        }
                    }

                    // SWITCH CASE DYNAMIC ROUTING
                    switch($source){
                        case 'view_details':
                            include "include/view_feedback_details.php";
                            break;
                            
                        default:
                            include "include/view_all_feedbacks.php";
                            break;
                    }
                    ?>

                </div>
            </div>       
        </div>
    </div>
</div>
<script src="js/jquery.js"></script>

<script src="js/bootstrap.min.js"></script>

</body>
</html>