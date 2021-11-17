<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'fight' => ['FightController', 'statusFight',],
    'fighters' => ['FightersController', 'index',],
    'history' => ['FightController', 'index',],
    'credits' => ['ItemController', 'credit',],
    'fight/damage' => ['FightController', 'attack',],
    'fight/punch' => ['FightController', 'punch',],
    'fight/kick' => ['FightController', 'kick',],
    'fight/headbutt' => ['FightController', 'headbutt',],
    'fight/teatime' => ['FightController', 'teatime',],
    'fight/add' => ['FightController', 'add',],
];
