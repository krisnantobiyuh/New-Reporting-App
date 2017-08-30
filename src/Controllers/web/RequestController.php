<?php

namespace App\Controllers\web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use App\Models\RequestModel;

/**
 *
 */
class RequestController extends BaseController
{

    public function createUserToGroup($request, $response, $args)
	{
		$query = $request->getQueryParams();

        try {
            $result = $this->client->request('POST', 'request/group/'.$args['group'],
                ['query' => [
                    'group_id'  => $args['group'],
                    'user_id'   => $_SESSION['login']['id']
                ]
            ]);
            $this->flash->addMessage('success', 'Berhasil mengirim permintaan');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat mengirim permintaan');
        }

        $data = json_decode($result->getBody()->getContents(), true);

        return $response->withRedirect($this->router->pathFor('group.user'));
	}

    public function createUserToGuard($request, $response, $args)
    {
        $query = $request->getQueryParams();

        try {
            $result = $this->client->request('POST', 'request/guard/'.$args['guard'],
                ['query' => [
                    'user_id'   => $_SESSION['login']['id'],
                    'guard_id'  => $args['guard']
                ]
            ]);
            $this->flash->addMessage('success', 'Berhasil mengirim permintaan');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat mengirim permintaan');
        }

        $data = json_decode($result->getBody()->getContents(), true);

        // var_dump($data);die();
        return $this->view->render($response, 'users/group-list.twig', [
            'data'			=> $data['data'],
            'pagination'	=> $data['pagination']
        ]);
    }

    public function createGuardToUser($request, $response, $args)
    {
        $query = $request->getQueryParams();

        try {
            $result = $this->client->request('POST', 'request/user/'.$args['user'],
                ['query' => [
                    'guard_id'  => $_SESSION['login']['id'],
                    'user_id'   => $args['user']
                ]
            ]);
            $this->flash->addMessage('success', 'Berhasil mengirim permintaan');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat mengirim permintaan');
        }

        $data = json_decode($result->getBody()->getContents(), true);

        // var_dump($data);die();
        return $this->view->render($response, 'users/group-list.twig', [
            'data'			=> $data['data'],
            'pagination'	=> $data['pagination']
        ]);
    }
}


 ?>
