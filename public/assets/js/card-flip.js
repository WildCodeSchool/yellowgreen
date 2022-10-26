let textDiv = document.getElementById("flip-text"); //catches the text
let cardDiv = document.getElementById("card-flip"); //catches the card-flip ID
let textDivContent = textDiv.innerHTML;
console.log(textDivContent);
let cardDivContent = cardDiv.innerHTML;
console.log(cardDivContent);
cardDivContent = textDivContent;
console.log(cardDivContent);




/*let result;
let cardArray = (Array.from(cardFlip.classList));

cardArray.forEach(element => {
    result = element.includes('flip-2-ver-right-2');
    cardFlip = document.getElementById("card-flip");
    cardArray = (Array.from(cardFlip.classList));
});

if (result === false) {
    cardFlip.addEventListener('click', flip);
}

if (result === true) {
    cardFlip.addEventListener('click', flip2);

}
*/


function flip() {
    cardDiv.classList.add('flip-2-ver-right-2');
    cardDiv.innerHTML = textDivContent;
    /*cardArray.forEach(element => {
        result = element.includes('flip-2-ver-right-2');
    })*/
}

// console.log(result);

function flip2() {
    cardDiv.classList.add('flip-2-ver-left-2');
}

cardDiv.addEventListener('click', flip);
