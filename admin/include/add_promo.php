<?php

if(isset($_POST['publish_offer'])) {

    $offer_title = mysqli_real_escape_string(
        $con,
        $_POST['offer_title']
    );

    $promo_code = mysqli_real_escape_string(
        $con,
        $_POST['promo_code']
    );

    // FIXED
   $room_id = ($_POST['room_id'] == 'global')
    ? "NULL"
    : intval($_POST['room_id']);

    $percentage = mysqli_real_escape_string(
        $con,
        $_POST['percentage']
    );

    $status = mysqli_real_escape_string(
        $con,
        $_POST['status']
    );

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
    $poster_image = $_FILES['image']['name'];

    $poster_image_temp =
        $_FILES['image']['tmp_name'];

    if(!empty($poster_image)) {

        move_uploaded_file(
            $poster_image_temp,
            "../images/$poster_image"
        );

    } else {

        $poster_image = "";
    }

    // INSERT
   $query =
"INSERT INTO promotions (

    room_id,
    start_time,
    end_time,
    percentage,
    title,
    promo_code,
    status,
    image_path,
    description

) VALUES (

    {$room_id},
    '{$start_time}',
    '{$end_time}',
    '{$percentage}',
    '{$offer_title}',
    '{$promo_code}',
    '{$status}',
    '{$poster_image}',
    '{$offer_desc}'

)";

    $create_offer_query =
        mysqli_query($con, $query);

    if(!$create_offer_query) {

        die("QUERY FAILED: "
            . mysqli_error($con));

    } else {

        echo "
        <div class='alert alert-success'>

            Offer Published Successfully!

        </div>";
    }
}

?>

<div class="row" style="margin-bottom:20px;">

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
                       name="promo_code">

            </div>

        </div>

    </div>

    <div class="form-group">

        <label>
            Room
        </label>

        <select name="room_id"
                class="form-control">

            <option value="global">
    Global Promotion
</option>

            <?php

            $room_query =
                "SELECT room_id, room_no FROM rooms";

            $select_rooms =
                mysqli_query($con, $room_query);

            if($select_rooms) {

                while($row =
                    mysqli_fetch_assoc(
                        $select_rooms
                    )) {

                    echo "
                    <option value='{$row['room_id']}'>

                        Room Number:
                        {$row['room_no']}

                    </option>";
                }
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

                    <option value="1">

                        Active

                    </option>

                    <option value="0">

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
                       required>

            </div>

        </div>

    </div>

    <div class="form-group">

        <label>
            Image
        </label>

        <input type="file" name="image">

    </div>

    <div class="form-group">

        <label>
            Description
        </label>

        <textarea class="form-control"
                  name="offer_desc"
                  rows="6"></textarea>

    </div>

    <div class="form-group">

        <input class="btn btn-primary"
               type="submit"
               name="publish_offer"
               value="Publish Offer">

    </div>

</form>