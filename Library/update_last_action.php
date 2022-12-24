<?php
if (isset($_SESSION['token'])) {
    if(!($_SESSION['token'] == "")){
        $token = $_SESSION['token'];
        //echo $token;
        $sql = "UPDATE user SET last_action = NOW() WHERE (token='$token')";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM user WHERE last_action < DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
        mysqli_query($conn, $sql);
    }
}
