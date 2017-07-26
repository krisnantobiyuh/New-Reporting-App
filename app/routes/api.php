<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\HomeController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:register')->setname('api.register');
    $app->get('/activateaccount/{token}', 'App\Controllers\api\UserController:activateAccount')->setName('api.activate');
    $app->post('/forgot-password', 'App\Controllers\api\UserController:recovery')->setName('api.recovery');
    $app->get('/reset', 'App\Controllers\api\UserController:forgotPassword')->setName('api.reset');
    $app->post('/reset/{token}', 'App\Controllers\api\UserController:reset')->setName('api.recovery');
    $app->post('/test', 'App\Controllers\api\UserController:changePassword')->setName('api.reset.password');


    // $app->group('', function() use ($app, $container) {
    //
    // })->add(new \App\Middlewares\AuthToken($container));

    $app->post('/change/{id}', 'App\Controllers\api\UserController:postImage')->setname('api.user.ima');

    $app->group('/user', function() use ($app, $container) {
        $this->get('', 'App\Controllers\api\UserController:index');

    });

       $app->group('/article', function() use ($app, $container) {
             $app->get('/list', 'App\Controllers\api\ArticleController:index');

        $app->post('/create', 'App\Controllers\api\ArticleController:create');

        $app->put('/update/{id}', 'App\Controllers\api\ArticleController:update');

        $app->delete('/delete/{id}', 'App\Controllers\api\ArticleController:delete');
        $app->get('/find/{id}', 'App\Controllers\api\ArticleController:find');
    });
});
