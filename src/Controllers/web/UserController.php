<?php

namespace App\Controllers\web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

class UserController extends BaseController
{

    public function getAllUser($request, $response)
    {
        try {
            $result = $this->client->request('GET', 'user');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        var_dump($data);
    }

    public function getLogin($request, $response)
    {
        return  $this->view->render($response, 'auth/login.twig');
    }

    public function login($request, $response)
    {
        try {
            $result = $this->client->request('POST', 'login',
                ['form_params' => [
                    'username' => $request->getParam('username'),
                    'password' => $request->getParam('password')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        var_dump($data);die();
        if ($data['code'] == 200) {
            $_SESSION['login'] = $data['data'];
            $_SESSION['key'] = $data['key'];

            if ($_SESSION['login']['status'] == 2) {
                $_SESSION['user_group'] = $groups;

                $this->flash->addMessage('succes', 'Selamat datang, '. $login['name']);
                return $response->withRedirect($this->router->pathFor('home'));
            } else {
                $this->flash->addMessage('warning',
                'Anda belum terdaftar sebagai user atau akun anda belum diverifikasi');
                return $response->withRedirect($this->router->pathFor('login'));
            }

        } else {

            $this->flash->addMessage('warning', 'Email atau password tidak cocok');
            return $response->withRedirect($this->router->pathFor('login'));
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

    public function getSignUp($request, $response)
    {
        return  $this->view->render($response, 'auth/register.twig');
    }

    public function signUp($request, $response)
    {
        $this->validator
            ->rule('required', ['username', 'password', 'email'])
            ->message('{field} tidak boleh kosong')
            ->label('Username', 'Password', 'Email');
        $this->validator->rule('email', 'email');
        $this->validator->rule('alphaNum', 'username');
        $this->validator
             ->rule('lengthMax', [
                'username',
                'password'
             ], 30);

        $this->validator
             ->rule('lengthMin', [
                'username',
                'password'
             ], 5);

        if ($this->validator->validate()) {

            try {
                $result = $this->client->request('POST', 'register',
                    ['form_params' => [
                        'username' => $request->getParam('username'),
                        'password' => $request->getParam('password'),
                        'email' => $request->getParam('email')
                    ]
                ]);
            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

            $data = json_decode($result->getBody()->getContents(), true);

            // var_dump($data);die();

            if ($data['code'] == 201) {
                $this->flash->addMessage('succes', 'Pendaftaran berhasil,
                silakan cek email anda untuk mengaktifkan akun');
                return $response->withRedirect($this->router->pathFor('signup'));
            } else {
                $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('warning', $data['message']);
                return $response->withRedirect($this->router->pathFor('signup'));
            }

        } else {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $request->getParams();

            // $this->flash->addMessage('info');
            return $response->withRedirect($this->router->pathFor('signup'));
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
