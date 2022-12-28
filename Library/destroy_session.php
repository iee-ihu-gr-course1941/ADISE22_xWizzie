<?php
$check_if_exists = "SELECT username FROM user";
$res = mysqli_query($conn, $check_if_exists);
if ($res->num_rows == 0) {
    $new_status = 'not active';
    $sql = "UPDATE game SET status='not active' WHERE row=1";
    mysqli_query($conn, $sql);
}
$token = $_SESSION['token'];
$sql = "DELETE FROM user WHERE token='$token'";
mysqli_query($conn, $sql);
session_destroy();
