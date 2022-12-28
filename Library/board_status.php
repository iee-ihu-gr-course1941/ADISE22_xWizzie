<?php
    include_once('db_connect.php');
    $sql = 'SELECT * FROM board ORDER BY order_played';
    $result = mysqli_query($conn,$sql);
    echo json_encode(mysqli_fetch_all($result,MYSQLI_ASSOC));
