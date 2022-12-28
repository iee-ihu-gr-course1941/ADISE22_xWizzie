<?php
if (isset($_SESSION['token'])) {
    if(!($_SESSION['token'] == "")){
        $token = $_SESSION['token'];
        //echo $token;
        $sql = "UPDATE user SET last_action = NOW() WHERE (token='$token')";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM user WHERE last_action < DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM user";
        $result = mysqli_query($conn, $sql);

        $num_rows = mysqli_fetch_row($result);
        if ($num_rows<2){
            $sql = "UPDATE game SET status='ended',winner='Aborted'";
        }
    }
}
