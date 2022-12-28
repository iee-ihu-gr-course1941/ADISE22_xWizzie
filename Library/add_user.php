<?php
include_once('db_connect.php');

// Parse the request body as a JSON object
$username = json_decode(file_get_contents('php://input'), true);

include('check_current_users.php');
$sql1 = "SELECT token FROM user WHERE username = '$username'";
$rs = mysqli_query($conn, $sql1);
$t = mysqli_fetch_assoc($rs);
$_SESSION['token'] = $t['token'];
