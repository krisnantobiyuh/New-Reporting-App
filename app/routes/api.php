<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\UserController:index');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('api.user.login');
    $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('api.logout');
    $app->post('/register', 'App\Controllers\api\UserController:register')->setname('api.register');
    $app->get('/activateaccount/{token}', 'App\Controllers\api\UserController:activateAccount')->setName('api.activate');
    $app->post('/forgot-password', 'App\Controllers\api\UserController:recovery')->setName('api.recovery');
    $app->get('/reset', 'App\Controllers\api\UserController:forgotPassword')->setName('api.reset');
    $app->post('/reset/{token}', 'App\Controllers\api\UserController:reset')->setName('api.recovery');
    $app->post('/test', 'App\Controllers\api\UserController:changePassword')->setName('api.reset.password');


    $app->get('/items', 'App\Controllers\api\ItemController:all')->setname('api.item.all');
    $app->get('/items/{id}', 'App\Controllers\api\ItemController:getItemDetail')->setname('api.item.Detail');
    $app->delete('/items/{id}', 'App\Controllers\api\ItemController:deleteItem')->setname('api.item.delete');
    $app->delete('/items/{item}/user', 'App\Controllers\api\ItemController:deleteItemByUser')->setname('api.user.delete.item');
    $app->put('/items/{id}', 'App\Controllers\api\ItemController:updateItem')->setname('api.item.update');
    $app->post('/items/upload/{item}', 'App\Controllers\api\ItemController:postImage')->setname('api.item.upload');
    $app->get('/items/image/{item}', 'App\Controllers\api\ItemController:getImageItem')->setname('api.item.image');
    $app->delete('/items/image/{image}', 'App\Controllers\api\ItemController:deleteImageItem')->setname('api.delete.image');
    $app->post('/items', 'App\Controllers\api\ItemController:createItem')->setname('api.item.create');
    $app->get('/items/group/{group}', 'App\Controllers\api\ItemController:getGroupItem')->setname('api.group.item');
    $app->get('/items/group/{group}/reported', 'App\Controllers\api\ItemController:getReportedGroupItem')->setname('api.reported.group.item');
    $app->get('/items/{user}/unreported', 'App\Controllers\api\ItemController:getUnreportedItem')->setname('api.unreported.item');
    $app->get('/items/{user}/reported', 'App\Controllers\api\ItemController:getReportedUserItem')->setname('api.reported.user.item');
    $app->post('/items/report/{item}', 'App\Controllers\api\ItemController:reportItem')->setname('api.report.item');
    //
    // })->add(new \App\Middlewares\AuthToken($container));

    $app->post('/change/{id}', 'App\Controllers\api\UserController:postImage')->setname('api.user.ima');

    $app->group('/user', function() use ($app, $container) {
        $this->get('', 'App\Controllers\api\UserController:index');

    });
});
