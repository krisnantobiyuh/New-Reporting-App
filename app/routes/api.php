<?php
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
});