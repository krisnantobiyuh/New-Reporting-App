<?php

namespace App\Controllers\web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

class UserController extends BaseController
{
    /**
     * Method "province" digunakan untuk mendapatkan daftar propinsi yang ada di Indonesia.
     */
    public function getAllUser($request, $response)
    {
        $query = $request->getQueryParams();

        // var_dump($request->getUri()->getQuery());die();
        try {
            $result = $this->client->request('GET', 'user?'.$request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents());

// foreach ($data->reporting->results as $key => $val) {
//     echo $val->name;
// }
        var_dump((array)$data->reporting->results);
    }

    public function getLogin($request, $response)
    {
        return  $this->view->render($response, 'auth/login.twig');
    }

    public function login($request, $response)
    {
        // var_dump($request->getParams()['optlogin']);die();
        $user = new \App\Models\Users\UserModel($this->db);
        $group =  new \App\Models\UserGroupModel($this->db);
        $guardian =  new \App\Models\GuardModel($this->db);

        $login = $user->find('username', $request->getParam('username'));
        $users = $guardian->findAllUser($login['id']);
        $groups = $group->findAllGroup($login['id']);
        // var_dump($login);die();

        if (empty($login)) {
            $this->flash->addMessage('warning', 'Username tidak terdaftar!');
            return $response->withRedirect($this->router
            ->pathFor('login'));
        } else {
            if (password_verify($request->getParam('password'),$login['password'])) {

                $_SESSION['login'] = $login;

                if ($_SESSION['login']['status'] == 2) {
                    $_SESSION['user_group'] = $groups;

                    $this->flash->addMessage('succes', 'Selamat datang, '. $login['name']);
                    return $response->withRedirect($this->router->pathFor('home'));
                } else {
                    $this->flash->addMessage('warning', 'Anda bukan user');
                    return $response->withRedirect($this->router->pathFor('login'));
                }

            } else {
                $this->flash->addMessage('warning', 'Password salah!');
                return $response->withRedirect($this->router->pathFor('login'));
            }
        }
    }

    public function logout($request, $response)
    {
        if ($_SESSION['login']['status'] == 2) {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('login'));

        } elseif ($_SESSION['login']['status'] == 1) {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('login.admin'));
        }
    }
}



//
// ['body' => [
//     'user' => 'sadsd',
//     'pass'=> 'aaa'
// ],
// 'headers' => [
//     'accept' => 'aaa'
// ]
// ]
