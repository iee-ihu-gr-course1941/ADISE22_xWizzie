<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='test.css'>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src='./main.js'></script>
</head>

<body onload="createInitialHand()">
    <div parent style="position: absolute; left: 35vh; top: 82vh;width: auto; height:auto;background-color: green;"">
        <div id="tile_1" name="tile_1" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_1" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
        <div id="tile_2" name="tile_2" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_2" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
        <div id="tile_3" name="tile_3" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_3" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
        <div id="tile_4" name="tile_4" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_4" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
        <div id="tile_5" name="tile_5" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_5" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
        <div id="tile_6" name="tile_6" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_6" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
        <div id="tile_7" name="tile_7" class="tileUnhovered" style="width: 75px;height: 150px;margin-inline:10px;float: right;" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)">
            <img id="img_7" style="background-color:aliceblue;width: 65px;height: 140px;;position:relative"/>
        </div>
    </div>
</body>



</html>