<?php
include "db.php";
?>

<?php
function confirm($result){
    global $con;
    if(!$result){
        die("Query failed".mysqli_error($con));
    }
}

if(isset($_GET['u'])){
	$booking_id=$_GET['u'];
}

$query= "SELECT * FROM booking WHERE Booking_id='{$booking_id}'";
$select_bookings=mysqli_query($con, $query);
	while($row=mysqli_fetch_assoc($select_bookings)){
	    $cust_id=$row['cust_id'];
	    $room_id=$row['room_id'];
	    $branch_id=$row['branch_id'];
	}

$query= "SELECT * FROM hotel WHERE branch_id='{$branch_id}'";
$select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $branch_name=$row['branch_name'];
    }

$room_category=['simple','deluxe','suite'];

  for($i=0; $i<3; $i++){
    $query="SELECT * FROM $room_category[$i] WHERE room_id='{$room_id}'";
    $select_all_rooms=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_all_rooms)){
        $the_room_category=$room_category[$i];
    }
  }

if($the_room_category=="simple"){
    $amount="50";
}

if($the_room_category=="deluxe"){
    $amount="100";
}

if($the_room_category=="suite"){
    $amount="150";
}

$query= "SELECT * FROM hotel WHERE branch_id='{$branch_id}'";
$select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $branch_name=$row['branch_name'];
    }

$query= "SELECT * FROM forr WHERE Booking_id='{$booking_id}'";
$select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $check_in=$row['check_in_date'];
        $check_out=$row['check_out_date'];
        $days=(ceil((strtotime($check_out)-strtotime($check_in))/86400));
    }

$query= "SELECT * FROM generates WHERE Booking_id='{$booking_id}'";
$select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $bill_id=$row['Bill_id'];
        $booking_date=$row['booking_date'];
    }      

$query= "SELECT * FROM bill WHERE Bill_id='{$bill_id}'";
$select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $total_amount=$row['Amount'];
        $payment=$row['Payment_type'];
    }  

$query= "SELECT * FROM rooms WHERE room_id='{$room_id}'";
$select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $room_no=$row['room_no'];
    }  

$query = "SELECT * FROM customer WHERE cust_id='{$cust_id}'";
    $select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $cust_email=$row['cust_email'];
        $cust_phone=$row['cust_phone'];
        $f_name=$row['f_name'];
        $l_name=$row['l_name'];
        $country=$row['country'];
        $dob=$row['dob'];
		$passport_no=$row['passport_no'];
	}

$query = "SELECT * FROM dependents WHERE cust_id='{$cust_id}'";
    $select_bookings=mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($select_bookings)){
        $dep_name=$row['dep_name'];
	}
?>

<html>
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
		/* reset */
 
*
{
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

/* content editable */

*[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

*[contenteditable] { cursor: pointer; }

*[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

span[contenteditable] { display: inline-block; }

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */

table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #BBB; }
td { border-color: #DDD; }

/* page */

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; margin: 0 auto; overflow: hidden; padding: 0.5in; padding-bottom: 0; width: 100%; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; margin-top: 50px; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: right; font-size: 78%; font-style: normal; line-height: 1.25; margin: 0 0;  }
header address p { margin: 0 0; background: #f57c00; padding:10 ; border-radius: 2px 15px }
header span, header img { display: block; float: left; }
header span { margin: 0 0 ; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%;  }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }
header span img {height: 40; width:80%}
invoice h1 {  border-color: #f57c00; border-bottom-style: solid;  border-width: 3;padding-bottom:5; font-size: 120%;}
rec p {text-transform : uppercase; font-size: 90%;font-weight: bold; margin:8}

/* details */
details, table.deja { margin: 5 0 3em; }
table.deja { float: left; width: 36%; }
table.deja:after { clear: both; content: ""; display: table; }


/* article */

article, article address,article details,table.deja table.meta, table.inventory { margin: 5 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold;   }
article address p {  text-transform : uppercase; font-size: 80%;}

/* table meta & balance */

table.meta, table.balance { float: right; width: 36%; }
table.meta:after, table.balance:after,table.deja:after { clear: both; content: ""; display: table; }
/* table deja */
table.deja{ width: 36%; float:left; position:relative: top:10;left:0; border-collapse :collapse }
table.deja th {background: #fff; border-color: #fff; border-bottom-color: #e0e0e0; color:#616161}
table.deja td {background: #fff; border-color: #fff; border-bottom-color: #e0e0e0; color:#616161}

/* table meta */

table.meta th {width: 40%; background: #fff; border-color: #fff; border-bottom-color: #e0e0e0; color:#000}
table.meta td {width: 40%; background: #fff; border-color: #fff; border-bottom-color: #e0e0e0; color:#000}


/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; border-radius:0; text-transform:uppercase ; padding:10 }
table.inventory td {border-color:#fff; border-bottom-color: #e0e0e0}

table.inventory th:nth-child(1) { background: #f57c00; color: #fff}
table.inventory th:nth-child(2) { background: #f57c00; color: #fff}
table.inventory th:nth-child(5) { background: #f57c00; color: #fff}
table.inventory th:nth-child(3) { background: #000; color: #fff }
table.inventory th:nth-child(4) { background: #000; color: #fff }


table.inventory td:nth-child(1) { width: 26%; background: #ffe0b2;}
table.inventory td:nth-child(2) { width: 38%; background: #ffe0b2;}
table.inventory td:nth-child(3) { text-align: right; width: 12%; background: #eeeeee;}
table.inventory td:nth-child(4) { text-align: right; width: 12%; background: #eeeeee;}
table.inventory td:nth-child(5) { text-align: right; width: 12%; background: #ffe0b2;}

/* table balance */

table.balance th, table.balance td { width: 50%; border-radius:0; text-transform:uppercase; font-weight: bold  }
table.balance td { text-align: right;font-weight: normal  }

table.balance tr:nth-child(1) { background: #ffe0b2; }
table.balance tr:nth-child(3) { background: #ffe0b2; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; color:#ffcc80 }
aside h1 { border-color: #999; border-bottom-style: solid; }

/* javascript */

.add, .cut
{
	border-width: 1px;
	display: block;
	font-size: .8rem;
	padding: 0.25em 0.5em;	
	float: left;
	text-align: center;
	width: 0.6em;
}

.add, .cut
{
	background: #9AF;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
	background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
	border-radius: 0.5em;
	border-color: #0076A3;
	color: #FFF;
	cursor: pointer;
	font-weight: bold;
	text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}

.add { margin: -2.5em 0 0; }

.add:hover { background: #00ADEE; }

.cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut { -webkit-transition: opacity 100ms ease-in; }

tr:hover .cut { opacity: 1; }

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 0; }
		</style>
	</head>
	<body>
		<?php include "include/navigation.php" ?>
		<header>	
			<address >
				<p>Kuala Lumpur, Malaysia
				<br>016987654321</p>
			</address>
			<span><img alt="" src="images/title.png" ></span>
		</header>
		<invoice>
			<h1>Invoice</h1>
		</invoice>
		<rec>
			<p><?php echo $f_name." ".$l_name ?> </p>
		<rec>
		<article>
			<table class="meta">
				<tr>
					<th><span >Invoice ID</span></th>
					<td><span ><?php echo $bill_id; ?></span></td>
				</tr>
				<tr>
					<th><span >Date</span></th>
					<td><span ><?php echo date("d-m-Y", strtotime(substr($booking_date, 0, 10))); ?> </span></td>
				</tr>
				<tr>
					<th><span >Booking ID</span></th>
					<td><span ><?php echo $booking_id; ?> </span></td>
				</tr>	
				<tr>
					<th><span >Room Number</span></th>
					<td><span ><?php echo $room_no; ?> </span></td>
				</tr>	
			</table>
			
			<table class="deja">
			<span></span>
				<tr>
					<th><span>Check-in date : </span></th>
					<td><span ><?php echo date("d-m-Y", strtotime($check_in)); ?></span></td>
				</tr>
				<tr>
					<th><span>Check-out date : </span></th>
					<td><span ><?php echo date("d-m-Y", strtotime($check_out)); ?></span></td>
				</tr>

				<tr>
					<th><span>Payment method : </span></th>
					<td><span ><?php echo $payment; ?></span></td>
				</tr>
				<tr>
					<th><span>Email : </span></th>
					<td><span ><?php echo $cust_email; ?></span></td>
				</tr>
				<tr>
					<th><span>Phone Number : </span></th>
					<td><span ><?php echo $cust_phone; ?></span></td>
				</tr>
				<?php 
				if(isset($dep_name)) {
					echo "<tr>";
					echo "<th><span>Dependent Name: </span></th>";
					echo "<td><span >$dep_name</span></td>";
					echo "</tr>";
				}
				?>
			</table>

			<table class="inventory">
				<thead>
					<tr>
						<th><span >Room</span></th>
						<th><span >Hotel</span></th>
						<th><span >No of Days</span></th>
						<th><span >Rate</span></th>
						<th><span >Price</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span ><?php echo ucfirst($the_room_category); ?></span></td>
						<td><span ><?php echo $branch_name; ?></span></td>
						<td><span ><?php echo $days; ?> </span></td>
						<td><span data-prefix></span><span ><?php  echo "RM {$amount}";?></span></td>
						<td><span data-prefix></span><span><?php echo "RM {$total_amount}"; ?></span></td>
					</tr>
				</tbody>
			</table>
			
			<table class="balance">
				<tr>
					<th style="background: #f57c00; color: #fff"><span >Total</span></th>
					<td><span data-prefix></span><span><?php echo "RM {$total_amount}"; ?></span></td>
				</tr>
			</table>
		</article>
		<aside>
			<h1><span >thank you for visiting</span></h1>
			<p style="color:#616161; text-align:center; font-size:70% ">Email : info@sunofbeach.com || Web : www.sunofbeach.com || Phone : (+91) 22 2224 4555 </p>
		</aside>
		<?php include "include/footer.php" ?>
	</body>
</html>
