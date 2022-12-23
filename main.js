function outline(element) {
  element.className = "tileHovered"
}
function unoutline(element) {
  element.className = "tileUnhovered"
}

let handIDList = new Array(7)
function createInitialHand() {
  let handArrayList = new Array(8).fill(0).map(() => new Array(2).fill(0));


  // Fill the array with random numbers between 0 and 6
  for (let i = 0; i < handArrayList.length; i++) {
    for (let j = 0; j < handArrayList[i].length; j++) {
      handArrayList[i][j] = Math.floor(Math.random() * 6);
    }
  }

  for (i = 1; i <= 7; i++) {
    if (handArrayList[i][0] > handArrayList[i][1]) {
      document.getElementById('img_' + i).src = 'Images/' + handArrayList[i][1] + "_" + handArrayList[i][0] + ".png"
      handIDList[i - 1] = handArrayList[i][1] + "_" + handArrayList[i][0]
    } else {
      document.getElementById('img_' + i).src = 'Images/' + handArrayList[i][0] + "_" + handArrayList[i][1] + ".png"
      handIDList[i - 1] = handArrayList[i][0] + "_" + handArrayList[i][1]
    }

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

  //We have tile id make logic to check if there is a valid move and if there is update db and show board

  let board = document.getElementById('board-div')
  let toMove = document.getElementById(element.id)
  await get_board_state().then((response =>{
    check_rules(board,toMove)
  }))
}

function check_rules(board,toMove){
  if (bs_array.length==1){
    board.appendChild(toMove)
    toMove.style = 'pointer-events: none; transform: rotate(90deg); position:relative;  margin: auto;text-align: center;'
    
    // var object = {
    //   tile_id: element.id,
    //   right_of:null,
    //   left_of:null,
    //   below_of:null,
    //   above_of:null,
    //   is_center: 1
    // };
    
    // alert(JSON.stringify(object))
    
  }else{    

  }

  // fetch('Library/add_to_board.php', {
  //   method: 'POST',
  //   body: JSON.stringify(""),
  //   headers: {
  //     'Content-Type': 'application/json'
  //   }
  // }).then(response => {
  //   if (response.ok) {
  //     console.log('Tile inserted successfully');
  //   } else {
  //     console.log('Error inserting tile');
  //   }
  // })
}

const bs_array = [];

async function get_board_state() {
  const response = await fetch("Library/check_for_move.php", {
    method: 'POST',
    body: JSON.stringify(""),
    headers: {
      'Content-Type': 'application/json'
    }
  });

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

}


function session_destroy() {
  fetch('Library/destroy_session.php', {
    method: 'POST'
  })
}

function test(element) {
  $.ajax({
    url: '/Library/check_for_move.php',
    type: 'post',
    data: {functionname: 'check'},
    success: function(output) {
      console.log(output);
    },
    error: function(output){
      console.log("And failed")
    }
  });
}