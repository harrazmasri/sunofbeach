<?php  
 session_start();  
 if(isset($_SESSION["user"]))  
 {  
      header("location:home.php");  
 }  
 
 ?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sun of Beach Admin</title>  
    <link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="css/style.css">

  
</head>

<body style = "background-image: url('https://images.unsplash.com/photo-1537640685236-a9df2496e232?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80');
background-size: cover; z-index:20;
">

 <div class="container">

      <div id="login">

        <form method="post">

          <fieldset class="clearfix">

            <p><span class="fontawesome-user"></span><input type="text"  name="user" value="Username" onBlur="if(this.value == '') this.value = 'Username'" onFocus="if(this.value == 'Username') this.value = ''" required></p>
            <p><span class="fontawesome-lock"></span><input type="password" name="pass"  value="Password" onBlur="if(this.value == '') this.value = 'Password'" onFocus="if(this.value == 'Password') this.value = ''" required></p> 
            <p><input type="submit" name="sub"  value="Login"></p>

          </fieldset>

        </form>

      </div> <!-- end login -->

    </div>
    <a href="../index.php">
    <img style="position:relative; right:-30%; margin-top:5%; width:40%; " src="../images/title.png" alt="Go to Homepage">
    </a>
    
  
  
</body>
</html>

<?php
   include('db.php');
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $myusername = mysqli_real_escape_string($con,$_POST['user']);
      $mypassword = mysqli_real_escape_string($con,$_POST['pass']); 
      
      $sql = "SELECT id FROM login WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      		
      if($count == 1) {
         
         $_SESSION['user'] = $myusername;
         
         header("location: home.php");
      }else {
         echo '<script>alert("Your Login Name or Password is invalid") </script>' ;
      }
   }
?>
