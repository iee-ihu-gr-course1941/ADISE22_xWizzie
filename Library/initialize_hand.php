<?php
include_once('db_connect.php');
include('update_last_action.php');

// Parse the request body as a JSON object
    $token = $_SESSION['token'];

    //This would have been a trigger but apparently mysql cant delete before inserting ¯\_(ツ)_/¯
    $sql = "DELETE FROM hand WHERE player_token = '$token'";
    if (mysqli_query($conn, $sql)) {
        echo "Record Deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $array = json_decode(file_get_contents('php://input'), true);

    foreach ($array as $string) {
        // Insert the string into the database
        $sql = "INSERT INTO hand(player_token,tile_id) VALUES ('$token','$string')";

        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // $sql = "DELETE FROM board";
    // mysqli_query($conn, $sql);
