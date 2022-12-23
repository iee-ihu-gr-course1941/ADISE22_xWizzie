<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="test.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src='./main.js'></script>
</head>

<body onloadstart="submit_username()" onbeforeunload="session_destroy()">
    <div id="user-div" style="height: 100px;background-color: red;">
        <input type="text" name="username" id="username-text-input" placeholder="Username" value="xWizzie" style="top: 20px;">
        <input type="submit" name="submit" id="username-submit-button" value="Submit" onclick="submit_username()">
    </div>

    <div id="board-div">
    <div id="inner-board" onclick="test(this)">

    </div>
    </div>

    <div hidden="true" id="hand-div">
        <div id="tile_1" name="tile_1" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_1" />
        </div>
        <div id="tile_2" name="tile_2" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_2" />
        </div>
        <div id="tile_3" name="tile_3" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_3" />
        </div>
        <div id="tile_4" name="tile_4" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_4" />
        </div>
        <div id="tile_5" name="tile_5" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_5" />
        </div>
        <div id="tile_6" name="tile_6" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_6" />
        </div>
        <div id="tile_7" name="tile_7" class="tileUnhovered" onmouseover="outline(this) " onmouseleave="unoutline(this)" onmouseleave="unoutline(this)" onclick="tryMove(this)">
            <img id="img_7" />
        </div>
    </div>
</body>



</html>