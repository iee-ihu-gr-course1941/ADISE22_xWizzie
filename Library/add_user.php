<?php
include_once('db_connect.php');

// Parse the request body as a JSON object
$array = json_decode(file_get_contents('php://input'), true);

$check_if_exists = "SELECT username FROM user WHERE username='$array'";
$res = mysqli_query($conn, $check_if_exists);



if ($res->num_rows === 0) {
    $sql = "INSERT INTO user(username,token) VALUES('$array',MD5('$array'))";
    mysqli_query($conn, $sql);
}
$sql1 = "SELECT token FROM user WHERE username = '$array'";
$rs = mysqli_query($conn, $sql1);
$t = mysqli_fetch_assoc($rs);
$_SESSION['token'] = $t['token'];
