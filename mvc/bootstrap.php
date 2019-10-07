<?php
//load config
require_once 'config/config.php';
// Auto load Core libs
spl_autoload_register(function($className){

    require_once 'libs/'. $className . '.php';
});