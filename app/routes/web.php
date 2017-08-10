<?php

$app->get('/signup', 'App\Controllers\web\UserController:getSignUp')->setName('signup');
$app->post('/signup', 'App\Controllers\web\UserController:signUp')->setName('post.signup');
$app->get('/test/{id}', 'App\Controllers\web\HomeController:timeline')->setName('timeline');

$app->get('/user/show/profile', 'App\Controllers\web\UserController:viewProfile')->setName('user.view.profile');
$app->get('/user/setting/profile', 'App\Controllers\web\UserController:settingProfile')->setName('user.setting.profile');

$app->get('/admin', 'App\Controllers\web\UserController:getLoginAsAdmin')->setName('login.admin');
$app->post('/admin', 'App\Controllers\web\UserController:loginAsAdmin');
$app->get('/user', 'App\Controllers\web\UserController:getAllUser');
$app->get('/', 'App\Controllers\web\UserController:getLogin')->setName('login');
$app->get('/item/{id}', 'App\Controllers\web\HomeController:showItem');
$app->post('/', 'App\Controllers\web\UserController:login')->setName('post.login');

$app->get('/guard/show', 'App\Controllers\web\GuardController:showGuardByUser');
$app->get('/guard/show/{id}', 'App\Controllers\web\GuardController:showUserByGuard');

$app->get('/guard/delete/{id}', 'App\Controllers\web\GuardController:deleteGuardian');

$app->group('', function() use ($app, $container) {
    $app->get('/home', 'App\Controllers\web\HomeController:index')->setName('home');
    $app->get('/logout', 'App\Controllers\web\UserController:logout')->setName('logout');
    $app->get('/profile', 'App\Controllers\web\UserController:viewProfile')->setName('user.profile');
    $app->get('/setting', 'App\Controllers\web\UserController:getSettingAccount')->setName('user.setting');
    $app->post('/setting', 'App\Controllers\web\UserController:settingAccount');
    $app->get('/group', 'App\Controllers\web\GroupController:index')->setName('group');
    $app->get('/group/{id}', 'App\Controllers\web\GroupController:enter')->setName('pic.group');

    // $app->get('/group/{id}', function ($request, $response, $args) {
    //     return $this->view->render($response, 'user/group-list.twig');
    // });
    // $app->get('/grop', function ($request, $response) {
    //     return $this->view->render($response, 'users/group-list.twig');
    // });
    // $app->get('/grup', function ($request, $response) {
    //     return $this->view->render($response, 'users/group-list.twig');
    // });
    // ->add(new \App\Middlewares\web\GuardMiddleware($container));
})->add(new \App\Middlewares\web\AuthMiddleware($container));
