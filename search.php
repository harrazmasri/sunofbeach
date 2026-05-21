<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/bdd89edb33.js"></script>
    <link
      href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900"
      rel="stylesheet"
    />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="Search.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="icon" href="images/icon.jpg">
    <title>Search</title>

</head>
<body>
  <?php include "include/navigation.php" ?>

  <?php 

  $room_category=['simple','deluxe','suite'];
  $category_count=[];

  for($i=0; $i<3; $i++){
    $query="SELECT * FROM $room_category[$i]";
    $select_all_rooms=mysqli_query($con, $query);
    if (!$select_all_rooms || mysqli_num_rows($select_all_rooms) == 0){
      $category_count[$i]=0;
    }
    else {
      $category_count[$i]=mysqli_num_rows($select_all_rooms);
    }
  }

  if(isset($_POST['search'])){
    $branch_id=$_POST['branch_id'];
    $check_in=$_POST['check_in'];
    $check_out=$_POST['check_out'];

    for($i=0; $i<3; $i++){
      $query="SELECT $room_category[$i].room_id FROM $room_category[$i] JOIN rooms ON $room_category[$i].room_id=rooms.room_id WHERE (rooms.branch_id='{$branch_id}' AND $room_category[$i].room_id NOT IN (SELECT forr.room_id FROM $room_category[$i] JOIN forr ON $room_category[$i].room_id=forr.room_id WHERE (('{$check_in}' BETWEEN forr.check_in_date AND forr.check_out_date) OR ('{$check_out}' BETWEEN forr.check_in_date AND forr.check_out_date))))";
      $select_all_rooms=mysqli_query($con, $query);

      if (!$select_all_rooms || mysqli_num_rows($select_all_rooms) == 0){
        $category_count[$i]=0;
      }
      else {
        $category_count[$i]=mysqli_num_rows($select_all_rooms);
      }
    }
  }
?>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
  <div class="SearchContainer">
    <form action="" method="post" enctype="multipart/form-data">
      <br><br><br>
      <div class="FormDiv">
          <h1>Search for Rooms</h1>
          <br>
          <div>
            <label>Location  </label>
            <select id="country" name="branch_id" required>
                <option value="">Select</option>
                <option value="1">Kolumpo</option>
                <option value="2">Bangi</option>
                <option value="3">Setapak</option>
                <option value="4">Pasir Mas</option>
                <option value="5">Putrajaya</option>
            </select>
            <label>   Check In Date    </label>
            <input type="date" id="check_in" name="check_in" min='<?php echo date('Y-m-d');?>' required>
            <label>   Check Out Date   </label>
            <input type="date" id="check_out" name="check_out" min='<?php echo date('Y-m-d');?>' onchange="check()" required>
            <input type="submit" name="search" class="btn-submit" onclick="submitbutton()" placeholder="SUBMIT">
          </div>
      </div>
    </form>
  </div>
  </div>
</div>  
<section class="section-plans" id="section-plans">  
  <div class="row" id="row">
    <div class="">
      <div class="card">
        <div class="card__side card__side--front-1">
          <div class="card__title card__title--1">
            <div class="Room_Container">
              <div class="Room_Image Room_Column Room_1">
              </div> 
              <div class="Room_Column"> 
                 <p><i class="fas fa-coffee"></i>Breakfast</p>
                 <p><i class="fas fa-concierge-bell"></i>Room Service</p>
                 <p><i class="fas fa-wifi"></i>WiFi</p>
                 <p><i class="fas fa-tshirt"></i>Laundry</p>
              </div>
              <div class="Room_Column">
                <h4>Simple</h4> <br> <br>
                <h4><?php echo $category_count[0] ?> Rooms Available</h4>
              </div>  
            </div>
          </div>
        </div>
        <div class="card__side card__side--back card__side--back-1">
          <div class="card__cta">
            <div class="card__price-box">
              <p class="card__price-value">RM 50/day</p>
            </div>
            <?php
            if($category_count[0]!=0 && isset($_POST['search'])){
              echo "<a class='btn btn--white' href='booking.php?u=simple&cin={$check_in}&cout={$check_out}&branch={$branch_id}'>Book</a>";
            } 
            ?>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="">
      <div class="card">
        <div class="card__side card__side--front-2">
          <div class="card__title card__title--2">
          <div class="Room_Container">
            <div class="Room_Image Room_Column Room_2">
            </div> 
            <div class="Room_Column"> 
               <p><i class="fas fa-star"></i>Perks of Simple Included</p>
               <p><i class="fas fa-water"></i>Balcony</p>
               <p><i class="fas fa-spa"></i>Access to SPA </p>
               <p><i class="fas fa-dumbbell"></i>Access to Gymnasium</p>
            </div>
            <div class="Room_Column">
              <h4>Deluxe</h4> <br> <br>
              <h4><?php echo $category_count[1] ?> Rooms Available</h4>
            </div>  
            </div>
          </div>
        </div>
        <div class="card__side card__side--back card__side--back-2">
          <div class="card__cta">
            <div class="card__price-box">
              <p class="card__price-value">RM 100/day</p>
            </div>
            <?php
            if($category_count[1]!=0 && isset($_POST['search'])){
              echo "<a class='btn btn--white' href='booking.php?u=deluxe&cin={$check_in}&cout={$check_out}&branch={$branch_id}'>Book</a>";
            } 
            ?>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="">
      <div class="card">
        <div class="card__side card__side--front-3">
          <div class="card__title card__title--3">
          <div class="Room_Container">
            <div class="Room_Image Room_Column Room_3">
            </div> 
            <div class="Room_Column"> 
               <p><i class="fas fa-star"></i>Perks of Deluxe Included</p>
               <p><i class="fas fa-walking"></i>Walk In Closet</p>
               <p><i class="fas fa-hot-tub"></i>Jacuzzi </p>
               <p><i class="fas fa-taxi"></i>Transfers</p>
            </div>
            <div class="Room_Column">
              <h4>Suite</h4> <br> <br>
              <h4><?php echo $category_count[2] ?> Rooms Available</h4>
            </div>  
            </div>
          </div>
        </div>
        <div class="card__side card__side--back card__side--back-3">
          <div class="card__cta">
            <div class="card__price-box">  
              <p class="card__price-value">RM 150/day</p>
            </div>
            <?php
            if($category_count[2]!=0 && isset($_POST['search'])){
              echo "<a class='btn btn--white' href='booking.php?u=suite&cin={$check_in}&cout={$check_out}&branch={$branch_id}'>Book</a>";
            }   
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include "include/footer.php" ?>

       <!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript">
  function check() {
    if(document.getElementById('check_in').value >= document.getElementById('check_out').value) {
      alert('Check out must be after check in!')
      document.getElementById('check_out').value= document.getElementById('check_in').value;
    }
  }

  function submitbutton() {
    setTimeout(() => {
    console.log("SUBMIT")
    document.getElementById('row').class('block')
    }, 2000);
  }
</script>
</body>
</html>