<?php
include_once('db_connect.php');

$token = $_SESSION['token'];
$sql = "SELECT * FROM hand WHERE player_token = '$token'";
$result = mysqli_fetch_row(mysqli_query($conn,$sql));

if ($result == 0){
    if($_SESSION['p_number'] == 'One'){
        $sql = "UPDATE game SET winner='One'";
    }else{
        $sql = "UPDATE game SET winner='Two'";
    }
    $result = mysqli_query($conn,$sql);
    $sql = "DELETE FROM board";
    $result = mysqli_query($conn,$sql);
}

