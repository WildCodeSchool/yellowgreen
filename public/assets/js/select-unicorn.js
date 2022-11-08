// Select and update the chosen unicorn by the user

const changeSelected1 = () => {
    let select = document.getElementById('select-user');
    select.value = 1;
};

const changeSelected2 = () => {
    let select = document.getElementById('select-user');
    select.value = 2;
};

const changeSelected3 = () => {
    let select = document.getElementById('select-user');
    select.value = 3;
};

const allena = document.getElementById('allena');
allena.addEventListener('click', () => {
    changeSelected1();
    allena.classList.toggle("shadow-drop-2-center");
    larissa.classList.toggle('opacity-low');
    suki.classList.toggle('opacity-low');
});


const larissa = document.getElementById('larissa');
larissa.addEventListener('click', () => {
    changeSelected2();
    larissa.classList.toggle("shadow-drop-2-center");
    allena.classList.toggle('opacity-low');
    suki.classList.toggle('opacity-low');
});

const suki = document.getElementById('suki');
suki.addEventListener('click', () => {
    changeSelected3();
    suki.classList.toggle("shadow-drop-2-center");
    allena.classList.toggle('opacity-low');
    larissa.classList.toggle('opacity-low');
});
// Selection by the opponent 

const SelectedByComputer = () => {
    let selectOpponent = document.getElementById('select-opponent');
    if (Math.random() * 10 < 3.3) {
        selectOpponent.value = 1;
    } else if (Math.random() * 10 > 3.3 && Math.random() * 10 < 6.7) {
        selectOpponent.value = 2;
    } else { selectOpponent.value = 3; }
};


SelectedByComputer();

// Hover on the unicorn cards 

let unicorns = document.querySelectorAll('.unicorn');

grow = (e) => {
    e.target.classList.toggle('normal')
    e.target.classList.toggle('grow')
}

function eventHandler() {
    unicorns.forEach(item => {
        item.addEventListener("mouseenter", grow, false);
        item.addEventListener("mouseleave", grow, false);
    })
}
eventHandler();