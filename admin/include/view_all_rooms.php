<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Room ID</th>
            <th>Branch</th>
            <th>Category</th>
            <th>Room Number</th>
            <th>Wifi</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM rooms";
        $select_rooms=mysqli_query($con, $query);
        while($row=mysqli_fetch_assoc($select_rooms)){
            $room_id=$row['room_id'];
            $branch_id=$row['branch_id'];
            $room_no=$row['room_no'];
            
            $query= "SELECT * FROM hotel WHERE branch_id={$branch_id}";
            $branch=mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($branch)){
                $branch_name=$row['branch_name'];
            }
            echo "<tr><td>{$room_id}</td>";
            echo "<td>{$branch_name}</td>";
            $query = "SELECT * FROM simple WHERE room_id={$room_id}";
                $select_category=mysqli_query($con, $query);
                while($row=mysqli_fetch_assoc($select_category)){
                    $category='Simple';
                    $wifi=$row['wifi'];
                }
            $query = "SELECT * FROM deluxe WHERE room_id={$room_id}";
                $select_category=mysqli_query($con, $query);
                while($row=mysqli_fetch_assoc($select_category)){
                    $category='Deluxe';
                    $wifi=$row['wifi'];
                }
            $query = "SELECT * FROM suite WHERE room_id={$room_id}";
                $select_category=mysqli_query($con, $query);
                while($row=mysqli_fetch_assoc($select_category)){
                    $category='Suite';
                    $wifi=$row['wifi'];
                }
            echo "<td>{$category}</td>";
            echo "<td>{$room_no}</td>";
            echo "<td>{$wifi}</td>";
            echo "<td><a href='rooms.php?delete={$room_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php 
if(isset($_GET['delete'])){
    $delete_user_id=$_GET['delete'];
    $query="DELETE FROM rooms WHERE room_id={$delete_user_id}";
    $delete_query=mysqli_query($con, $query);
    header("Location: rooms.php");
}
?>
