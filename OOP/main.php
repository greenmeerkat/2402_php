<?php

require_once('./mammal/Whale.php');
require_once('./mammal/FlyingSquirrel.php');
require_once('./Swimm.php');
require_once('./Breath.php');
require_once('./fish/Saba.php');
use inf\Swimm;
use inf\Breath;
use mammal\Whale;
use mammal\FlyingSquirrel;
use fish\Saba;

$whaleInstance = new Whale('고래');
$whaleInstance->swimming();

$flyingSquirrelInstance = new FlyingSquirrel('날다람쥐');
$flyingSquirrelInstance->printRegidence();

$sabaInstance = new Saba('고등어');

test($whaleInstance);

function test(Swimm $instance) {
    $instance->swimming();
}