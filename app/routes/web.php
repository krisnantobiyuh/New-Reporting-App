<?php

$app->get('/signup', 'App\Controllers\web\UserController:getSignUp')->setName('signup');
$app->post('/signup', 'App\Controllers\web\UserController:signUp')->setName('post.signup');
// $app->get('/test/{id}', 'App\Controllers\web\HomeController:timeline')->setName('timeline');


$app->get('/admin', 'App\Controllers\web\UserController:getLoginAsAdmin')->setName('login.admin');
$app->post('/admin', 'App\Controllers\web\UserController:loginAsAdmin');
$app->get('/user', 'App\Controllers\web\UserController:getAllUser');
$app->get('/', 'App\Controllers\web\UserController:getLogin')->setName('login');
$app->post('/', 'App\Controllers\web\UserController:login')->setName('post.login');
$app->get('/item/{id}', 'App\Controllers\web\HomeController:showItem')->setName('show.item');
$app->get('/test/{id}', 'App\Controllers\web\ItemController:byMonth');

$app->get('/guard/show', 'App\Controllers\web\GuardController:showGuardByUser');
$app->get('/guard/show/{id}', 'App\Controllers\web\GuardController:showUserByGuard');

$app->get('/guard/delete/{id}', 'App\Controllers\web\GuardController:deleteGuardian');

$app->group('', function() use ($app, $container) {
    $app->get('/home/', 'App\Controllers\web\HomeController:index')->setName('home');
    $app->get('/logout', 'App\Controllers\web\UserController:logout')->setName('logout');
    $app->get('/profile', 'App\Controllers\web\UserController:viewProfile')->setName('user.profile');
    $app->get('/setting', 'App\Controllers\web\UserController:getSettingAccount')->setName('user.setting');
    $app->post('/setting', 'App\Controllers\web\UserController:settingAccount');
    $app->get('/group', 'App\Controllers\web\GroupController:index')->setName('group');
    $app->get('/group/{id}', 'App\Controllers\web\GroupController:enter')->setName('pic.group');
    $app->get('/group/user/join', 'App\Controllers\web\GroupController:getGeneralGroup')->setName('group.user');
    $app->post('/create', 'App\Controllers\web\GroupController:add')->setName('web.group.add');
    $app->get('/pic/create', 'App\Controllers\web\GroupController:createByUser')->setName('pic.create.group');
    $app->post('/pic/create', 'App\Controllers\web\GroupController:createByUser')->setName('pic.create.group');
    $app->get('/items/group/{group}', 'App\Controllers\web\ItemController:getGroupItem')->setName('group.item');
    $app->get('/items/{group}', 'App\Controllers\web\ItemController:createItemUser')->setName('web.item.user.create');
    $app->post('/items/{group}', 'App\Controllers\web\ItemController:createItemUser')->setName('web.item.user.create');
    $app->get('/items/group/{group}/reported', 'App\Controllers\web\ItemController:getReportedGroupItem')->setname('web.reported.group.item');
    $app->get('/items/report/{item}', 'App\Controllers\web\ItemController:reportItem')->setname('web.report.item');
    $app->post('/item/report/{item}', 'App\Controllers\web\ItemController:reportItem')->setname('report.item');
    $app->get('/items/{item}/user', 'App\Controllers\web\ItemController:deleteItemByUser')->setname('web.user.delete.item');
    $app->get('/group/{id}/leave', 'App\Controllers\web\GroupController:leaveGroup')->setName('web.leave.group');
    $app->post('/comment', 'App\Controllers\web\CommentController:postComment')->setName('post.comment');

$app->group('/user', function() use ($app, $container) {
    $app->get('/show/profile', 'App\Controllers\web\UserController:viewProfile')->setName('user.view.profile');
    $app->get('/setting/profile', 'App\Controllers\web\UserController:settingProfile');
    $app->post('/setting/profile', 'App\Controllers\web\UserController:updateProfile')->setName('user.setting.profile');
    $app->post('/image/change', 'App\Controllers\web\UserController:changeImage')->setName('user.change.image');

});





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
    // )->add(new \App\Middlewares\web\AuthMiddleware($container)
})->add(new \App\Middlewares\web\AuthMiddleware($container));
