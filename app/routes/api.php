<?php

$app->get('/activateaccount/{token}', 'App\Controllers\api\UserController:activateAccount')->setName('api.activate');
$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\UserController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:register')->setname('api.register');
    $app->post('/forgot-password', 'App\Controllers\api\UserController:recovery')->setName('api.recovery');
    $app->get('/reset', 'App\Controllers\api\UserController:forgotPassword')->setName('api.reset');
    $app->post('/reset/{token}', 'App\Controllers\api\UserController:reset')->setName('api.recovery');
    $app->post('/test', 'App\Controllers\api\UserController:changePassword')->setName('api.reset.password');


    $app->post('/update/user/{id}', 'App\Controllers\api\GroupController:updateUser')->setName('api.update.user');

    $app->get('/items', 'App\Controllers\api\ItemController:all')->setname('api.item.all');
    $app->get('/items/{id}', 'App\Controllers\api\ItemController:getItemDetail')->setname('api.item.Detail');
    $app->delete('/items/{id}', 'App\Controllers\api\ItemController:deleteItem')->setname('api.item.delete');
    $app->delete('/items/{item}/user', 'App\Controllers\api\ItemController:deleteItemByUser')->setname('api.user.delete.item');
    $app->put('/items/{id}', 'App\Controllers\api\ItemController:updateItem')->setname('api.item.update');
    $app->post('/items/upload/{item}', 'App\Controllers\api\ItemController:postImage')->setname('api.item.upload');
    $app->get('/items/image/{item}', 'App\Controllers\api\ItemController:getImageItem')->setname('api.item.image');
    $app->delete('/items/image/{image}', 'App\Controllers\api\ItemController:deleteImageItem')->setname('api.delete.image');
    $app->post('/items', 'App\Controllers\api\ItemController:createItem')->setname('api.item.create');
    $app->post('/items/{group}', 'App\Controllers\api\ItemController:createItemUser')->setname('api.item.user.create');    
    $app->get('/items/group/{group}', 'App\Controllers\api\ItemController:getGroupItem')->setname('api.group.item');
    $app->get('/items/group/{group}/reported', 'App\Controllers\api\ItemController:getReportedGroupItem')->setname('api.reported.group.item');
    $app->get('/items/{user}/unreported', 'App\Controllers\api\ItemController:getUnreportedItem')->setname('api.unreported.item');
    $app->get('/items/{user}/reported', 'App\Controllers\api\ItemController:getReportedUserItem')->setname('api.reported.user.item');
    $app->post('/items/report/{item}', 'App\Controllers\api\ItemController:reportItem')->setname('api.report.item');
    $app->get('/all-item/{id}', 'App\Controllers\api\ItemController:itemTimeline')->setname('api.item.timeline');
    $app->get('/item/show/{id}', 'App\Controllers\api\ItemController:showItemDetail')->setname('api.item.show');
    $app->get('/item/comment/{id}', 'App\Controllers\api\CommentController:getItemComment')->setname('api.item.comment');
    //
    // })->add(new \App\Middlewares\AuthToken($container));
    $app->post('/change/{id}', 'App\Controllers\api\UserController:postImage')->setname('api.user.ima');
    $app->group('/user', function() use ($app, $container) {
        $this->get('', 'App\Controllers\api\UserController:index');
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
        $app->get('/user/join', 'App\Controllers\api\GroupController:getGeneralGroup');
        // $app->get('/user/join', 'App\Controllers\api\GroupController:getUserGroup');
        // $app->get('/items/group/{group}', 'App\Controllers\web\ItemController:getGroupItem')->setName('api.group.item');

    });
$app->group('/guard', function() use ($app, $container) {
        $app->post('/create/{id}', 'App\Controllers\api\GuardController:createGuardian')->setName('api.guard.add');
        $app->get('/delete/{id}', 'App\Controllers\api\GuardController:deleteGuardian')->setName('api.guard.delete');
        $app->get('/show/user/{id}', 'App\Controllers\api\GuardController:getUserByGuard')->setName('api.guard.show.user');
        $app->get('/show', 'App\Controllers\api\GuardController:getGuardByUser')->setName('api.guard.show');

        });
});