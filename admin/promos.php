<?php include "include/admin_header.php"; ?>

<div id="wrapper">

    <?php include "include/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Promotions Management CRUD</small>
                    </h1>

                    <?php

                    if(isset($_GET['source'])){
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }

                    // DELETE PROMOTION
                    if (isset($_GET['delete'])) {

                        $delete_id = mysqli_real_escape_string($con, $_GET['delete']);

                        // DELETE IMAGE
                        $img_select = mysqli_query($con,
                            "SELECT image_path FROM promotions WHERE id = {$delete_id}");

                        if($img_row = mysqli_fetch_assoc($img_select)) {

                            $old_image = $img_row['image_path'];

                            if(!empty($old_image)
                                && file_exists("../images/$old_image")) {

                                unlink("../images/$old_image");
                            }
                        }

                        // DELETE RECORD
                        $query = "DELETE FROM promotions WHERE id = {$delete_id}";

                        $delete_query = mysqli_query($con, $query);

                        if($delete_query) {

                            echo "<div class='alert alert-success'>
                                    Promotion deleted successfully!
                                  </div>";

                            echo "<meta http-equiv='refresh'
                                   content='1;url=promos.php'>";

                        } else {

                            die("Query Failed: " . mysqli_error($con));
                        }
                    }

                    switch($source) {

                        // ==========================
                        // ADD PROMOTION
                        // ==========================
                        case 'add_promo':

                            include "include/add_promo.php";

                            break;

                        // ==========================
                        // EDIT PROMOTION
                        // ==========================
                       case 'edit_promo':
    include "include/edit_promo.php"; // Update the path here
    break;
        

                            if (isset($_GET['p_id'])) {

                                $edit_id = mysqli_real_escape_string(
                                    $con,
                                    $_GET['p_id']
                                );

                                $query = "SELECT * FROM promotions";
$select_promos = mysqli_query($con, $query);

// This is where you need to check
if(mysqli_num_rows($select_promos) > 0) {
    // Loop to display table rows
    while($row = mysqli_fetch_assoc($select_promos)) {
        // ... (display logic)
    }
} else {
    // THIS IS LIKELY WHERE IT IS FALLING INTO
    echo "<tr><td colspan='8' class='text-center'>No promotions found.</td></tr>";
}
                            }

                            // UPDATE PROMOTION
                            if (isset($_POST['update_promo'])) {

                                $offer_title = mysqli_real_escape_string(
                                    $con,
                                    $_POST['offer_title']
                                );

                                $promo_code = mysqli_real_escape_string(
                                    $con,
                                    $_POST['promo_code']
                                );

                                $room_id = ($_POST['room_id'] == 'global')
    ? "NULL"
    : intval($_POST['room_id']);

                                $percentage = mysqli_real_escape_string(
                                    $con,
                                    $_POST['percentage']
                                );

                                $status = intval($_POST['status']);

                                $start_time = mysqli_real_escape_string(
                                    $con,
                                    $_POST['start_time']
                                );

                                $end_time = mysqli_real_escape_string(
                                    $con,
                                    $_POST['end_time']
                                );

                                $offer_desc = mysqli_real_escape_string(
                                    $con,
                                    $_POST['offer_desc']
                                );

                                // VALIDATE ROOM ID
                                if($room_id !== "NULL"){

                                    $check_room = mysqli_query(
                                        $con,
                                        "SELECT room_id
                                         FROM rooms
                                         WHERE room_id = '{$room_id}'"
                                    );

                                    if(mysqli_num_rows($check_room) == 0){

                                        die("<div class='alert alert-danger'>
                                                Invalid Room Selected.
                                             </div>");
                                    }
                                }

                                // IMAGE
                                $promo_image =
                                    $_FILES['image']['name'];

                                $promo_image_temp =
                                    $_FILES['image']['tmp_name'];

                                if (!empty($promo_image)) {

                                    move_uploaded_file(
                                        $promo_image_temp,
                                        "../images/$promo_image"
                                    );

                                    $image_sql =
                                        ", image_path = '{$promo_image}'";

                                } else {

                                    $image_sql = "";
                                }

                                $update_query =
                                    "UPDATE promotions SET

                                        room_id = {$room_id},
                                        start_time = '{$start_time}',
                                        end_time = '{$end_time}',
                                        percentage = '{$percentage}',
                                        title = '{$offer_title}',
                                        promo_code = '{$promo_code}',
                                        status = '{$status}',
                                        description = '{$offer_desc}'

                                        {$image_sql}

                                     WHERE id = {$edit_id}";

                                $run_update = mysqli_query(
                                    $con,
                                    $update_query
                                );

                                if (!$run_update) {

                                    die("Update Query Failed: "
                                        . mysqli_error($con));
                                }

                                echo "<div class='alert alert-success'>
                                        Promotion updated successfully!
                                      </div>";

                                // REFRESH DATA
                                $get_promo = mysqli_query(
                                    $con,
                                    "SELECT * FROM promotions
                                     WHERE id = {$edit_id}"
                                );

                                $promo_row =
                                    mysqli_fetch_assoc($get_promo);
                            }

                            ?>

                            <div class="row"
                                 style="margin-bottom:20px;">

                                <div class="col-md-12">

                                    <a href="promos.php"
                                       class="btn btn-default">

                                        Back

                                    </a>

                                </div>

                            </div>

                            <form action=""
                                  method="post"
                                  enctype="multipart/form-data">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Offer Title
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="offer_title"
                                                   value="<?php echo htmlspecialchars($promo_row['title']); ?>"
                                                   required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Promo Code
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="promo_code"
                                                   value="<?php echo htmlspecialchars($promo_row['promo_code']); ?>">

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>
                                        Room
                                    </label>

                                    <select name="room_id"
                                            class="form-control">

                                        <option value="0"
                                        <?php echo is_null($promo_row['room_id'])
                                            ? 'selected' : ''; ?>>

                                            Global Promotion

                                        </option>

                                        <?php

                                        $room_query =
                                            "SELECT room_id, room_no
                                             FROM rooms";

                                        $select_rooms =
                                            mysqli_query(
                                                $con,
                                                $room_query
                                            );

                                        while($room_row =
                                            mysqli_fetch_assoc(
                                                $select_rooms
                                            )) {

                                            $r_id =
                                                $room_row['room_id'];

                                            $r_name =
                                                $room_row['room_no'];

                                            $selected =
                                                ($promo_row['room_id']
                                                == $r_id)
                                                ? 'selected'
                                                : '';

                                            echo "
                                            <option value='{$r_id}'
                                                    {$selected}>

                                                Room Number: {$r_name}

                                            </option>";
                                        }

                                        ?>

                                    </select>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Discount %
                                            </label>

                                            <input type="number"
                                                   step="0.01"
                                                   class="form-control"
                                                   name="percentage"
                                                   value="<?php echo htmlspecialchars($promo_row['percentage']); ?>"
                                                   required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Status
                                            </label>

                                            <select name="status"
                                                    class="form-control">

                                                <option value="1"
                                                <?php echo ($promo_row['status']==1)
                                                    ? 'selected'
                                                    : ''; ?>>

                                                    Active

                                                </option>

                                                <option value="0"
                                                <?php echo ($promo_row['status']==0)
                                                    ? 'selected'
                                                    : ''; ?>>

                                                    Draft

                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Start Time
                                            </label>

                                            <input type="datetime-local"
                                                   class="form-control"
                                                   name="start_time"
                                                   value="<?php echo date('Y-m-d\TH:i', strtotime($promo_row['start_time'])); ?>"
                                                   required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                End Time
                                            </label>

                                            <input type="datetime-local"
                                                   class="form-control"
                                                   name="end_time"
                                                   value="<?php echo date('Y-m-d\TH:i', strtotime($promo_row['end_time'])); ?>"
                                                   required>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>
                                        Image
                                    </label>

                                    <br>

                                    <?php if(!empty($promo_row['image_path'])): ?>

                                        <img src="../images/<?php echo $promo_row['image_path']; ?>"
                                             width="150"
                                             style="margin-bottom:10px;">

                                    <?php endif; ?>

                                    <input type="file" name="image">

                                </div>

                                <div class="form-group">

                                    <label>
                                        Description
                                    </label>

                                    <textarea class="form-control"
                                              name="offer_desc"
                                              rows="6"><?php echo htmlspecialchars($promo_row['description']); ?></textarea>

                                </div>

                                <div class="form-group">

                                    <button type="submit"
                                            name="update_promo"
                                            class="btn btn-info">

                                        Update Promotion

                                    </button>

                                </div>

                            </form>

                            <?php

                            break;

                        // ==========================
                        // MAIN TABLE
                        // ==========================
                        default:

                            ?>

                            <div class="table-responsive">

                                <div class="text-right"
                                     style="margin-bottom:15px;">

                                    <a href="promos.php?source=add_promo"
                                       class="btn btn-primary">

                                        Create Promotion

                                    </a>

                                </div>

                                <table class="table table-bordered table-hover">

                                    <thead>

                                        <tr>

                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Room</th>
                                            <th>Discount</th>
                                            <th>Period</th>
                                            <th>Status</th>
                                            <th>Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        $query =
                                            "SELECT * FROM promotions
                                             ORDER BY id DESC";

                                        $select_promos =
                                            mysqli_query($con, $query);

                                        if(mysqli_num_rows(
                                            $select_promos
                                        ) > 0) {

                                            while ($row =
                                                mysqli_fetch_assoc(
                                                    $select_promos
                                                )) {

                                                $id = $row['id'];

                                                echo "<tr>";

                                                echo "<td>{$id}</td>";

                                                echo "<td>";

                                                if(!empty($row['image_path'])){

                                                    echo "
                                                    <img width='90'
                                                         src='../images/{$row['image_path']}'>";
                                                }

                                                echo "</td>";

                                                echo "
                                                <td>
                                                    <strong>
                                                        {$row['title']}
                                                    </strong>
                                                    <br>
                                                    {$row['promo_code']}
                                                </td>";

                                                echo "
                                                <td>
                                                    {$row['room_id']}
                                                </td>";

                                                echo "
                                                <td>
                                                    {$row['percentage']}%
                                                </td>";

                                                echo "
                                                <td>
                                                    {$row['start_time']}
                                                    <br>
                                                    {$row['end_time']}
                                                </td>";

                                                echo "
                                                <td>";

                                                if($row['status'] == 1){

                                                    echo "
                                                    <span class='label label-success'>
                                                        Active
                                                    </span>";

                                                } else {

                                                    echo "
                                                    <span class='label label-default'>
                                                        Draft
                                                    </span>";
                                                }

                                                echo "</td>";

                                                echo "
                                                <td>

                                                    <a href='promos.php?source=edit_promo&id={$id}'
                                                       class='btn btn-xs btn-info'>

                                                       Edit</a>

                                                    <a href='promos.php?delete={$id}'
                                                       class='btn btn-xs btn-danger'
                                                       onclick=\"return confirm('Delete this promotion?');\">

                                                       Delete

                                                    </a>

                                                </td>";

                                                echo "</tr>";
                                            }

                                        } else {

                                            echo "
                                            <tr>

                                                <td colspan='8'
                                                    class='text-center'>

                                                    No promotions found.

                                                </td>

                                            </tr>";
                                        }

                                        ?>

                                    </tbody>

                                </table>

                            </div>

                            <?php

                            break;
                    }

                    ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "include/admin_footer.php"; ?>