<?php
    $token = $_SESSION['token'];
    $sql = "DELETE FROM user WHERE token='$token'";
    mysqli_query($conn, $sql);
    session_destroy();