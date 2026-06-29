<?php
include "db.php";

// 1. Initialize variables to prevent "Undefined" errors
$warning = null;
$cust_exists = false;
$room_id = "";
$total_amt = 0;
$the_cust_id = 0;

// PROMO VARIABLES
$promo_message = "";
$discount_amount = 0;
$final_total = 0;
$promo_code_used = "";

// 2. Helper function
function confirm($result){
    global $con;
    if(!$result){
        die("Query failed: " . mysqli_error($con));
    }
}

// 3. Get URL Parameters
$the_room_category = isset($_GET['u']) ? mysqli_real_escape_string($con, $_GET['u']) : 'simple';
$check_in = isset($_GET['cin']) ? mysqli_real_escape_string($con, $_GET['cin']) : date('Y-m-d');
$check_out = isset($_GET['cout']) ? mysqli_real_escape_string($con, $_GET['cout']) : date('Y-m-d', strtotime('+1 day'));
$branch_id = isset($_GET['branch']) ? mysqli_real_escape_string($con, $_GET['branch']) : '1';

// 4. Find an available room
$query = "SELECT r.room_id FROM rooms r 
          WHERE r.branch_id = '$branch_id' 
          AND r.room_id NOT IN (
              SELECT f.room_id FROM forr f 
              WHERE ('$check_in' < f.check_out_date AND '$check_out' > f.check_in_date)
          ) LIMIT 1";

$select_room = mysqli_query($con, $query);

if($row = mysqli_fetch_assoc($select_room)){
    $room_id = $row['room_id'];
}

// 5. Calculate Total Amount
$rates = [
    "simple" => 50,
    "deluxe" => 100,
    "suite" => 150
];

$base_price = isset($rates[$the_room_category]) ? $rates[$the_room_category] : 50;

$days = max(1, ceil((strtotime($check_out) - strtotime($check_in)) / 86400));

$total_amt = $base_price * $days;

$final_total = $total_amt;

// 6. Form Submission Logic
if(isset($_POST['add_booking'])){

    $f_name = mysqli_real_escape_string($con, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($con, $_POST['l_name']);
    $cust_email = mysqli_real_escape_string($con, $_POST['cust_email']);
    $cust_phone = mysqli_real_escape_string($con, $_POST['cust_phone']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $passport_no = mysqli_real_escape_string($con, $_POST['passport_no']);
    $payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);

    // ================= PROMO CODE LOGIC =================
    $final_total = $total_amt;
    // DIBAIKI: Menggunakan $_POST['user_promo'] supaya sepadan dengan nama input HTML di bawah
    if(!empty($_POST['user_promo'])){

        $promo_code_used = mysqli_real_escape_string($con, $_POST['user_promo']);

        $promo_query = "
            SELECT * FROM promotions
            WHERE promo_code = '$promo_code_used'
            AND status = 1
            AND start_time <= NOW()
            AND end_time >= NOW()
            LIMIT 1
        ";

        $promo_result = mysqli_query($con, $promo_query);

        if(mysqli_num_rows($promo_result) > 0){

            $promo_row = mysqli_fetch_assoc($promo_result);

            $discount_percentage = $promo_row['percentage'];

            $discount_amount = ($total_amt * $discount_percentage) / 100;

            $final_total = $total_amt - $discount_amount;

            $promo_message = "Promo code applied successfully!";
        }
         else {

            $promo_message = "Invalid or expired promo code.";
        }
    }

    // Check if room was actually found
    if(empty($room_id)) {
        $warning = "No rooms available for the selected dates.";
    }

    // Check if customer exists
    $check_cust = "SELECT cust_id FROM customer 
                   WHERE passport_no = '$passport_no' 
                   OR cust_email = '$cust_email' 
                   LIMIT 1";

    $res_cust = mysqli_query($con, $check_cust);

    if(mysqli_num_rows($res_cust) > 0) {

        $row = mysqli_fetch_assoc($res_cust);

        $the_cust_id = $row['cust_id'];

        $cust_exists = true;
    }

    if(!$warning) {

        // Create Customer if new
        if(!$cust_exists) {

            $query = "INSERT INTO customer(
                        cust_email,
                        cust_phone,
                        passport_no,
                        country,
                        dob,
                        f_name,
                        l_name
                    ) VALUES(
                        '$cust_email',
                        '$cust_phone',
                        '$passport_no',
                        '$country',
                        '$dob',
                        '$f_name',
                        '$l_name'
                    )";

            $create_cust = mysqli_query($con, $query);

            confirm($create_cust);

            $the_cust_id = mysqli_insert_id($con);
        }

        // Handle Dependent
        if(!empty($_POST['dep_name'])) {

            $dep_name = mysqli_real_escape_string($con, $_POST['dep_name']);
            $dep_pass = mysqli_real_escape_string($con, $_POST['dep_id']);

            $query = "INSERT INTO dependents(
                        cust_id,
                        dep_name,
                        passport_no
                    ) VALUES(
                        '$the_cust_id',
                        '$dep_name',
                        '$dep_pass'
                    )";

            mysqli_query($con, $query);
        }

        // Create Booking and Bill
        $booking_id = rand(10000, 99999);
        $bill_id = rand(100000, 999999);
        $booking_date = date('Y-m-d H:i:s');

        // DIBAIKI: Menyusun semula tanda koma dan petik pembuka SQL yang hilang
        $insert_booking_query = mysqli_query($con, "
            INSERT INTO booking(
                cust_id,
                Booking_id,
                room_id,
                branch_id,
                promo_code
            ) VALUES(
                '$the_cust_id',
                '$booking_id',
                '$room_id',
                '$branch_id',
                '$promo_code_used'
            )
        ");
        confirm($insert_booking_query); // Memastikan ralat SQL ditangkap sekiranya gagal

        $insert_bill_query = mysqli_query($con, "
            INSERT INTO bill(
                cust_id,
                Bill_id,
                Amount,
                Payment_type
            ) VALUES(
                '$the_cust_id',
                '$bill_id',
                '$final_total',
                '$payment_type'
            )
        ");
        confirm($insert_bill_query);

        $insert_forr_query = mysqli_query($con, "
            INSERT INTO forr(
                Booking_id,
                room_id,
                check_in_date,
                check_out_date
            ) VALUES(
                '$booking_id',
                '$room_id',
                '$check_in',
                '$check_out'
            )
        ");
        confirm($insert_forr_query);

        $insert_generates_query = mysqli_query($con, "
            INSERT INTO generates(
                Booking_id,
                Bill_id,
                booking_date
            ) VALUES(
                '$booking_id',
                '$bill_id',
                '$booking_date'
            )
        ");
        confirm($insert_generates_query);

        header("Location: confirmation.php?u=$booking_id&cat=$the_room_category");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking | Hotel Management</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css" />

    <style>
        .section {
            min-height: 100vh;
            background: url('./images/background2.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 50px 0;
        }

        .booking-form {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            color: white;
            position: relative;
        }

        .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid #444;
            color: #fff;
            height: 50px;
            margin-bottom: 15px;
            border-radius: 25px;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.2);
            color: #fff;
            box-shadow: 0 0 10px #ff8846;
        }

        .submit-btn {
            background: #e35e0a;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
        }

        #depText {
            color: #ff8846;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }

        .error-msg {
            color: #ff4d4d;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        #removeBtn {
            background: #ff4d4d;
            border: none;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<?php include "include/navigation.php" ?>

<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="booking-form">

                    <div class="text-center mb-4">
                        <h1>Make Your Reservation</h1>
                        <p>
                            Category: <?php echo ucfirst($the_room_category); ?> | Branch: <?php echo $branch_id; ?>
                        </p>
                    </div>

                    <?php if($warning): ?>
                        <div class="error-msg">
                            <?php echo $warning; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post" id="confirm_form">

                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="First Name" name="f_name" required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Last Name" name="l_name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="small text-muted ml-3">Date of Birth</label>
                                <input class="form-control" type="date" name="dob" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted ml-3">&nbsp;</label>
                                <input class="form-control" type="text" placeholder="Country" name="country" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="email" placeholder="Email Address" name="cust_email" required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Passport Number" name="passport_no" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Phone (10 digits)" name="cust_phone" minlength="10" maxlength="10" required>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="payment_type" required>
                                    <option value="" disabled selected>Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Net Banking">Net Banking</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Promo Code</label>
                            <input type="text" name="user_promo" class="form-control" placeholder="Enter promo code">
                        </div>

                        <?php if(!empty($promo_message)): ?>
                            <div class="text-center mb-3" style="color:#ff8846; font-weight:bold;">
                                <?php echo $promo_message; ?>
                            </div>
                        <?php endif; ?>

                        <div id="dependent_section"></div>

                        <div onclick="addDep()" id="depText">
                            Add Dependent +
                        </div>

                        <div class="mt-3">
                            <input type="submit" class="submit-btn" name="add_booking" value="Confirm Booking">
                        </div>

                        <h3 class="text-center mt-4">
                            Total: RM <?php echo number_format($final_total, 2); ?>
                        </h3>

                        <?php if($discount_amount > 0): ?>
                            <div class="text-center text-success">
                                Discount Applied: RM <?php echo number_format($discount_amount, 2); ?>
                            </div>
                        <?php endif; ?>

                        <div class="text-center small text-muted" id="countdown">
                            Session expires in 05:00
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Timer Logic
    var seconds = 300;
    function secondPassed() {
        var minutes = Math.floor(seconds / 60);
        var remSeconds = seconds % 60;

        if (remSeconds < 10) remSeconds = "0" + remSeconds;

        document.getElementById('countdown').innerHTML = "Session expires in " + minutes + ":" + remSeconds;

        if (seconds == 0) {
            window.location = "search.php";
        } else {
            seconds--;
        }
    }
    setInterval(secondPassed, 1000);

    // Dynamic Dependent Logic
    function addDep() {
        var section = document.getElementById("dependent_section");
        section.innerHTML = `
            <div class="row" id="dep_row">
                <div class="col-md-5">
                    <input class="form-control" type="text" name="dep_name" placeholder="Dependent Name" required>
                </div>
                <div class="col-md-5">
                    <input class="form-control" type="text" name="dep_id" placeholder="Passport Number" required>
                </div>
                <div class="col-md-2">
                    <button type="button" id="removeBtn" onclick="removeDep()">×</button>
                </div>
            </div>
        `;
        document.getElementById("depText").style.display = "none";
    }

    function removeDep() {
        document.getElementById("dependent_section").innerHTML = "";
        document.getElementById("depText").style.display = "block";
    }
</script>

</body>
</html>