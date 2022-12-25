<?php

if (isset($_POST['functionname'])) {
    $functionname = $_POST['functionname'];
    switch ($functionname) {
        case 'check':
            $functionname = "";
            check();
            break;
    }
}else{
    return_board();
}

function check()
{
    echo "Hi!";
}

function return_board()
{
    include_once('db_connect.php');

    // Select all rows from the table
    $sql = "SELECT * FROM board";
    $result = mysqli_query($conn, $sql);

    // Check the query result
    if (mysqli_num_rows($result) > 0) {
        // Fetch the rows as an associative array
        while ($row1 = mysqli_fetch_assoc($result)) {
            $rows_board[] = $row1;
        }
    } else {
        $rows_board = [""];
    }

    echo json_encode($rows_board);
    //return json_encode($rows_board);
}

function search_for_to_left($id){
    include_once('db_connect.php');

    $sql = "SELECT * FROM board WHERE left_of = '$id'";
    $res1 = mysqli_query($conn,$sql);
    return json_encode(mysqli_fetch_all($res,MYSQLI_ASSOC));
}
function search_for_to_right($id){
    include_once('db_connect.php');

    $sql = "SELECT * FROM board WHERE NOT right_of = '$id'";
    $res1 = mysqli_query($conn,$sql);
    return json_encode(mysqli_fetch_all($res,MYSQLI_ASSOC));
}