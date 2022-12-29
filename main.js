let player_turn = null;

async function start_update_board() {
  if (!document.getElementById('hand-div').hidden) {
    await update_board()
    setInterval(await update_board, 5000)
  }
}

async function update_board() {

  const container = document.querySelector('#board-div');
  const divsWithUnderscore = container.querySelectorAll('div[id*="_"]');
  divsWithUnderscore.forEach(div => div.remove());

  let tiles_on_board
  await $.ajax({
    url: '/Library/board_status.php',
    type: 'post',
    success: function (output) {
      tiles_on_board = JSON.parse(output)
    },
    error: function (output) {
      console.log("And failed")
    }
  });

  console.log(tiles_on_board)
  const board_div = document.getElementById('board-div').getBoundingClientRect();
  const width = board_div.left + board_div.right;
  const height = board_div.top + board_div.bottom;

  // Calculate the center point of the div
  const centerX = width / 2 - 140;
  const centerY = height / 2 - 70;

  let left = 0
  let right = 0
  let prev = null
  let first = null
  for (const element of tiles_on_board) {
    let newDiv = document.createElement('div');
    console.log(centerX)
    if (element.is_center != 1) {
      if (element.tile_id == prev.left_of) {
        console.log('Hi')
        right += 150
        newDiv.style.left = centerX + right + "px"
      }
      if (element.tile_id == prev.right_of || element.tile_id == first.right_of) {
        console.log('No hi')
        left -= 150
        newDiv.style.left = centerX + left + "px"
      }
    } else {
      first = element
      newDiv.style.left = centerX + "px";
    }
    newDiv.style.top = centerY + "px";
    newDiv.style.position = 'absolute';

    newDiv.id = element.tile_id
    newDiv.style.borderRadius = '10px'
    newDiv.style.transform = 'rotate(' + element.orientation + 'deg)'
    newDiv.className = 'tile_on_board'
    newDiv.innerHTML = '<img src="Images/' + element.tile_id + '.png">'
    document.getElementById('board-div').appendChild(newDiv)

    delete newDiv
    prev = element
  }
}

function outline(element) {
  element.className = "tileHovered"
}

function unoutline(element) {
  element.className = "tileUnhovered"
}

function generateRandomStrings() {
  const strings = new Set();
  while (strings.size < 7) {
    const x = Math.floor(Math.random() * 6);
    const y = Math.floor(Math.random() * 6);
    if (x < y) {
      strings.add(`${x}_${y}`);
    } else {
      strings.add(`${y}_${x}`);
    }
  }
  return Array.from(strings);
}

let handIDList = new Array(7)
function createInitialHand() {
  let handArrayList = new Array(8).fill(0).map(() => new Array(2).fill(0));


  // Fill the array with random numbers between 0 and 6
  handArrayList = generateRandomStrings()

  for (i = 0; i < 7; i++) {
    handIDList[i] = handArrayList[i]
    document.getElementById('img_' + (i + 1)).src = 'Images/' + handIDList[i] + ".png"
  }

  var arrayJson = JSON.stringify(handIDList);

  fetch('Library/initialize_hand.php', {
    method: 'POST',
    body: arrayJson,
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => {
    if (response.ok) {
      console.log('Strings inserted successfully');

    } else {
      console.log('Error inserting strings');
    }
  });


}

async function tryMove(element) {
  let elID = element.id
  let handIdIndex = elID.charAt(elID.length - 1)

  let tile_to_move = handIDList[handIdIndex]

  let board = document.getElementById('board-div')
  let toMove = document.getElementById(element.id)

  await get_board_state()

  let move = await check_available_moves(board, toMove)
  //console.log(move)
  if (move.length > 0) {
    const boardDiv = document.querySelector('#board-div');
    const toDelete = boardDiv.querySelectorAll('div:not([class*="img"])');
    toDelete.forEach(td => {
      if (td.className == 'tileHoveredInBoard')
        td.remove()
    })
    move.forEach(m => {
      show_options(m, toMove)
    })
  }

}

async function show_options(move, toMove) {

  await get_board_state()
  //console.log(move)

  const boardDiv = document.getElementById('board-div');

  const imgElement = boardDiv.querySelector(`div[id*='${move.of}']`);


  const left = imgElement.offsetLeft
  const top = imgElement.offsetTop
  const right = imgElement.offsetHeight

  //console.log(left + " " + top + " " + right)

  const newDiv = document.createElement('div');
  newDiv.style.position = 'absolute';

  //newDiv.style.top = `${top}px`;

  newDiv.style.borderRadius = '10px'
  newDiv.style.transform = 'rotate(' + move.rotate + 'deg)';
  newDiv.className = 'tileHoveredInBoard'
  newDiv.id = move.which.toString()

  if (move.where == 'to_right') {
    newDiv.style.left = `${left + right}px`
    newDiv.style.top = `${top}px`

    newDiv.addEventListener('click', function () {
      $.ajax({
        url: '/Library/add_to_board.php',
        type: 'post',
        data: {
          functionname: 'insert_right_of',
          input_tile: move.which,
          tile_on_board: move.of,
          rotate: move.rotate
        },
        success: function (output) {
          newDiv.className = 'tile_on_board'
          //style="transform:rotate('+move.rotate+'deg);
          newDiv.innerHTML = '<img src="Images/' + move.which + '.png">';
          toMove.remove()
          const boardDiv = document.querySelector('#board-div');
          const toDelete = boardDiv.querySelectorAll('div:not([class*="img"])');
          toDelete.forEach(td => {
            if (td.className == 'tileHoveredInBoard')
              td.remove()
          })
          update_status()
        },
        error: function (output) {
          console.log("And failed")
        }
      });
    });
  } else if (move.where == 'to_left') {
    newDiv.style.left = `${left - right}px`;
    newDiv.style.top = `${top}px`

    newDiv.addEventListener('click', function () {
      $.ajax({
        url: '/Library/add_to_board.php',
        type: 'post',
        data: {
          functionname: 'insert_left_of',
          input_tile: move.which,
          tile_on_board: move.of,
          rotate: move.rotate
        },
        success: function (output) {
          newDiv.className = 'tile_on_board'
          //style="transform:rotate('+move.rotate+'deg);
          newDiv.innerHTML = '<img src="Images/' + move.which + '.png">';
          toMove.remove()
          const boardDiv = document.querySelector('#board-div');
          const toDelete = boardDiv.querySelectorAll('div:not([class*="img"])');
          toDelete.forEach(td => {
            if (td.className == 'tileHoveredInBoard')
              td.remove()
            update_status()
          })
        },
        error: function (output) {
          console.log("And failed")
        }
      });
    });
  }
  document.getElementById('board-div').appendChild(newDiv);
}


async function check_available_moves(board, toMove) {
  await $.ajax({
    url: '/Library/get_player_turn.php',
    type: 'post',
    data: { functionname: 'check' },
    success: function (output) {
      let array = JSON.parse(output)
      player_turn = array[0]
      sess_name = array[1]
      //console.log(player_turn + " " + sess_name)
    },
    error: function (output) {
      console.log("And failed")
    }
  });
  if (player_turn != sess_name) {
    document.getElementById('error-p').innerHTML = 'Wait for your turn.'
    setTimeout(function () {
      document.getElementById('error-p').innerHTML = ''
    }, 5000);
  } else {
    let data
    // console.log(bs_array)
    if (bs_array[0].tile_id == null) {
      const div = document.getElementById('board-div').getBoundingClientRect();

      const width = div.left + div.right;
      const height = div.top + div.bottom;

      // Calculate the center point of the div
      const centerX = width / 2 - 140;
      const centerY = height / 2 - 70;

      const newDiv = document.createElement('div');
      newDiv.style.position = 'relative';
      newDiv.style.top = centerY + "px";
      newDiv.style.left = centerX + "px";
      //console.log(centerX + " " + centerY)

      newDiv.style.borderRadius = '10px'
      newDiv.style.transform = 'rotate(90deg)';
      newDiv.className = 'tile_on_board'

      const img = toMove.children[0].src.toString()
      //console.log(img.length)
      const match_move_of = img.substring(img.length - 7, img.length - 4);

      newDiv.id = match_move_of.toString()
      newDiv.innerHTML = '<img src="Images/' + match_move_of + '.png">';

      document.getElementById('board-div').appendChild(newDiv);
      toMove.remove()

      await fetch('Library/add_to_board.php', {
        method: 'POST',
        body: JSON.stringify(handIDList[toMove.id.charAt(toMove.id.length - 1) - 1]),
        headers: {
          'Content-Type': 'application/json'
        }
      })

    } else {
      await fetch('Library/add_to_board.php', {
        method: 'POST',
        body: JSON.stringify(handIDList[toMove.id.charAt(toMove.id.length - 1) - 1]),
        headers: {
          'Content-Type': 'application/json'
        }
      }).then(response => {
        if (response.ok) {
          data = response.json()
        } else {
          console.log('Error Adding Tile');
        }
      })

      return data
    }
  }
}

const bs_array = [];
async function get_board_state() {



  bs_array.length = 0

  const response = await fetch("Library/check_for_move.php", {
    method: 'POST',
    body: JSON.stringify(""),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  // Convert the response to JSON
  const data = await response.json()
  // Store the returned bs_array in an array

  for (const item of data) {
    const obj = {
      tile_id: item.tile_id,
      right_of: item.right_of,
      left_of: item.left_of,
      below_of: item.below_of,
      above_of: item.above_of,
      is_center: item.is_center
    }

    //bs_array.push([tile_id,right_of,left_of,below_of,above_of,is_center])
    bs_array.push(obj)
  }
  //console.log(bs_array)
  return bs_array
}

function submit_username() {
  console.log(JSON.stringify(document.getElementById("username-text-input").value))
  let username = JSON.stringify(document.getElementById("username-text-input").value)
  fetch('Library/add_user.php', {
    method: 'POST',
    body: username,
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => {
    if (response.ok) {
      console.log('User inserted successfully');
    } else {
      console.log('Error inserting user');
    }
  })
  createInitialHand()
  document.getElementById('user-div').hidden = true
  document.getElementById('error-div').hidden = false
  document.getElementById('hand-div').hidden = false
  start_update_board()
}


function session_destroy() {
  fetch('Library/destroy_session.php', {
    method: 'POST'
  })
}

function update_status() {
  $.ajax({
    url: '/Library/check_for_move.php',
    type: 'post',
    success: function (output) {
      //console.log(output);
    },
    error: function (output) {
      console.log("And failed")
    }
  });
}


function test(element) {

  document.getElementById('error-p').innerHTML = 'Waiting for player'

}