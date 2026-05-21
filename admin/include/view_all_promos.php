<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // 1. Corrected query to fetch from the promotions table
        $query = "SELECT * FROM promotions";
        $select_promos = mysqli_query($con, $query);
        
        while($row = mysqli_fetch_assoc($select_promos)){
            /* 
               2. FIX: Array keys MUST match your database column names 
               as shown in image_30db54.png
            */
            $promo_id    = $row['id'];           // database column is 'id'
            $promo_title = $row['title'];        // database column is 'title'
            $promo_desc  = $row['description'];  // database column is 'description'
            $promo_image = $row['image_path'];   // database column is 'image_path'

            echo "<tr>";
            echo "<td>{$promo_id}</td>";
            echo "<td>{$promo_title}</td>";
            echo "<td>{$promo_desc}</td>";
            
            // 3. Display the image from the htdocs/Hotel_Management/images/ folder
            echo "<td><img width='100' src='../images/{$promo_image}' alt='promo image'></td>";
            
            echo "<td><a href='promos.php?source=edit_promo&p_id={$promo_id}'>Edit</a></td>";
            
            // 4. Delete link passes the correct 'id' to the URL
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='promos.php?delete={$promo_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php 
// 5. Logic to delete a promotion
if(isset($_GET['delete'])){
    $delete_promo_id = $_GET['delete'];
    
    // FIX: WHERE clause must use the column 'id'
    $query = "DELETE FROM promotions WHERE id = {$delete_promo_id}";
    $delete_query = mysqli_query($con, $query);
    
    if(!$delete_query) {
        die("DELETE FAILED: " . mysqli_error($con));
    }
    
    // 6. Refresh the page to update the table
    header("Location: promos.php");
}
?>