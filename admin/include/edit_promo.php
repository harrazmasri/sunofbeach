<?php
// 1. Fetch data
if(isset($_GET['id'])) {
    $edit_id = mysqli_real_escape_string($con, $_GET['id']);
    $query = "SELECT * FROM promotions WHERE id = $edit_id";
    $result = mysqli_query($con, $query);
    $promo = mysqli_fetch_assoc($result);
}

// 2. Process the Update
if(isset($_POST['update_promo'])) {
    $id    = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['offer_title']);
    $code  = mysqli_real_escape_string($con, $_POST['promo_code']); // Added promo_code
    $perc  = mysqli_real_escape_string($con, $_POST['percentage']);
    $desc  = mysqli_real_escape_string($con, $_POST['offer_desc']);
    
    // IMAGE HANDLING
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];

    if(!empty($image)) {
        move_uploaded_file($image_temp, "../images/$image");
        // Update with new image
        $update_query = "UPDATE promotions SET title='$title', promo_code='$code', percentage='$perc', description='$desc', image_path='$image' WHERE id=$id";
    } else {
        // Keep existing image
        $update_query = "UPDATE promotions SET title='$title', promo_code='$code', percentage='$perc', description='$desc' WHERE id=$id";
    }
    
    if(mysqli_query($con, $update_query)) {
        echo "<script>alert('Promotion Updated!'); window.location='promos.php';</script>";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $promo['id']; ?>">
    
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="offer_title" class="form-control" value="<?php echo htmlspecialchars($promo['title']); ?>">
    </div>

    <div class="form-group">
        <label>Promo Code</label>
        <input type="text" name="promo_code" class="form-control" value="<?php echo htmlspecialchars($promo['promo_code']); ?>">
    </div>

    <div class="form-group">
        <label>Percentage</label>
        <input type="number" name="percentage" class="form-control" value="<?php echo htmlspecialchars($promo['percentage']); ?>">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="offer_desc" class="form-control"><?php echo htmlspecialchars($promo['description']); ?></textarea>
    </div>

    <div class="form-group">
        <label>Current Image:</label><br>
        <img src="../images/<?php echo $promo['image_path']; ?>" width="100"><br><br>
        <label>Change Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" name="update_promo" class="btn btn-primary">Update Promotion</button>
</form>