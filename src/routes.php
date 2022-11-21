<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'rules' => ['RulesController', 'index',],
    'users' => ['UserController', 'index',],
    'users/edit' => ['UserController', 'edit', ['id']],
    'users/show' => ['UserController', 'show', ['id']],
    'users/add' => ['UserController', 'add',],
    'users/delete' => ['UserController', 'delete', ['id']],
    'login' => ['UserController', 'login',],
    'logout' => ['UserController', 'logout',],
    'rgpd' => ['RgpdController', 'index',],
    'legal' => ['LegalController', 'index',],
    'about' => ['AboutController', 'index',],
    'fight' => ['FightController', 'selectRandomUsers'],
    'confirmOpponent' => ['FightController', 'confirmOpponent'],
    'round' => ['RoundController', 'fight',],
    'select-unicorn' => ['UnicornController', 'index',],
    'select-unicorn/select' => ['UnicornController', 'addSelectedUnicornToSession', ['id']],
    'selectattack' => ['FightController', 'index',],
    'loopInRound' => ['FightController', 'loopInRound',],
    'confirmAttack'  => ['FightController', 'confirmAttack',],
];
