<?php

namespace App\Controllers\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\GuardModel;
use App\Models\Users\UserModel;

class GuardController extends BaseController
{
    // Function Create Guardian
    public function createGuardian(Request $request, Response $response, $args)
    {
        $guard = new \App\Models\GuardModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userToken = new \App\Models\Users\UserToken($this->db);
        // $userId = $userToken->getUserId($token);
        $userId = $args['user'];
        $guardId = $args['guard'];
        $findGuard = $guard->findTwo('guard_id', $guardId, 'user_id', $userId);

        $data = [
            'guard_id'  =>  $guardId,
            'user_id' => $userId,
        ];

        if (!$findGuard) {
            $addGuardian = $guard->add($data);

            $data = $this->responseDetail(200, false, 'Pengguna berhasil ditambahkan ', [
                'data' => $data
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Pengguna sudah ditambahkan');
        }
        return $data;

    }
    // Function Delete Guardian
    public function deleteGuardian(Request $request, Response $response, $args)
    {
        $guard = new GuardModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userToken = new \App\Models\Users\UserToken($this->db);
        $findUser = $userToken->find('token', '72af357cae642386ccaaf5c4e86b669a');
        $findGuard = $guard->findGuards('user_id', $findUser['user_id'], 'guard_id', $args['id']);

           // var_dump($findGuard);die();
        $query = $request->getQueryParams();

           if ($findGuard && $findUser['user_id']) {
               $oh = $guard->deleteGuard($args['id']);
               var_dump($oh);die();
               $data = $this->responseDetail(200, false, 'Guardian berhasil dihapus', [
                    'data' => $findGuard
                ]);
           } else {
               $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
           }

           return $data;

    }
    // Function show user by guard_id
    public function getUserByGuard(Request $request, Response $response, $args)
    {
        $guard = new GuardModel($this->db);
        $users = new \App\Models\Users\UserModel($this->container->db);
        $userToken = new \App\Models\Users\UserToken($this->container->db);

        $findGuard = $guard->findGuard('guard_id', $args['id']);
        $token = $response->getHeader('Authorization');
        $findUser = $userToken->find('token', '4411c348e004615488e72b2fc7cf8144');
        $guards = $guard->findGuards('user_id', $findUser['user_id'], 'guard_id', $args['id']);

        $user = $users->find('id', $findUser['user_id']);
        $query = $request->getQueryParams();

        if ($guards) {
            if ($findGuard || $user) {
                $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
                $findAll = $guard->findAllUser($args['id'])->setPaginate($page, 5);
                    // var_export($findAll);die();
                    // var_dump($findGuard);die();
                $data = $this->responseDetail(200, 'Berhasil menampilkan user dalam guardian', [
                    'query'     =>  $query,
                    'result'    =>  $findAll['data'],
                    'meta'      =>  $findAll['pagination'],
                ]);

            } else {
                $data = $this->responseDetail(404, 'User tidak ditemukan', [
                    'query'     =>  $query
                ]);
            }
        } else {
            $data = $this->responseDetail(403, 'User tidak di temukan atau Kamu belum menambahkan id'. " ".$args['id']." ". 'menjadi guard', [
                    'query'     =>  $query
                ]);
        }
        return $data;
    }

    // Function show guard by user_id
    public function getGuardByUser(Request $request, Response $response, $args)
    {
        $guard = new GuardModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->container->db);
        $token = $response->getHeader('Authorization');
        $userId = $userToken->find('token', $token);
        $guards = $guard->findGuards('guard_id', $args['id'], 'user_id', $userId['user_id']);
var_dump($guards);die();
        $query = $request->getQueryParams();
         if ($userId['user_id'] || $guards ) {
                $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
                $userGuard = $guard->getUserId($userId['user_id'])->setPaginate($page, 9);
                // var_dump($userGuard);die();
             $data = $this->responseDetail(200, 'Berhasil menampilkan data', [
                    'query'     =>  $query,
                    'result'    =>  $userGuard['data'],
                    'meta'      =>  $userGuard['pagination'],
                ]);

        } else {
            $data = $this->responseDetail(400, true, 'Oh now');
        }
        return $data;
      }
}
