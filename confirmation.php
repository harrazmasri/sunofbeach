<?php
include "db.php";

// Standard confirmation fallback function
function confirm($result) {
    global $con;
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
}

// -------------------------------------------------------------
// Initialize default fallback values to prevent PHP notices
// -------------------------------------------------------------
$booking_id        = '';
$cust_id           = 0;
$room_id           = 0;
$branch_id         = 0;
$branch_name       = 'N/A';
$the_room_category = 'Unknown';
$amount            = "0";
$check_in          = '';
$check_out         = '';
$days              = 0;
$bill_id           = 0;
$booking_date      = date("Y-m-d H:i:s");
$total_amount      = 0;
$payment           = 'N/A';
$room_no           = 'N/A';
$f_name            = '';
$l_name            = '';
$cust_email        = '';
$cust_phone        = '';
$country           = '';
$dob               = '';
$passport_no       = '';
$dep_name          = null;

// -------------------------------------------------------------
// Secure Data Retrieval using Prepared Statements
// -------------------------------------------------------------
if (isset($_GET['u']) && !empty($_GET['u'])) {
    $booking_id = $_GET['u'];

    // 1. Fetch data from booking table
    $stmt = mysqli_prepare($con, "SELECT cust_id, room_id, branch_id FROM booking WHERE Booking_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $booking_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $cust_id   = $row['cust_id'];
        $room_id   = $row['room_id'];
        $branch_id = $row['branch_id'];
    }
    mysqli_stmt_close($stmt);

    if ($branch_id > 0) {
        // 2. Fetch Hotel Details (Executed only once)
        $stmt = mysqli_prepare($con, "SELECT branch_name FROM hotel WHERE branch_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $branch_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $branch_name = $row['branch_name'];
        }
        mysqli_stmt_close($stmt);

        // 3. Find dynamic Room Category from its sub-tables
        $room_categories = ['simple', 'deluxe', 'suite'];
        foreach ($room_categories as $cat) {
            $query = "SELECT room_id FROM `$cat` WHERE room_id = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "i", $room_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $the_room_category = $cat;
                mysqli_stmt_close($stmt);
                break;
            }
            mysqli_stmt_close($stmt);
        }

        // Dynamically assign baseline rates
        switch ($the_room_category) {
            case "simple": $amount = "50"; break;
            case "deluxe": $amount = "100"; break;
            case "suite":  $amount = "150"; break;
            default:       $amount = "0"; break;
        }

        // 4. Fetch check-in/out window from 'forr' table
        $stmt = mysqli_prepare($con, "SELECT check_in_date, check_out_date FROM forr WHERE Booking_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $check_in  = $row['check_in_date'];
            $check_out = $row['check_out_date'];
            if (!empty($check_in) && !empty($check_out)) {
                $days = ceil((strtotime($check_out) - strtotime($check_in)) / 86400);
            }
        }
        mysqli_stmt_close($stmt);

        // 5. Fetch associated Bill IDs
        $stmt = mysqli_prepare($con, "SELECT Bill_id, booking_date FROM generates WHERE Booking_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $bill_id      = $row['Bill_id'];
            $booking_date = $row['booking_date'];
        }
        mysqli_stmt_close($stmt);

        // 6. Fetch transactional Bill totals
        $stmt = mysqli_prepare($con, "SELECT Amount, Payment_type FROM bill WHERE Bill_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $bill_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $total_amount = $row['Amount'];
            $payment      = $row['Payment_type'];
        }
        mysqli_stmt_close($stmt);

        // 7. Get Room labels
        $stmt = mysqli_prepare($con, "SELECT room_no FROM rooms WHERE room_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $room_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $room_no = $row['room_no'];
        }
        mysqli_stmt_close($stmt);

        // 8. Pull main profile information
        $stmt = mysqli_prepare($con, "SELECT f_name, l_name, cust_email, cust_phone, country, dob, passport_no FROM customer WHERE cust_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $cust_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $f_name      = $row['f_name'];
            $l_name      = $row['l_name'];
            $cust_email  = $row['cust_email'];
            $cust_phone  = $row['cust_phone'];
            $country     = $row['country'];
            $dob         = $row['dob'];
            $passport_no = $row['passport_no'];
        }
        mysqli_stmt_close($stmt);

        // 9. Match Dependents 
        $stmt = mysqli_prepare($con, "SELECT dep_name FROM dependents WHERE cust_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $cust_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $dep_name = $row['dep_name'];
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="license" href="https://www.opensource.org/licenses/mit-license/">
        <link rel="icon" href="images/icon.jpg">
        <script src="script.js"></script>
        <style>
            /* CSS Reset */
            * {
                border: 0;
                box-sizing: content-box;
                color: inherit;
                font-family: inherit;
                font-size: inherit;
                font-style: inherit;
                font-weight: inherit;
                line-height: inherit;
                list-style: none;
                margin: 0;
                padding: 0;
                text-decoration: none;
                vertical-align: top;
            }

            *[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; cursor: pointer; }
            *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { 
                background: #DEF; 
                box-shadow: 0 0 1em 0.5em #DEF; 
            }
            span[contenteditable] { display: inline-block; }

            h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

            /* Structural Layout */
            table { font-size: 75%; table-layout: fixed; width: 100%; border-collapse: separate; border-spacing: 2px; }
            th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; border-radius: 0.25em; border-style: solid; }
            th { background: #EEE; border-color: #BBB; }
            td { border-color: #DDD; }

            html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; background: #999; cursor: default; }
            body { box-sizing: border-box; margin: 0 auto; overflow: hidden; padding: 0.5in; padding-bottom: 0; width: 100%; background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

            header { margin: 0 0 3em; margin-top: 50px; }
            header:after { clear: both; content: ""; display: table; }
            header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
            header address { float: right; font-size: 78%; font-style: normal; line-height: 1.25; margin: 0 0; }
            header address p { margin: 0 0; background: #f57c00; padding: 10px; border-radius: 2px 15px; }
            header span, header img { display: block; float: left; }
            header span { margin: 0 0; max-height: 25%; max-width: 60%; position: relative; }
            header img { max-height: 100%; max-width: 100%; }
            header span img { height: 40px; width: 80px; }

            /* Refactored Native HTML Elements Styles */
            .invoice-title-block h1 { border-color: #f57c00; border-bottom-style: solid; border-width: 3px; padding-bottom: 5px; font-size: 120%; }
            .recipient-block p { text-transform: uppercase; font-size: 90%; font-weight: bold; margin: 8px; }

            article, .deja-container, table.inventory { margin: 5px 0 3em; }
            article:after { clear: both; content: ""; display: table; }
            article h1 { clip: rect(0 0 0 0); position: absolute; }
            article address { float: left; font-size: 125%; font-weight: bold; }
            article address p { text-transform: uppercase; font-size: 80%; }

            table.meta, table.balance { float: right; width: 36%; }
            table.meta:after, table.balance:after { clear: both; content: ""; display: table; }
            
            table.deja { width: 36%; float: left; position: relative; top: 10px; left: 0; border-collapse: collapse; }
            table.deja th, table.deja td { background: #fff; border-color: #fff; border-bottom-color: #e0e0e0; color: #616161; }

            table.meta th, table.meta td { width: 40%; background: #fff; border-color: #fff; border-bottom-color: #e0e0e0; color: #000; }

            table.inventory { clear: both; width: 100%; }
            table.inventory th { font-weight: bold; text-align: center; border-radius: 0; text-transform: uppercase; padding: 10px; }
            table.inventory td { border-color: #fff; border-bottom-color: #e0e0e0; }
            table.inventory th:nth-child(1), table.inventory th:nth-child(2), table.inventory th:nth-child(5) { background: #f57c00; color: #fff; }
            table.inventory th:nth-child(3), table.inventory th:nth-child(4) { background: #000; color: #fff; }

            table.inventory td:nth-child(1) { width: 26%; background: #ffe0b2; }
            table.inventory td:nth-child(2) { width: 38%; background: #ffe0b2; }
            table.inventory td:nth-child(3) { text-align: right; width: 12%; background: #eeeeee; }
            table.inventory td:nth-child(4) { text-align: right; width: 12%; background: #eeeeee; }
            table.inventory td:nth-child(5) { text-align: right; width: 12%; background: #ffe0b2; }

            table.balance th, table.balance td { width: 50%; border-radius: 0; text-transform: uppercase; font-weight: bold; }
            table.balance td { text-align: right; font-weight: normal; }
            table.balance tr:nth-child(1), table.balance tr:nth-child(3) { background: #ffe0b2; }

            aside h1 { border: none; border-bottom: 1px solid #999; margin: 0 0 1em; color: #ffcc80; }

            /* Print Rules */
            @media print {
                * { -webkit-print-color-adjust: exact; }
                html { background: none; padding: 0; }
                body { box-shadow: none; margin: 0; }
                span:empty { display: none; }
            }
            @page { margin: 0; }
        </style>
    </head>
    <body>
        <?php include "include/navigation.php"; ?>
        
        <header>    
            <address>
                <p>Kuala Lumpur, Malaysia<br>016987654321</p>
            </address>
            <span><img alt="Title Logo" src="images/title.png"></span>
        </header>
        
        <div class="invoice-title-block">
            <h1>Invoice</h1>
        </div>
        
        <div class="recipient-block">
            <p><?php echo htmlspecialchars($f_name . " " . $l_name); ?></p>
        </div>
        
        <article>
            <table class="meta">
                <tr>
                    <th><span>Invoice ID</span></th>
                    <td><span><?php echo htmlspecialchars($bill_id); ?></span></td>
                </tr>
                <tr>
                    <th><span>Date</span></th>
                    <td><span><?php echo htmlspecialchars(date("d-m-Y", strtotime(substr($booking_date, 0, 10)))); ?></span></td>
                </tr>
                <tr>
                    <th><span>Booking ID</span></th>
                    <td><span><?php echo htmlspecialchars($booking_id); ?></span></td>
                </tr>   
                <tr>
                    <th><span>Room Number</span></th>
                    <td><span><?php echo htmlspecialchars($room_no); ?></span></td>
                </tr>   
            </table>
            
            <table class="deja">
                <tr>
                    <th><span>Check-in date : </span></th>
                    <td><span><?php echo !empty($check_in) ? htmlspecialchars(date("d-m-Y", strtotime($check_in))) : 'N/A'; ?></span></td>
                </tr>
                <tr>
                    <th><span>Check-out date : </span></th>
                    <td><span><?php echo !empty($check_out) ? htmlspecialchars(date("d-m-Y", strtotime($check_out))) : 'N/A'; ?></span></td>
                </tr>
                <tr>
                    <th><span>Payment method : </span></th>
                    <td><span><?php echo htmlspecialchars($payment); ?></span></td>
                </tr>
                <tr>
                    <th><span>Email : </span></th>
                    <td><span><?php echo htmlspecialchars($cust_email); ?></span></td>
                </tr>
                <tr>
                    <th><span>Phone Number : </span></th>
                    <td><span><?php echo htmlspecialchars($cust_phone); ?></span></td>
                </tr>
                <?php if ($dep_name !== null): ?>
                    <tr>
                        <th><span>Dependent Name: </span></th>
                        <td><span><?php echo htmlspecialchars($dep_name); ?></span></td>
                    </tr>
                <?php endif; ?>
            </table>

            <table class="inventory">
                <thead>
                    <tr>
                        <th><span>Room</span></th>
                        <th><span>Hotel</span></th>
                        <th><span>No of Days</span></th>
                        <th><span>Rate</span></th>
                        <th><span>Price</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span><?php echo htmlspecialchars(ucfirst($the_room_category)); ?></span></td>
                        <td><span><?php echo htmlspecialchars($branch_name); ?></span></td>
                        <td><span><?php echo htmlspecialchars($days); ?></span></td>
                        <td><span>RM <?php echo htmlspecialchars($amount); ?></span></td>
                        <td><span>RM <?php echo htmlspecialchars($total_amount); ?></span></td>
                    </tr>
                </tbody>
            </table>
            
            <table class="balance">
                <tr>
                    <th style="background: #f57c00; color: #fff"><span>Total</span></th>
                    <td><span>RM <?php echo htmlspecialchars($total_amount); ?></span></td>
                </tr>
            </table>
        </article>
        
        <aside>
            <h1><span>thank you for visiting</span></h1>
            <p style="color:#616161; text-align:center; font-size:70%">Email : info@sunofbeach.com || Web : www.sunofbeach.com || Phone : (+91) 22 2224 4555 </p>
        </aside>
        
        <?php include "include/footer.php"; ?>
    </body>
</html>