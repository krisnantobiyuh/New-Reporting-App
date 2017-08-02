<?php

$app->get('/activateaccount/{token}', 'App\Controllers\api\UserController:activateAccount')->setName('api.activate');
$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\HomeController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:register')->setname('api.register');
    $app->post('/forgot-password', 'App\Controllers\api\UserController:recovery')->setName('api.recovery');
    $app->get('/reset', 'App\Controllers\api\UserController:forgotPassword')->setName('api.reset');
    $app->post('/reset/{token}', 'App\Controllers\api\UserController:reset')->setName('api.recovery');
    $app->post('/test', 'App\Controllers\api\UserController:changePassword')->setName('api.reset.password');
    // $app->group('', function() use ($app, $container) {
    //
    // })->add(new \App\Middlewares\AuthToken($container));
    $app->post('/change/{id}', 'App\Controllers\api\UserController:postImage')->setname('api.user.ima');
    $app->group('/user', function() use ($app, $container) {
        $this->get('', 'App\Controllers\api\UserController:index')->setName('api.user.list');
    });
    $app->group('/group', function() use ($app, $container) {
        $app->post('/create', 'App\Controllers\api\GroupController:add')->setName('api.group.add');
        $app->put('/edit/{id}', 'App\Controllers\api\GroupController:update');
        $app->get('/list', 'App\Controllers\api\GroupController:index')->setName('api.group.list');
        $app->get('/find/{id}', 'App\Controllers\api\GroupController:findGroup')->setName('api.group.find');
        $app->get('/delete/{id}', 'App\Controllers\api\GroupController:delete');
        $app->post('/add/user', 'App\Controllers\api\GroupController:setUserGroup')->setName('api.user.add.group');
        $app->put('/set/guardian/{group}/{id}', 'App\Controllers\api\GroupController:setAsGuardian')->setName('api.user.set.guardian');
        $app->get('/detail', 'App\Controllers\api\GroupController:getGroup');
        $app->get('/{id}/del', 'App\Controllers\api\GroupController:delGroup');
        $app->get('/{id}/leave', 'App\Controllers\api\GroupController:leaveGroup');
        $app->get('/join/{id}', 'App\Controllers\api\GroupController:joinGroup');
        $app->post('/search', 'App\Controllers\api\GroupController:searchGroup')->setName('api.search.group');
        $app->get('/active', 'App\Controllers\api\GroupController:inActive');
        $app->post('/change/photo/{id}', 'App\Controllers\api\GroupController:postImage')->setName('api.change.photo.group');
        $app->get('/PIC', 'App\Controllers\api\GroupController:getPicGroup');
        $app->post('/softdelete/{id}', 'App\Controllers\api\GroupController:setInActive')->setName('api.delete.group');
        $app->post('/restore/{id}', 'App\Controllers\api\GroupController:restore')->setName('api.restore.group');
        $app->get('/getPic', 'App\Controllers\api\GroupController:getPic');
        $app->get('/{id}/users', 'App\Controllers\api\GroupController:getMemberGroup');
        $app->post('/pic/create', 'App\Controllers\api\GroupController:createByUser')->setName('pic.create.group');
        $app->get('/{id}/notMember', 'App\Controllers\api\GroupController:getNotMember');
        $app->post('/pic/addusers', 'App\Controllers\api\GroupController:setMemberGroup')->setName('pic.member.group.set');
        $app->put('/upload/image', 'App\Controllers\api\FileSystemController:upload')->setName('api.upload.image');
        $app->get('/{id}/member', 'App\Controllers\api\GroupController:getAllUserGroup');
    });
});