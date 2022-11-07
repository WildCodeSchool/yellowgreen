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

const SelectedByComputer = () => {
    let selectOpponent = document.getElementById('select-opponent');
    if (Math.random() * 10 < 3.3) {
        selectOpponent.value = 1;
    } else if (Math.random() * 10 > 3.3 && Math.random() * 10 < 6.7) {
        selectOpponent.value = 2;
    } else { selectOpponent.value = 3; }
    console.log(selectOpponent.value);
};

const allena = document.getElementById('allena');
allena.addEventListener('click', changeSelected1);

const larissa = document.getElementById('larissa');
larissa.addEventListener('click', changeSelected2);

const sushi = document.getElementById('suki');
sushi.addEventListener('click', changeSelected3);

SelectedByComputer();
