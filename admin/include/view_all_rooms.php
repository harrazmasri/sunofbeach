<?php 
// =========================================================================
// BAHAGIAN 1: LOGIK PEMADAMAN & VIEW FEEDBACK
// =========================================================================

// Ambil status paparan tindakan (jika klik View Feedback)
$source = isset($_GET['action']) ? $_GET['action'] : '';

// Logik pemadaman bilik secara bertingkat (Cascade Delete)
if(isset($_GET['delete'])){
    $delete_room_id = mysqli_real_escape_string($con, $_GET['delete']);
    
    // 1. Padam rekod maklum balas berkait bilik ini terlebih dahulu untuk mengelakkan ralat Foreign Key
    $query_delete_feedback = "DELETE FROM booking_feedbacks WHERE room_id = {$delete_room_id}";
    mysqli_query($con, $query_delete_feedback);
    
    // 2. Padam bilik daripada jadual rooms selepas tiada data bergantung padanya
    $query_delete_room = "DELETE FROM rooms WHERE room_id = {$delete_room_id}";
    $delete_room_query = mysqli_query($con, $query_delete_room);
    
    if($delete_room_query) {
        header("Location: rooms.php");
        exit();
    } else {
        die("Gagal memadam bilik daripada jadual rooms: " . mysqli_error($con));
    }
}
?>

<?php
// =========================================================================
// BAHAGIAN 2: PAPARAN JADUAL FEEDBACK DINAMIK (MUNCUL BILA KLIK VIEW FEEDBACK)
// =========================================================================
if($source == 'view_feedback' && isset($_GET['room_id'])): 
    $view_room_id = mysqli_real_escape_string($con, $_GET['room_id']);
    
    // Dapatkan ulasan nombor bilik untuk diletakkan pada tajuk
    $room_info_query = mysqli_query($con, "SELECT room_no FROM rooms WHERE room_id = {$view_room_id}");
    $room_row = mysqli_fetch_assoc($room_info_query);
    $display_room_no = $room_row ? $room_row['room_no'] : '';
?>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-lg-12">
            <div class="well" style="background-color: #fff; border: 1px solid #e35e0a; border-radius: 4px; padding: 20px;">
                <h3 style="color: #e35e0a; margin-top: 0;">
                    Customer Feedbacks for Room: <?php echo htmlspecialchars($display_room_no); ?>
                    <a href="rooms.php" class="btn btn-primary pull-right btn-sm">Back to All Rooms</a>
                </h3>
                <hr>
                
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #f5f5f5;">
                            <th>ID</th>
                            <th>Booking ID</th>
                            <th>Rating</th>
                            <th>Review / Description</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Ambil maklum balas khusus untuk room_id pilihan mengikut struktur jadual booking_feedbacks anda
                        $query_fb = "SELECT * FROM booking_feedbacks WHERE room_id = {$view_room_id} ORDER BY created_at DESC";
                        $select_fb = mysqli_query($con, $query_fb);
                        
                        if(mysqli_num_rows($select_fb) == 0) {
                            echo "<tr><td colspan='5' class='text-center text-muted' style='padding: 20px;'>No feedbacks submitted yet for this room.</td></tr>";
                        } else {
                            while($fb_row = mysqli_fetch_assoc($select_fb)) {
                                $fb_id       = $fb_row['id'];
                                $booking_id  = $fb_row['booking_id'];
                                $rating      = $fb_row['rating'];
                                $description = $fb_row['description'];
                                $created_at  = $fb_row['created_at'];
                                
                                echo "<tr>";
                                echo "<td>{$fb_id}</td>";
                                echo "<td>{$booking_id}</td>";
                                // Paparan ulasan bentuk bintang keemasan secara visual
                                echo "<td><span style='color: #ff9800; font-weight:bold;'>" . str_repeat("★", $rating) . str_repeat("☆", 5-$rating) . "</span></td>";
                                echo "<td>{$description}</td>";
                                echo "<td>" . date('d-M-Y h:i A', strtotime($created_at)) . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>


<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Room ID</th>
            <th>Branch</th>
            <th>Category</th>
            <th>Room Number</th>
            <th>Wifi</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM rooms";
        $select_rooms = mysqli_query($con, $query);
        while($row = mysqli_fetch_assoc($select_rooms)){
            $room_id   = $row['room_id'];
            $branch_id = $row['branch_id'];
            $room_no   = $row['room_no'];
            
            // Ambil nama cawangan hotel
            $query_hotel = "SELECT branch_name FROM hotel WHERE branch_id={$branch_id}";
            $branch = mysqli_query($con, $query_hotel);
            $branch_name = 'N/A';
            if($row_hotel = mysqli_fetch_assoc($branch)){
                $branch_name = $row_hotel['branch_name'];
            }
            
            echo "<tr><td>{$room_id}</td>";
            echo "<td>{$branch_name}</td>";
            
            // Semakan Kategori Bilik secara dinamik
            $category = 'N/A';
            $wifi = 'N/A';

            $query_s = "SELECT * FROM simple WHERE room_id={$room_id}";
            $select_simple = mysqli_query($con, $query_s);
            if($row_s = mysqli_fetch_assoc($select_simple)){
                $category = 'Simple';
                $wifi = $row_s['wifi'];
            }
            
            $query_d = "SELECT * FROM deluxe WHERE room_id={$room_id}";
            $select_deluxe = mysqli_query($con, $query_d);
            if($row_d = mysqli_fetch_assoc($select_deluxe)){
                $category = 'Deluxe';
                $wifi = $row_d['wifi'];
            }
            
            $query_su = "SELECT * FROM suite WHERE room_id={$room_id}";
            $select_suite = mysqli_query($con, $query_su);
            if($row_su = mysqli_fetch_assoc($select_suite)){
                $category = 'Suite';
                $wifi = $row_su['wifi'];
            }
            
            echo "<td>{$category}</td>";
            echo "<td>{$room_no}</td>";
            echo "<td>{$wifi}</td>";
            
            // KELOM TINDAKAN (Menggabungkan View Feedback dan Delete secara kemas)
            echo "<td>";
            echo "<a href='rooms.php?action=view_feedback&room_id={$room_id}' class='btn btn-info btn-xs' style='margin-right: 5px;'><i class='fa fa-eye'></i> View Feedback</a>";
            echo "<a href='rooms.php?delete={$room_id}' class='btn btn-danger btn-xs' onclick='return confirm(\"Adakah anda pasti mahu memadam bilik ini bersama semua ulasan dalam jadual booking_feedbacks?\");'><i class='fa fa-trash'></i> Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>