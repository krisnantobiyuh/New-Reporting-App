<?php

namespace App\Controllers\web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

class PicController extends BaseController
{

    public function getMemberGroup($request, $response, $args)
	{
		$query = $request->getQueryParams();

        try {
            $result = $this->client->request('GET', 'group/'.$args['id'].'/member', [
                'query' => [
                    'perpage' => 8,
                    'page'    => $request->getQueryParam('page')
                ]
            ]);
			// $request->getUri()->getQuery());
			// $result->addHeader('Authorization', '7e505da11dd87b99ba9a4ed644a20ba4');

        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);
        $count = count($data['data']);
        // var_dump($data); die();
		// var_dump($data); die();

		// var_dump($data->reporting->results);die();
		return $this->view->render($response, 'pic/group-member.twig', [
			'members'	=> $data['data'],
			'group'	=> $args['id'],
			'pagination'	=> $data['pagination'],
		]);
	}

    public function getUnreportedItem($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'items/group/'. $args['id'], [
                'query' => [
                    'page'    => $request->getQueryparam('page'),
                    'perpage' => 10,
                    ]
                ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        // var_dump($data); die();
        return $this->view->render($response, 'pic/tugas.twig', [
            'items'	=> $data['data'],
            'group'	=> $args['id'],
            'pagination'	=> $data['pagination'],
        ]);
    }

    public function getReportedItem($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', 'items/group/'. $args['id'].'/reported', [
                'query' => [
                    'page'    => $request->getQueryparam('page'),
                    'perpage' => 5,
                    ]
                ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data['data']); die();
        return $this->view->render($response, 'pic/laporan.twig', [
            'items'	=> $data['data'],
            'group'	=> $args['id'],
            'pagination'	=> $data['pagination'],
        ]);
    }

    public function deleteTugas($request, $response, $args)
	{
        $item = new \App\Models\Item($this->db);
        $findItem = $item->find('id', $args['id']);
		try {
			$client = $this->client->request('DELETE', 'items/'.$args['id']);

			$content = json_decode($client->getBody()->getContents(), true);
            $this->flash->addMessage('succes', 'Tugas telah berhasil dihapus');
		} catch (GuzzleException $e) {
			$content = json_decode($e->getResponse()->getBody()->getContents(), true );
			$this->flash->addMessage('warning', 'Anda tidak diizinkan menghapus tugas ini ');
		}
		// return $this->view->render($response, 'pic/tugas.twig');
        // var_dump($content); die();
        return $response->withRedirect($this->router->pathFor('pic.item.group',['id' => $findItem['group_id']]));
	}

    public function createItem($request, $response)
    {

            $query = $request->getQueryParams();
            $group = $request->getParam('group');
            // var_dump($_SESSION['login']); die();
            try {
                $result = $this->client->request('POST', 'items', [
                    'form_params' => [
                        'name'          => $request->getParam('name'),
                        'description'   => $request->getParam('description'),
                        'recurrent'     => $request->getParam('recurrent'),
                        'start_date'    => $request->getParam('start_date'),
                        'user_id'    	=> null,
                        'group_id'      => $request->getParam('group'),
                        'creator'    	=> $_SESSION['login']['id'],
                        'public'        => $request->getParam('public'),
                    ]
                ]);
            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

            $content = $result->getBody()->getContents();
            $contents = json_decode($content, true);
            // var_dump($contents); die();
            if ($contents['code'] == 201) {
                $this->flash->addMessage('succes', $contents['message']);
                return $response->withRedirect($this->router->pathFor('pic.item.group',['id' => $group ]));
            } else {
                // foreach ($contents['message'] as $value ) {
                // }
                $_SESSION['errors'] = $contents['message'];
                $_SESSION['old']    = $request->getParams();
                // var_dump($_SESSION['errors']); die();
                return $response->withRedirect($this->router->pathFor('pic.item.group',['id' => $group ]));
            }


    }

    public function showItem($request, $response, $args)
    {
        // $id = $_SESSION['login']['id'];
        try {
            $result = $this->client->request('GET', 'item/show/'.$args['id'].'?'
            . $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        try {
            $comment = $this->client->request('GET', 'item/comment/'.$args['id'].'?'
            . $request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $comment = $e->getResponse();
        }

        $allComment = json_decode($comment->getBody()->getContents(), true);

        // var_dump($allComment);die();

        if ($data['data']) {

            return $this->view->render($response, 'users/show-item.twig', [
                'items' => $data['data'],
                'comment' => $allComment['data'],
            ]);
        } else {
            return $response->withRedirect($this->router->pathFor('home'));
            // return $this->view->render($response, 'users/home.twig');

        }

    }

}
