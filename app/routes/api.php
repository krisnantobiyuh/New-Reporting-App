<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\HomeController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:createUser')->setname('api.user.login');

    // $app->group('', function() use ($app, $container) {
    //
    // })->add(new \App\Middlewares\AuthToken($container));


    $app->group('/user', function() use ($app, $container) {
        $app->get('/', 'App\Controllers\api\UserController:index');

    });
});
