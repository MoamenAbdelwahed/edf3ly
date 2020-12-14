
<?php

$router->get('/', function () use ($router) {
    header("HTTP/1.0 404 Not Found");exit;
});

$router->group(['prefix'=>'api/v1'], function () use ($router) {
    require_once (__DIR__ .'/cart.php');
});
