<?php
if(isset($_GET['f_id'])){
    $the_feedback_id = mysqli_real_escape_string($con, $_GET['f_id']);
    
    $query = "SELECT * FROM feedback WHERE feedback_id = {$the_feedback_id}";
    $select_feedback_id = mysqli_query($con, $query);
    
    if($row = mysqli_fetch_assoc($select_feedback_id)){
        $cust_id        = $row['cust_id'];
        $review_text    = $row['review_text'];
        $rating         = $row['rating'];
        $date_submitted = $row['date_submitted'];
        
        // Dapatkan nama penuh pelanggan
        $cust_query = "SELECT f_name, l_name FROM customer WHERE cust_id = {$cust_id}";
        $customer_result = mysqli_query($con, $cust_query);
        $customer_name = "Unknown Customer";
        
        if($cust_row = mysqli_fetch_assoc($customer_result)){
            $customer_name = $cust_row['f_name'] . " " . $cust_row['l_name'];
        }
    }
}
?>

<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <a href="feedback.php" class="btn btn-primary">Back to Feedback List</a>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Viewing Feedback ID: #<?php echo $the_feedback_id; ?></strong></h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label>Submitted By:</label>
            <p class="form-control-static"><?php echo htmlspecialchars($customer_name); ?> (Customer ID: <?php echo $cust_id; ?>)</p>
        </div>
        <hr>
        <div class="form-group">
            <label>Rating:</label>
            <p class="form-control-static"><span class="text-warning"><strong><?php echo $rating; ?> / 5 Stars</strong></span></p>
        </div>
        <hr>
        <div class="form-group">
            <label>Date & Time:</label>
            <p class="form-control-static"><?php echo $date_submitted; ?></p>
        </div>
        <hr>
        <div class="form-group">
            <label>Review Content / Message:</label>
            <div class="well" style="background-color: #fff;">
                <?php echo nl2br(htmlspecialchars($review_text)); ?>
            </div>
        </div>
    </div>
</div>