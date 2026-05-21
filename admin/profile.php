<?php include "include/admin_header.php" ?>
<?php 
if(isset($_SESSION['user'])){
    $username=$_SESSION['user'];
    $query="SELECT * FROM login WHERE username='{$username}'";
    $select_user_profile_query=mysqli_query($con, $query);
    while($row=mysqli_fetch_array($select_user_profile_query)){
        $user_id=$row['id'];
        $username=$row['username'];
        $user_image=$row['user_image'];
        $password=$row['password'];
        $user_firstname=$row['user_firstname'];
        $user_lastname=$row['user_lastname'];
        $user_email=$row['user_email'];
    }
}
?>
<?php 

if(isset($_POST['update_user'])){
    $user_firstname=$_POST['user_firstname'];
    $user_lastname=$_POST['user_lastname'];
    $user_email=$_POST['user_email'];
    $user_image=$_FILES['user_image']['name'];
    $user_image_temp=$_FILES['user_image']['tmp_name'];
    $password=$_POST['password'];

    move_uploaded_file($user_image_temp, "../images/$user_image");
    if(empty($user_image)){
        $query="SELECT * FROM login WHERE username='{$username}'";
        $select_image=mysqli_query($con,$query);
        while($row=mysqli_fetch_array($select_image)){
            $user_image=$row['user_image'];
        }
    }
    $query="UPDATE login SET user_firstname ='{$user_firstname}', user_lastname ='{$user_lastname}', user_email ='{$user_email}', password ='{$password}', user_image ='{$user_image}' WHERE username ='{$username}'"; 

    $update_user=mysqli_query($con,$query);
    if(!$update_user){
        die("query failed" . mysqli_error($con));
    }
    header("Location: profile.php");
}
?>
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
                        <form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
    </div>

    <div class="form-group">
        <br><img width='100' src="../images/<?php echo $user_image ?>" ><br>
        <label for="user_image">User Image</label>
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" value="<?php echo $password; ?>" name="password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update Profile">
    </div>
</form>
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
