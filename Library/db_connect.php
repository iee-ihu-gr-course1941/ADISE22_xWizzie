<?php

session_start();

$HOST = 'localhost';
$DB_PWD = '';
$USERNAME = 'it185162';
$DATABASE = 'trydominoes';

$conn = new mysqli($HOST.':3333', $USERNAME, $DB_PWD, $DATABASE);

if ($conn->connect_error) {
    die('Connection Failed' . $conn->connect_error);
}

if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $sql = "UPDATE user SET last_action = NOW() WHERE token='$token'";
    mysqli_query($conn, $sql);
}   
