<?php

namespace App\Controllers\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\RequestModel;

/**
 *
 */
class RequestController extends BaseController
{

    public function createUserToGroup($request, $response, $args)
    {
        $requestModel = new RequestModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
		$userId = $userToken->getUserId($token);

        $groupId = $args['group'];

        $data = [
            'user_id'   =>  $userId,
            'group_id'  =>  $groupId,
        ];

        if ($data) {
            $addRequest = $requestModel->userToGroup($data);

            $data = $this->responseDetail(201, false, 'Berhasil mengirim permintaan group');
        } else {
            $data = $this->responseDetail(401, true, 'Ada kesalahan saat mengirim permintaan');
        }

        return $data;
    }


    public function CreateGuardToUser($request, $response, $args)
    {
        $requestModel = new RequestModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->db);

        $token = $request->getHeader('Authorization')[0];
        $guardId = $userToken->getUserId($token);

        $userId = $args['user'];

        $data = [
            'user_id'   =>  $userId,
            'guard_id'  =>  $guardId,
        ];

        if ($data) {
            $addRequest = $requestModel->guardToUser($data);

            $data = $this->responseDetail(201, false, 'Berhasil mengirim permintaan user');
        } else {
            $data = $this->responseDetail(401, true, 'Ada kesalahan saat mengirim permintaan');
        }

        return $data;
    }

    public function CreateUserToGuard($request, $response, $args)
    {
        $requestModel = new RequestModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->db);

        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $guardId = $args['guard'];

        $data = [
            'user_id'   =>  $userId,
            'guard_id'  =>  $guardId,
        ];

        if ($data) {
            $addRequest = $requestModel->userToGuard($data);

            $data = $this->responseDetail(201, false, 'Berhasil mengirim permintaan guard');
        } else {
            $data = $this->responseDetail(401, true, 'Ada kesalahan saat mengirim permintaan');
        }

        return $data;
    }
}


 ?>
