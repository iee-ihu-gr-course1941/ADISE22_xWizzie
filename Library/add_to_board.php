<?php
include_once('db_connect.php');
include('update_last_action.php');

$sql = "SELECT * FROM board WHERE ((right_of IS NULL) OR (left_of IS NULL))";
$result = mysqli_query($conn, $sql);

$input_tile = "3_2";

//json_decode(file_get_contents('php://input'), true);
$numrows = mysqli_num_rows($result);
echo $numrows;
//Check the query res$result$result
if ($numrows > 0) {

    $board_tiles = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $found_array = json_encode(check_where_to_place($board_tiles,$input_tile));
    
    //find a better way to return from function called
    //ECHO VALUES FOUND TO CATCH IN JS AND DISPLAY OPTIONS

    // echo json_encode($board_tiles);
    // echo $found_array;

} else {
    $sql = "INSERT INTO board(tile_id,is_center) VALUES('$input_tile',1)";
    $result = mysqli_query($conn, $sql);
 }

function check_where_to_place($board_tiles,$input_tile){

    $off_board = explode("_",$input_tile);
    $found_array = [];

    foreach($board_tiles as $row){
        $on_board = explode("_",$row['tile_id']);

        foreach($off_board as $index => $number){
            foreach($on_board as $index_on => $number_on){
                if ($number == $number_on){
                    //Returns 0-1 for where the same was found
                    //ex if you try to put 2_1 and 1_1 is on board 
                    //its going to return 1_0 as it found the 2nd number of input
                    //at 1st input of tile on board

                    //echo "On table off on line:".$index." Value:".$number." on table on line:".$index_on."value:".$number_on."<br>";
                    array_push($found_array,$index."-".$index_on);
                }
            }
        }
    }
    return $found_array;
}