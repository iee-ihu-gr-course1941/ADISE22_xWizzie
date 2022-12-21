<?php

include_once('db_connect.php');

// Parse the request body as a JSON object
$array = json_decode(file_get_contents('php://input'), true);

foreach ($array as $string) {  
    // Insert the string into the database
    $sql = "INSERT INTO hand(player_token,tile_id) VALUES (1,'$string')";
  
    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

?>