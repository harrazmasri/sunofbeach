<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Feedback ID</th>
                <th>Customer Name</th>
                <th>Review Text Snippet</th>
                <th>Rating</th>
                <th>Date Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Query untuk mendapatkan semua data ulasan dari jadual feedback
            $query = "SELECT * FROM feedback ORDER BY feedback_id DESC";
            $select_feedback = mysqli_query($con, $query);
            
            // JIKA SQL QUERY GAGAL (Contoh: Jadual belum dicipta di phpMyAdmin)
            if(!$select_feedback) {
                echo "<tr><td colspan='6' class='text-danger text-center'><strong>Database Error:</strong> " . mysqli_error($con) . "<br><br><small>Sila pastikan table 'feedback' telah dicipta di phpMyAdmin.</small></td></tr>";
            } else {
                // JIKA BERJAYA, SEMAK SAMA ADA DATA WUJUD ATAU TIDAK
                if(mysqli_num_rows($select_feedback) > 0) {
                    while($row = mysqli_fetch_assoc($select_feedback)){
                        $feedback_id    = $row['feedback_id'];
                        $cust_id        = $row['cust_id'];
                        $review_text    = $row['review_text'];
                        $rating         = $row['rating'];
                        $date_submitted = $row['date_submitted'];
                        
                        echo "<tr>";
                        echo "<td>{$feedback_id}</td>";
                        
                        // Dapatkan nama penuh pelanggan (f_name & l_name) dari jadual customer
                        $cust_query = "SELECT f_name, l_name FROM customer WHERE cust_id = {$cust_id}";
                        $customer_result = mysqli_query($con, $cust_query);
                        $f_name = "Unknown";
                        $l_name = "Customer";
                        
                        if($customer_result && $cust_row = mysqli_fetch_assoc($customer_result)){
                            $f_name = $cust_row['f_name'];
                            $l_name = $cust_row['l_name'];
                        }
                        echo "<td>{$f_name} {$l_name}</td>";
                        
                        // Mengehadkan paparan panjang teks ulasan (Maksimum 60 aksara) supaya layout table kemas
                        $short_text = (strlen($review_text) > 60) ? substr($review_text, 0, 60) . "..." : $review_text;
                        echo "<td>" . htmlspecialchars($short_text) . "</td>";
                        
                        // Paparan Rating Bintang / Skala
                        echo "<td><span class='text-warning'><i class='fa fa-star'></i> <strong>{$rating} / 5</strong></span></td>";
                        echo "<td>{$date_submitted}</td>";
                        
                        // Pautan aksi Read Full (Lihat Butiran) & Delete (Padam)
                        echo "<td>
                                <a class='btn btn-xs btn-info' href='feedback.php?source=view_details&f_id={$feedback_id}'><i class='fa fa-eye'></i> Read Full</a>
                                <a class='btn btn-xs btn-danger' href='feedback.php?delete={$feedback_id}' onclick=\"return confirm('Are you sure you want to delete this feedback?');\"><i class='fa fa-trash'></i> Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    // Jika table wujud tetapi tiada rekod data di dalam database
                    echo "<tr><td colspan='6' class='text-center'>No feedback or reviews found.</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>