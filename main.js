function outline(element) {
    element.className = "tileHovered"
}
function unoutline(element) {
    element.className = "tileUnhovered"
}

function createInitialHand() {
    let handArrayList = new Array(8).fill(0).map(() => new Array(2).fill(0));


    // Fill the array with random numbers between 0 and 6
    for (let i = 0; i < handArrayList.length; i++) {
        for (let j = 0; j < handArrayList[i].length; j++) {
            handArrayList[i][j] = Math.floor(Math.random() * 6);
        }
    }


    console.log(handArrayList)

    for (i = 1; i <= 7; i++) {
        if (handArrayList[i][0] > handArrayList[i][1]) {
            document.getElementById('img_' + i).src = 'Images/' + handArrayList[i][1] + "_" + handArrayList[i][0] + ".png"
        } else {
            document.getElementById('img_' + i).src = 'Images/' + handArrayList[i][0] + "_" + handArrayList[i][1] + ".png"
        }
    }
}