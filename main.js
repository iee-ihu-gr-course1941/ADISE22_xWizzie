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

async function draw_board() {
  await get_board_state()

  //bs_array.forEach(bs => )

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
      //console.log(m)
      show_options(m, toMove)
    })
  }
  // console.log(move)
  // console.log(move.length)
}

async function show_options(move, toMove) {
  await get_board_state()
  console.log(move)
  const boardDiv = document.querySelector('#board-div');
  const divs = boardDiv.querySelectorAll('div:has(img)');
  console.log(divs)

  if (move.rotate == 90) {
    for (const div of divs) {
      const img = div.querySelector('img');
      const match_move_of = (img.src).substring(img.src.length - 7, img.src.length - 4);
      if (move.of == match_move_of) {

        const left = div.offsetLeft
        const top = div.offsetTop
        const right = div.offsetHeight

        const newDiv = document.createElement('div');
        newDiv.style.position = 'absolute';
        newDiv.style.top = `${top}px`;
        newDiv.style.borderRadius = '10px'
        newDiv.id = '90 toright'
        newDiv.style.transform = 'rotate(' + move.rotate + 'deg)';
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
              })
            },
            error: function (output) {
              console.log("And failed")
            }
          });
        });
        newDiv.className = 'tileHoveredInBoard'

        if (move.where == 'to_right') {

          //if this tile_id is not in any left_of on the board table show it

          newDiv.style.left = `${left + right - 10}px`;

        }
        if (move.where == 'to_left') {
          newDiv.style.left = `${left - right - 10}px`;


        }

        document.getElementById('board-div').appendChild(newDiv);
      }
    }
  } else {
    for (const div of divs) {
      const img = div.querySelector('img');
      const match_move_of = (img.src).substring(img.src.length - 7, img.src.length - 4);

      if (move.of == match_move_of) {
        const left = div.offsetLeft
        const top = div.offsetTop
        const right = div.offsetHeight

        const newDiv = document.createElement('div');
        newDiv.style.position = 'absolute';
        newDiv.style.top = `${top}px`;
        newDiv.style.borderRadius = '10px'
        newDiv.id = '90 toright'
        newDiv.style.transform = 'rotate(' + move.rotate + 'deg)';
        if (move.where == 'to_right') {

          newDiv.style.left = `${left + right - 10}px`;

        }
        if (move.where == 'to_left') {

          newDiv.style.left = `${left - right - 10}px`;

        }
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
              })
            },
            error: function (output) {
              console.log("And failed")
            }
          });
        });

        newDiv.className = 'tileHoveredInBoard'
        document.getElementById('board-div').appendChild(newDiv);
      }
    }
  }
}

async function check_available_moves(board, toMove) {
  let data
  if (bs_array[0].tile_id == null) {
    const div = document.getElementById('board-div')
    const width = div.offsetWidth;
    const height = div.offsetHeight;

    // Calculate the center point of the div
    const centerX = width / 2;
    const centerY = height / 2;

    const newDiv = document.createElement('div');
    newDiv.style.position = 'absolute';
    newDiv.style.top = centerY;
    newDiv.style.left = centerX;
    newDiv.style.borderRadius = '10px'
    newDiv.style.transform = 'rotate(90deg)';
    newDiv.className = 'tile_on_board'

    const img = toMove.children[0].src.toString()
    console.log(img.length)
    const match_move_of = img.substring(img.length - 7, img.length - 4);

    newDiv.innerHTML = '<img src="Images/' + match_move_of+ '.png">';

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
    //console.log(data)
    return data
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
  document.getElementById('hand-div').hidden = false
  draw_board()
}


function session_destroy() {
  fetch('Library/destroy_session.php', {
    method: 'POST'
  })
}

function test(element) {

  // $.ajax({
  //   url: '/Library/check_for_move.php',
  //   type: 'post',
  //   data: { functionname: 'check' },
  //   success: function (output) {
  //     console.log(output);
  //   },
  //   error: function (output) {
  //     console.log("And failed")
  //   }
  // });
}