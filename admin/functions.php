<?php

function confirm($result){
    global $con;
    if(!$result){
        die("Query failed".mysqli_error($con));
    }
}
