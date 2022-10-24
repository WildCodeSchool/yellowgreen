<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'users' => ['UserControllerBis', 'userIndex',],
    'users/edit' => ['UserController', 'editUser', ['id']],
    'users/show' => ['UserController', 'showUser', ['id']],
    'users/add' => ['UserController', 'addUser',],
    'users/delete' => ['UserController', 'deleteUser',],
    'unicorns' => ['UnicornController', 'unicornIndex',],
    'unicorns/add' => ['UnicornController', 'addUnicorn',],
    'unicorns/show' => ['UnicornController', 'showUnicorn', ['id']],
    'unicorns/delete' => ['UnicornController', 'deleteUnicorn',],
    'attacks' => ['AttackController', 'attackIndex',],
    'attacks/add' => ['AttackController', 'addAttack',],
    'attacks/show' => ['AttackController', 'showAttack', ['id']],
    'attacks/delete' => ['AttackController', 'deleteAttack',],
];
