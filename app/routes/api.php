<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\HomeController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:createUser')->setname('api.user.login');

    // $app->group('', function() use ($app, $container) {
    //
    // })->add(new \App\Middlewares\AuthToken($container));

    $app->post('/change/{id}', 'App\Controllers\api\UserController:postImage')->setname('api.user.ima');

    $app->group('/user', function() use ($app, $container) {
        $this->get('/', 'App\Controllers\api\UserController:index');

    });

       $app->group('/article', function() use ($app, $container) {
             $app->get('/list', 'App\Controllers\api\ArticleController:index');

        $app->post('/create', 'App\Controllers\api\ArticleController:create');

        $app->put('/update/{id}', 'App\Controllers\api\ArticleController:update');

        $app->delete('/delete/{id}', 'App\Controllers\api\ArticleController:delete');
        $app->get('/find/{id}', 'App\Controllers\api\ArticleController:find');
    });
});
