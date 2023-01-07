<?php

session_start();

$HOST = 'localhost';
$DB_PWD = '';
$USERNAME = 'root';
$DATABASE = 'trydominoes';
//$PORT = '3333';
//.':'.$PORT
$conn = new mysqli($HOST, $USERNAME, $DB_PWD, $DATABASE);

if ($conn->connect_error) {
    die('Connection Failed' . $conn->connect_error);
}

if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $sql = "UPDATE user SET last_action = NOW() WHERE token='$token'";
    mysqli_query($conn, $sql);
}   
