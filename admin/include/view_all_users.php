<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM login";
        $select_users=mysqli_query($con, $query);
        while($row=mysqli_fetch_assoc($select_users)){
            $user_id=$row['id'];
            $username=$row['username'];
            $user_firstname=$row['user_firstname'];
            $user_lastname=$row['user_lastname'];
            $user_email=$row['user_email'];
            $user_image=$row['user_image'];
            echo "<tr><td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td><img width='100' src='../images/{$user_image}' alt='image'></td>";
            echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
if(isset($_GET['delete'])){
    $delete_user_id=$_GET['delete'];
    $query="DELETE FROM login WHERE id={$delete_user_id}";
    $delete_query=mysqli_query($con, $query);
    header("Location: users.php");
}
?>