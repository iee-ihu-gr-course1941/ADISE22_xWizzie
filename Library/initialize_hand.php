<?php
include_once('db_connect.php');
// Parse the request body as a JSON object

    $sql = "DELETE FROM hand";
    mysqli_query($conn, $sql);

    $array = json_decode(file_get_contents('php://input'), true);
    $token = $_SESSION['token'];

    foreach ($array as $string) {
        // Insert the string into the database
        $sql = "INSERT INTO hand(player_token,tile_id) VALUES ('$token','$string')";

        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

