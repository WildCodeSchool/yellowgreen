let textDiv = document.getElementById("flip-text"); //catches the flip-text ID
let cardDiv = document.getElementById("card-flip"); //catches the card-flip ID
let textDivContent = textDiv.innerHTML;
let cardDivContent = cardDiv.innerHTML;

function flipWithTimeout() {
    if (cardDiv.innerHTML === cardDivContent) {
        cardDiv.classList.add('flip-2-ver-right-2');
        cardDiv.innerHTML = textDivContent;
        setTimeout(removeClass, 450);
    } else {
        cardDiv.classList.add('flip-2-ver-right-2');
        cardDiv.innerHTML = cardDivContent;
        setTimeout(removeClass, 450);
    }
}

function removeClass() {
    cardDiv.classList.remove('flip-2-ver-right-2');
}

cardDiv.addEventListener('click', flipWithTimeout);
