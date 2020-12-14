<?php

$router->group(['prefix' => 'cart'], function () use ($router) {
    $router->post('/', 'CartController@store');
});
