const changeSelected1 = () => {
    let select = document.getElementById('select');
    select.value = 1;
};

const changeSelected2 = () => {
    let select = document.getElementById('select');
    select.value = 2;
};

const changeSelected3 = () => {
    let select = document.getElementById('select');
    select.value = 3;
};

const allena = document.getElementById('allena');
allena.addEventListener('click', changeSelected1);

const larissa = document.getElementById('larissa');
larissa.addEventListener('click', changeSelected2);

const sushi = document.getElementById('sushi');
sushi.addEventListener('click', changeSelected3);


