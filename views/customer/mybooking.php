<?php
include "../../db.php";

$booking_id = $_GET['id'];

$query = "
    SELECT 
        booking.*, 
        customer.*, 
        rooms.*, 
        hotel.*, 
        booking_feedbacks.rating,
        booking_feedbacks.description
    FROM booking
    JOIN customer ON booking.cust_id = customer.cust_id
    JOIN rooms ON booking.room_id = rooms.room_id
    JOIN hotel ON booking.branch_id = hotel.branch_id
    LEFT JOIN booking_feedbacks 
        ON booking.Booking_id = booking_feedbacks.booking_id
    WHERE booking.Booking_id = '{$booking_id}'
";

$booking_data = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($booking_data);



if (isset($_GET['rating']) && isset($_GET['description']) && isset($_GET['id'])) {

    $booking_id = mysqli_real_escape_string($con, $_GET['id']);
    $rating = mysqli_real_escape_string($con, $_GET['rating']);
    $description = mysqli_real_escape_string($con, $_GET['description']);

    $getRoom = mysqli_query($con, "SELECT room_id FROM booking WHERE Booking_id = '$booking_id'");
    $room = mysqli_fetch_assoc($getRoom);
    $room_id = $room['room_id'];

    $query = "
        INSERT INTO booking_feedbacks (booking_id, room_id, rating, description)
        VALUES ('$booking_id', '$room_id', '$rating', '$description')
    ";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>
                alert('Feedback submitted!');
                window.location.href = 'mybooking.php?id=" . $booking_id . "';
            </script>";
    } else {
        echo "<script>
                alert(" . json_encode("Error: " . mysqli_error($con)) . ");
                window.history.back();
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking #<?php echo($booking_id) ?></title>
</head>
<body>
    <div class="relative w-full h-screen overflow-y-scroll pt-[150px] pb-[64px] px-12">
        <div class="w-full flex gap-12">

            <div class="grow flex flex-col">
                <h1 class="mb-7 text-2xl">Booking #<?php echo($booking_id) ?></h1>

                <div class="w-full flex gap-12">
                    <div class="w-32 h-32 rounded-lg bg-gray-200 overflow-clip">
                        <img src="../../images/hotel_room.jpg" class="h-full object-cover" alt="">
                    </div>
    
                    <div class="w-full text-xl flex flex-col gap-5">
                        <div class="w-full flex gap-3 items-center">
                            <div class="w-5/12 flex gap-2 items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4m-8-6v6M2 18h20"/></svg>
                                Room Number
                            </div>
                            <div class="w-7/12">
                                <?php echo($row['room_no']) ?>
                            </div>
                        </div>
                        <div class="w-full flex gap-3 items-center">
                            <div class="w-5/12 flex gap-2 items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M12 10h.01M12 14h.01M12 6h.01M16 10h.01M16 14h.01M16 6h.01M8 10h.01M8 14h.01M8 6h.01M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect width="16" height="20" x="4" y="2" rx="2"/></g></svg>    
                                Branch
                            </div>
                            <div class="w-7/12">
                                <?php echo($row['branch_name']) ?>
                            </div>
                        </div>
                        <div class="w-full flex gap-3 items-center">
                            <div class="w-5/12 flex gap-2 items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></g></svg>
                                Location    
                            </div>
                            <div class="w-7/12">
                                <?php echo($row['location']) ?>
                            </div>
                        </div>
                        <div class="w-full flex gap-3 items-center">
                            <div class="w-5/12 flex gap-2 items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233a14 14 0 0 0 6.392 6.384"/></svg>
                                Contact
                            </div>
                            <div class="w-7/12">
                                <?php echo($row['branch_phone']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                    if ($row['rating']) {
                ?>
                    <div class="w-full mt-12 border border-gray-300 p-8 rounded-lg">
                        <div class="w-full flex gap-5 items-center">
                            <?php
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $row['rating']) {
                                        echo '
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="none" stroke="#fde601" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                        '; 
                                    } else {
                                        echo '
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="none" stroke="#a4a4a4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                        '; 
                                    }
                                }
                            ?>
                        </div>

                        <div class="mt-5 w-full flex gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></g></svg>
                            </div>
                            <div class="w-full">
                                <p class="font-semibold"><?php echo $row['f_name']; ?> <?php echo $row['l_name']; ?></p>
                                <p><?php echo $row['description']; ?></p>
                            </div>
                        </div>
                    </div>

                <?php
                    }
                    else {
                ?>

                    <div class="w-full mt-12 border border-gray-300 p-8 rounded-lg">
                        <form action="">
                            <h3 class="mb-3 text-lg font-semibold">Leave a feedback</h3>
        
                            <input type="text" name="id" value="<?php echo $_GET['id']; ?>" class="hidden" />

                            <p class="mb-1 font-semibold text-gray-500">Rating</p>
                            <div class="flex flex-row-reverse justify-end gap-1">
            
                                <input type="radio" id="star5" name="rating" value="5" class="hidden peer">
                                <label for="star5" class="cursor-pointer text-gray-400 peer-checked:text-yellow-500 peer-hover:text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                </label>
        
                                <input type="radio" id="star4" name="rating" value="4" class="hidden peer">
                                <label for="star4" class="cursor-pointer text-gray-400 peer-checked:text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                </label>
        
                                <input type="radio" id="star3" name="rating" value="3" class="hidden peer">
                                <label for="star3" class="cursor-pointer text-gray-400 peer-checked:text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                </label>
        
                                <input type="radio" id="star2" name="rating" value="2" class="hidden peer">
                                <label for="star2" class="cursor-pointer text-gray-400 peer-checked:text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                </label>
        
                                <input type="radio" id="star1" name="rating" value="1" class="hidden peer">
                                <label for="star1" class="cursor-pointer text-gray-400 peer-checked:text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/></svg>
                                </label>
        
                            </div>
        
                            <div class="mt-5 w-full">
                                <p class="mb-1 font-semibold text-gray-500">Description</p>
                                <textarea name="description" id="desc" rows="5" class="p-5 border border-gray-500 w-full rounded"></textarea>
                            </div>
        
                            <button 
                                type="submit"
                                class="w-full mt-5 py-2 px-2 flex gap-3 items-center justify-center rounded-lg bg-gray-800 text-white hover:brightness-120 cursor-pointer"
                            >
                                Submit Feedback
                            </button>
                        </form>
                    </div>
                <?php
                    }
                ?>
                
            </div>

            <div class="w-[300px] flex-none border rounded-lg p-5 flex flex-col items-center">
                <h2 class="mb-5 text-xl">Primary Guest<h2>

                <div class="w-full flex flex-col items-center gap-4">
                    <div class="w-24 h-24 rounded-full bg-gray-200 text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></g></svg>
                    </div>
                    <div class="w-full flex gap-3 items-center">
                        <div class="w-5/12">
                            Name
                        </div>
                        <div class="w-7/12">
                            <?php echo($row['f_name']) ?> <?php echo($row['l_name']) ?>
                        </div>
                    </div>
                    <div class="w-full flex gap-3 items-center">
                        <div class="w-5/12">
                            Email
                        </div>
                        <div class="w-7/12">
                            <?php echo($row['cust_email']) ?>
                        </div>
                    </div>
                    <div class="w-full flex gap-3 items-center">
                        <div class="w-5/12">
                            Phone
                        </div>
                        <div class="w-7/12">
                            <?php echo($row['cust_phone']) ?>
                        </div>
                    </div>
                    <div class="w-full flex gap-3 items-center">
                        <div class="w-5/12">
                            Passport Number
                        </div>
                        <div class="w-7/12">
                            <?php echo($row['passport_no']) ?>
                        </div>
                    </div>
                    <div class="w-full flex gap-3 items-center">
                        <div class="w-5/12">
                            Origin
                        </div>
                        <div class="w-7/12">
                            <?php echo($row['country']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-10 left-0 px-12 w-full">
            <a 
                href="../../confirmation.php?u=<?php echo $_GET['id']; ?>"
                class="w-full py-3 px-4 flex gap-3 items-center justify-center rounded-lg bg-amber-600 text-white hover:brightness-120 cursor-pointer"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16H8m6-8H8m8 4H8M4 3a1 1 0 0 1 1-1a1.3 1.3 0 0 1 .7.2l.933.6a1.3 1.3 0 0 0 1.4 0l.934-.6a1.3 1.3 0 0 1 1.4 0l.933.6a1.3 1.3 0 0 0 1.4 0l.933-.6a1.3 1.3 0 0 1 1.4 0l.934.6a1.3 1.3 0 0 0 1.4 0l.933-.6A1.3 1.3 0 0 1 19 2a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1a1.3 1.3 0 0 1-.7-.2l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.934.6a1.3 1.3 0 0 1-1.4 0l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-1.4 0l-.934-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-.7.2a1 1 0 0 1-1-1z"/></svg>
                View Invoice
            </a>
        </div>
    </div>
</body>
</html>