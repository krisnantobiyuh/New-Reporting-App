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
        $userId = $userToken->getUserId($token);
        $findGuard = $guard->finds('guard_id', $args['id'], 'user_id', $userId);

        $data = [
            'guard_id'  =>  $args['id'],
            'user_id' => $userId,
        ];

        if ($findGuard) {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        } else {
            $addGuardian = $guard->add($data);

            $data = $this->responseDetail(200, false, 'Berhasilkan menambahkan guardian', [
                    'data' => $data
                ]);
        }
        return $data;

    }
    // Function Delete Guardian
    public function deleteGuardian(Request $request, Response $response, $args)
    {
        $guard = new \App\Models\GuardModel($this->db);
        $token = $request->getHeader('Authorization')[0];

        $findguard = $guard->find('id', $args['id']);
        $query = $request->getQueryParams();

        if ($findguard[0]) {
            $guard->hardDelete($args['id']);
            $data = $this->responseDetail(200, true, "Delete Guard Success");
        } else {
            $data = $this->responseDetail(404, 'Error', "Data not found");
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
        $findUser = $userToken->find('token', 'a4c22aa6df9fe1790169638db2d24921');
        $guards = $guard->findGuards('user_id', $findUser['user_id'], 'guard_id', $args['id']);

        $user = $users->find('id', $findUser['user_id']);
        $query = $request->getQueryParams();

        if ($guards) {
            if ($findGuard || $user) {
                $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
                $findAll = $guard->findAllUser($args['id']);
                    var_export($findAll);die();
                    // var_dump($findGuard);die();
                $data = $this->responseDetail(200, 'Berhasil menampilkan guardian', [
                    'query'     =>  $query,
                    'result'    =>  $findGuard['data'],
                    'meta'      =>  $findGuard['pagination'],
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
        $users = new  \App\Models\Users\UserModel($this->container->db);

        $findGuard = $guard->getUser('user_id', $args['id']);
        $token = $response->getHeader('Authorization');
        $findUser = $userToken->find('token', 'c895059548157d8dfe50ddefb3a04557');
        $guards = $guard->findAllUser('user_id', $findUser['user_id'], 'guard_id');
// var_dump($findGuard);die();
        $user = $users->find('id', $findUser['user_id']);
        $query = $request->getQueryParams();

        // if ($guards) {
            if ($guards) {
                $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');

                $findAll = $guard->findUser($args['id']);
                    var_dump($findAll);die();

                $data = $this->responseDetail(200, 'Berhasil menampilkan guardian', [
                    'query'     =>  $query,
                    'result'    =>  $findAll['data'],
                    'meta'      =>  $findAll['pagination']
                ]);

            } else {
                $data = $this->responseDetail(404, 'User tidak ditemukan di dalam group', [
                    'query'     =>  $query
                ]);
            }
    
        // }
        return $data;
      //   $guard = new \App\Models\GuardModel($this->db);
      //   $token = $request->getHeader('Authorization')[0];
      //   $userToken = new \App\Models\Users\UserToken($this->db);
      //   $userId = $userToken->getUserId($token);
      //   $findGuard = $guard->findGuard('guard_id', $args['id'], 'user_id', $userId);
      //   $query = $request->getQueryParams();

      //   if ($findGuard) {
      //       $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
      //           $findAll = $guard->getAllUser($args['id']->setPaginate($page, 2));
      //           $data = $this->responseDetail(200, false, 'Data tersedia', [
      //               'data'        => $findGuard['data'],
      //               'pagination'  => $findGuard['pagination']
      //           ]);
      //   } else {
      //     $data = $this->responseDetail(404, 'User tidak memiliki guard', [
      //               'query'     =>  $query
      //           ]);        
      // }

      //   return $data;

        // $guard = new \App\Models\GuardModel($this->db);
        // $userToken = new \App\Models\Users\UserModel($this->db);
        // $findUserGUard = $guard->findGuard('guard_id', $args['id']);
        // $token = $response->getHeader('Authorization');
        // $findUser = $userToken->find('token', '8d4338e87932618b59b1326db22364e7');
        // $guard = $guard->findGuard('user_id', $findUser['user_id'], 'guard_id', $args['id']);
        // $query = $request->getQueryParams();

        // if ($guard) {
        //     if ($findUserGUard) {
        //         $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
        //         $findAll = $guard->findAllUser($args['id']->setPaginate($page, 2));
        //         $data = $this->responseDetail(200, false, 'Data tersedia', [
        //             'data'        => $getItems['data'],
        //             'pagination'  => $getItems['pagination']
        //         ]);
        //     } else {
        //         $data = $this->responseDetail(404, 'User tidak ditemukan di dalam group', [
        //             'query'     =>  $query
        //         ]);
        //     }
        // } else {
        //     $data = $this->responseDetail(403, 'Kamu tidak terdaftar di dalam group', [
        //             'query'     =>  $query
        //         ]);
        // }

        // return $data;
    }
}