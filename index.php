<?php

    // settings
    ini_set('display_error', 1);
    error_reporting(E_ALL);

    // Include system files
    define('ROOT', dirname(__FILE__));
    require_once(ROOT . '/components/Router.php');
    require_once(ROOT . '/components/Db.php');

    // Router
    $router = new Router();
    $router->run();


?>