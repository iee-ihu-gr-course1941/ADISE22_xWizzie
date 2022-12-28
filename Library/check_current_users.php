<?php 
$check_if_exists = "SELECT username FROM user";
$res = mysqli_query($conn, $check_if_exists);


if ($res->num_rows === 0) {
    $sql = "INSERT INTO user(username,token,player_number) VALUES('$username',MD5('$username'),'One')";
    mysqli_query($conn, $sql);
    $_SESSION['p_number'] = 'One';

    $new_status = 'initialized';
    $sql ="UPDATE game SET status='initialized' WHERE row=1";
    mysqli_query($conn,$sql);
} else if ($res->num_rows === 1) {
    $sql = "INSERT INTO user(username,token,player_number) VALUES('$username',MD5('$username'),'Two')";
    mysqli_query($conn, $sql);
    $_SESSION['p_number'] = 'Two';

    $new_status = 'started';
    $sql ="UPDATE game SET status='started' WHERE row=1";
    mysqli_query($conn,$sql);
}
