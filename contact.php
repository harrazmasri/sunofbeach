<?php 
include "db.php"; // Memastikan sambungan ke database Hotel_management aktif

$message = ""; // Pembolehubah untuk menyimpan status mesej

// PROSES PENGHANTARAN BORANG (SUBMIT)
if(isset($_POST['submit_feedback'])) {
    // Memaksa cust_id menjadi integer untuk keselamatan query SQL
    $cust_id     = (int)$_POST['cust_id']; 
    $rating      = mysqli_real_escape_string($con, $_POST['rating']);
    $review_text = mysqli_real_escape_string($con, $_POST['review_text']);

    // Validasi ringkas: Pastikan Customer ID wujud dalam database sebelum boleh hantar review
    $check_cust = mysqli_query($con, "SELECT * FROM customer WHERE cust_id = {$cust_id}");
    
    if(mysqli_num_rows($check_cust) > 0) {
        if(!empty($review_text) && !empty($rating)) {
            
            // Masukkan data ke dalam jadual feedback mengikut struktur SQL anda
            $query = "INSERT INTO feedback(cust_id, review_text, rating, date_submitted) ";
            $query .= "VALUES({$cust_id}, '{$review_text}', {$rating}, NOW())";
            
            $insert_feedback = mysqli_query($con, $query);
            
            if($insert_feedback) {
                $message = "<div class='alert alert-success' style='color: #fff; background-color: #3c763d; border-color: #d6e9c6; padding: 15px; margin-bottom: 20px;'>Thank you! Your feedback has been submitted successfully.</div>";
            } else {
                $message = "<div class='alert alert-danger' style='color: #fff; background-color: #a94442; border-color: #ebccd1; padding: 15px; margin-bottom: 20px;'>Database Error: " . mysqli_error($con) . "</div>";
            }
        } else {
            $message = "<div class='alert alert-warning' style='color: #fff; background-color: #8a6d3b; border-color: #faebcc; padding: 15px; margin-bottom: 20px;'>Please fill in all fields.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger' style='color: #fff; background-color: #a94442; border-color: #ebccd1; padding: 15px; margin-bottom: 20px;'>Invalid Customer ID. Please check your registered Customer ID.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contact Us</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Resort Inn Responsive , Smartphone Compatible web template , Samsung, LG, Sony Ericsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
                function hideURLbar(){ window.scrollTo(0,1); } </script>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/font-awesome.css" rel="stylesheet"> 
        <link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen" />
        <link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css'/>
        <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" property="" />
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/modernizr-2.6.2.min.js"></script>
        <link href="//fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Federo" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        </head>
<body>
<?php include "include/navigation.php"; ?>
<section class="contact-w3layouts" id="contact" style="padding-top: 100px;">
    <div class="container">
        <div class="col-md-6 col-sm-6 contact-left-w3-agile">
            <h4 class="w3layouts-contact-head">Connect With Us</h4>
            <p class="contact-agile1"><strong>Phone :</strong> +60 12-3456789</p>
            <p class="contact-agile1"><strong>Email :</strong> <a href="mailto:info@sunofbeach.com">info@sunofbeach.com</a></p>
            <p class="contact-agile1"><strong>Address :</strong> No. 30, Jalan Pelangi, Taman Cockroach, Selangor, Malaysia</p>
                                                                
            <div class="social-bnr-agileits footer-icons-agileinfo">
                <ul class="social-icons3">
                    <li><a href="#" class="fa fa-facebook icon-border facebook"> </a></li>
                    <li><a href="#" class="fa fa-twitter icon-border twitter"> </a></li>
                    <li><a href="#" class="fa fa-google-plus icon-border googleplus"> </a></li> 
                </ul>
            </div>
            <iframe src="https://maps.google.com/maps?q=Selangor,Malaysia&t=&z=13&ie=UTF8&iwloc=&output=embed" style="border:0; width:100%; height:250px;" allowfullscreen=""></iframe>
        </div>

        <div class="col-md-6 col-sm-6 contact-w3-agile2" data-aos="flip-left">
            <h4>Feedback & Review</h4>
            <p class="contact-agile2">We value your experience at Sun of Beach Resort. Leave us a review!</p>
            
            <?php 
            // Paparkan mesej status jika ada
            if(!empty($message)) { 
                echo $message; 
            } 
            ?>
            
            <form action="contact.php" method="post" name="sentMessage" id="contactForm">
                
                <div class="control-group form-group">
                    <label class="contact-p1">Customer ID:</label>
                    <input type="number" class="form-control" name="cust_id" placeholder="Enter your Customer ID (e.g. 1)" required>
                    <p class="help-block"></p>
                </div>	
                
                <div class="control-group form-group">
                    <label class="contact-p1">Rating:</label>
                    <select class="form-control" name="rating" required style="background:#fff; border:1px solid #ccc; color:#333; height: 45px;">
                        <option value="">-- Select Rating --</option>
                        <option value="5">5 Stars (Excellent)</option>
                        <option value="4">4 Stars (Good)</option>
                        <option value="3">3 Stars (Average)</option>
                        <option value="2">2 Stars (Poor)</option>
                        <option value="1">1 Star (Very Bad)</option>
                    </select>
                    <p class="help-block"></p>
                </div>
                
                <div class="control-group form-group">
                    <label class="contact-p1">Your Review:</label>
                    <textarea class="form-control" rows="5" name="review_text" placeholder="Write your experience here..." required style="background:#fff; border:1px solid #ccc; color:#333; resize:none;"></textarea>
                    <p class="help-block"></p>
                </div>
                
                <input type="submit" name="submit_feedback" value="Send Feedback" class="btn btn-primary" style="background-color: #ff9800; border-color: #ff9800; padding: 10px 30px; color: #fff;">	
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</section>
<div class="copy">
        <p>© 2026 Sun of Beach Resort . All Rights Reserved | Design by Team</p>
    </div>

<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
</body>
</html>