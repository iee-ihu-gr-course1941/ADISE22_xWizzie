<?php

if (isset($_POST['functionname'])) {


    $functionname = $_POST['functionname'];
    switch ($functionname) {
        case 'insert_right_of':
            $functionname = "";
            insert_right_of();
            break;
        case 'insert_left_of':
            $functionname = "";
            insert_left_of();
            break;
    }
} else {

    include_once('db_connect.php');
    include('update_last_action.php');

    $sql = 'select status from game';
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_row($result);

    if ($rows[0] == 'started') {
        $sql = "SELECT * FROM board WHERE ((right_of IS NULL) OR (left_of IS NULL))";
        $result = mysqli_query($conn, $sql);
        $numrows = mysqli_num_rows($result);

        //$input_tile = '0_6';
        $input_tile = json_decode(file_get_contents('php://input'), true);

        //Check the query res$result$result
        if ($numrows > 0) {

            $board_tiles = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $found_array = json_encode(check_where_to_place($board_tiles, $input_tile));

            echo $found_array;

            //ECHO VALUES FOUND TO CATCH IN JS AND DISPLAY OPTIONS

        } else {
            $sql = "INSERT INTO board(tile_id,is_center,orientation) VALUES('$input_tile',1,90)";
            $result = mysqli_query($conn, $sql);

            $found_array = [];
            array_push($found_array, array(
                "where" => null,
                "of" => null,
                "which" => null,
                "rotate" => 90
            ));

            echo json_encode($found_array);
        }
    } else {
        echo "<script>document.getElementById('error-p').innerHTML = 'Waiting for player'</script>";
    }
}
function check_where_to_place($board_tiles, $input_tile)
{
    include_once('db_connect.php');

    $off_board = explode("_", $input_tile);
    $found_array = [];

    foreach ($board_tiles as $key => $row) {
        $on_board = explode("_", $row['tile_id']);


        if ($row['orientation'] == 90) {
            foreach ($off_board as $index => $number) {
                //echo "Off index: ".$index." and number: ".$number."<br>";
                foreach ($on_board as $index_on => $number_on) {
                    if ($number === $number_on) {
                        if ($index == 0 && $index_on == 0) {
                            array_push($found_array, array(
                                "where" => "to_right",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => -90
                            ));
                        } elseif ($index == 0 && $index_on == 1) {
                            array_push($found_array, array(
                                "where" => "to_left",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => 90
                            ));
                        } elseif ($index == 1 && $index_on == 0) {
                            array_push($found_array, array(
                                "where" => "to_right",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => 90
                            ));
                        } elseif ($index == 1 && $index_on == 1) {
                            array_push($found_array, array(
                                "where" => "to_left",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => -90
                            ));
                        }
                    }
                }
            }
        } else {
            foreach ($off_board as $index => $number) {
                //echo "Off index: ".$index." and number: ".$number."<br>";

                foreach ($on_board as $index_on => $number_on) {
                    if ($number === $number_on) {
                        //Returns 0-1 for where the same was found
                        //ex if you try to put 2_1 and 1_1 is on board 
                        //its going to return 1_0 as it found the 2nd number of input
                        //at 1st input of tile on board

                        //echo "On table off on line: ".$index." value: ".$number."On table on line: ".$index_on." value: ".$number_on."<br>";
                        if ($index == 0 && $index_on == 0) {
                            array_push($found_array, array(
                                "where" => "to_left",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => 90
                            ));
                        } elseif ($index == 0 && $index_on == 1) {
                            array_push($found_array, array(
                                "where" => "to_right",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => -90
                            ));
                        } elseif ($index == 1 && $index_on == 0) {
                            array_push($found_array, array(
                                "where" => "to_left",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => -90
                            ));
                        } elseif ($index == 1 && $index_on == 1) {
                            array_push($found_array, array(
                                "where" => "to_right",
                                "of" => $row['tile_id'],
                                "which" => $input_tile,
                                "rotate" => 90
                            ));
                        }
                    }
                }
            }
        }


        $last_row = end($found_array);
        if ($last_row != null) {
            if ($row['left_of'] != null && $last_row['where'] == 'to_right') {
                $x = array_pop($found_array);
            }
            if ($row['right_of'] != null && $last_row['where'] == 'to_left') {
                $x = array_pop($found_array);
            }
        }
    }

    return $found_array;
}

function insert_right_of()
{
    include_once('db_connect.php');

    if (isset($_POST['input_tile']) && isset($_POST['tile_on_board']) && isset($_POST['rotate'])) {
        $results = [];

        $input_tile = $_POST['input_tile'];
        $tile_on_board = $_POST['tile_on_board'];
        $orientation = $_POST['rotate'];

        $sql = "insert into board(tile_id,right_of,orientation) values ('$input_tile','$tile_on_board',$orientation)";
        $results[] = mysqli_query($conn, $sql);


        $sql = "update board set left_of = '$input_tile' where tile_id= '$tile_on_board'";
        $results[] = mysqli_query($conn, $sql);

        $token = $_SESSION['token'];

        $sql = "delete from hand where player_token = '$token' and tile_id = '$input_tile'";
        $results[] = mysqli_query($conn, $sql);

        include('change_status.php');
        echo json_encode($results);
    } else {

        echo json_encode("Error");
    }
}

function insert_left_of()
{
    include_once('db_connect.php');

    if (isset($_POST['input_tile']) && isset($_POST['tile_on_board']) && isset($_POST['rotate'])) {
        $results = [];

        $input_tile = $_POST['input_tile'];
        $tile_on_board = $_POST['tile_on_board'];
        $orientation = $_POST['rotate'];

        $sql = "insert into board(tile_id,left_of,orientation) values ('$input_tile','$tile_on_board',$orientation)";
        $results[] = mysqli_query($conn, $sql);


        $sql = "update board set right_of = '$input_tile' where tile_id= '$tile_on_board'";
        $results[] = mysqli_query($conn, $sql);

        $token = $_SESSION['token'];

        $sql = "delete from hand where player_token = '$token' and tile_id = '$input_tile'";
        $results[] = mysqli_query($conn, $sql);

        include('change_status.php');
        echo json_encode($results);
    } else {

        echo json_encode("Error");
    }
}
