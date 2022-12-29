<?php 
    include_once('db_connect.php');

    $sql = "SELECT player_turn FROM game";
    $res = mysqli_fetch_all(mysqli_query($conn,$sql));

    $array = array($res[0][0],$_SESSION['p_number']);
    echo json_encode($array);