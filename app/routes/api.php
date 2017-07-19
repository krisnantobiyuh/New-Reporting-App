<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('', 'App\Controllers\api\HomeController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:createUser')->setname('api.user.login');

    // })->add(new \App\Middlewares\AuthToken($container));


    $app->group('/user', function() use ($app, $container) {
        $app->get('/all', 'App\Controllers\api\UserController:index');

    });
});
$app->group('/group', function() use ($app, $container) {
	$app->post('/create', 'App\Controllers\api\GroupController:add')->setName('api.group.add');
	$app->put('/edit/{id}', 'App\Controllers\api\GroupController:update');
    $app->get('/list', 'App\Controllers\api\GroupController:index');
    $app->get('/find/{id}', 'App\Controllers\api\GroupController:findGroup');
    $app->get('/delete/{id}', 'App\Controllers\api\GroupController:delete');
    $app->post('/add/user', 'App\Controllers\api\GroupController:setUserGroup')->setName('api.user.add.group');
    $app->put('/set/guardian/{group}/{id}', 'App\Controllers\api\GroupController:setAsGuardian')->setName('api.user.set.guardian');
    $app->get('/detail', 'App\Controllers\api\GroupController:getGroup');
    $app->get('/{id}/del', 'App\Controllers\api\GroupController:delGroup');
    $app->get('/{id}/leave', 'App\Controllers\api\GroupController:leaveGroup');
    $app->get('/join/{id}', 'App\Controllers\api\GroupController:joinGroup');
    $app->post('/search', 'App\Controllers\api\GroupController:searchGroup');

});