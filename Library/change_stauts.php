<?php
include_once('db_connect.php');

//change p turn
if($_SESSION['p_number'] == 'One'){
    $sql = "UPDATE game SET player_turn='Two'";
}else{
    $sql = "UPDATE game SET player_turn='One'";
}
mysqli_query($conn,$sql);

$token = $_SESSION['token'];
$sql = "SELECT * FROM hand WHERE player_token = '$token'";
$result = mysqli_fetch_row(mysqli_query($conn,$sql));

if ($result == 0){
    if($_SESSION['p_number'] == 'One'){
        $sql = "UPDATE game SET winner='One'";
    }else{
        $sql = "UPDATE game SET winner='Two'";
    }
}

