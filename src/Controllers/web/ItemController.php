<?php
namespace App\Controllers\web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Item as Item;
use App\Models\UserItem;

/**
*
*/
class ItemController extends BaseController
{
    //Get group item unreported
    public function getGroupItem($request, $response, $args)
	{
        try {
            $result = $this->client->request('GET', 'items/group/'.$args['group'],[
                'query' => [
                    'perpage' => 10,
                    'page' => $request->getQueryParam('page')
                    ]]);

                    try {
                        $findGroup = $this->client->request('GET', 'group/find/'.$args['group']);
                    } catch (GuzzleException $e) {
                        $findGroup = $e->getResponse();
                    }
                    $dataGroup = json_decode($findGroup->getBody()->getContents(), true);

                } catch (GuzzleException $e) {
                    $result = $e->getResponse();
                }

        $data = json_decode($result->getBody()->getContents(), true);
// var_dump($dataGroup);die();

		return $this->view->render($response, 'users/group/unreported-item.twig', [
			'data'			=>	$data['data'],
			'count_item'	=>	count($data['data']),
			// 'pagination'  	=>	$data['pagination'],
			'group' 		=> 	$dataGroup['data']
		]);
	}

	//create item by user
	public function createItemUser($request, $response, $args)
	{
		$query = $request->getQueryParams();

		try {
			$result = $this->client->request('POST', 'items/'.$args['group'], [
				'query' => [
					'name'          => $request->getParam('name'),
	                'description'   => $request->getParam('description'),
	                'recurrent'     => $request->getParam('recurrent'),
	                'start_date'    => $request->getParam('start_date'),
	                'user_id'    	=> $_SESSION['key']['key_token'],
	                'group_id'      => $args['group'],
	                'creator'    	=> $_SESSION['key']['key_token'],
	                'image'         => $request->getParam('image'),
	                'public'        => $request->getParam('public'),
	                'status'        => 0,
	                'reported_at'   => null,
				]
			]);
            $this->flash->addMessage('succes', 'Berhasil membuat item');
		} catch (GuzzleException $e) {
			$result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat membuat item');
		}

		$content = $result->getBody()->getContents();
        $content = json_decode($content, true);

    	return $response->withRedirect("http://localhost/Reporting-App/public/items/group/".$args['group']);
	}

	//Get group item reported
    public function getReportedGroupItem($request, $response, $args)
    {
    	$query = $request->getQueryParams();
    	try {
    		$result = $this->client->request('GET', 'items/group/'.$args['group'].'/reported',[
                'query' => [
                    'perpage' => 10,
                    'page' => $request->getQueryParam('page')
                    ]]);

                try {
                    $findGroup = $this->client->request('GET', 'group/find/'.$args['group']);
                } catch (GuzzleException $e) {
                    $findGroup = $e->getResponse();
                }
                $dataGroup = json_decode($findGroup->getBody()->getContents(), true);
    	} catch (GuzzleException $e) {
    		$result = $e->getResponse();
    	}

		$data = json_decode($result->getBody()->getContents(), true);

		return $this->view->render($response, 'users/group/reported-item.twig', [
			'data'			=>	$data['data'],
			'pagination'	=>	$data['pagination'],
			'group' 		=> 	$dataGroup['data'],
		]);
    }

    //create item by user
	public function reportItem($request, $response, $args)
	{
		// var_dump($request->getParams());die();
		// var_dump($request->getParam('public'));
		try {
			$result = $this->client->request('PUT', 'item/report/'.$args['item'],
                ['form_params' => [
                    'description'   => $request->getParam('description'),
                ]
            ]);
            // $this->flash->addMessage('succes', 'Berhasil melaporkan tugas');
		} catch (GuzzleException $e) {
			$result = $e->getResponse();
            // $this->flash->addMessage('error', 'Ada kesalahan saat melaporkan tugas');
		}

        $content = json_decode($result->getBody()->getContents(), true);
// var_dump($content);die();
    	return $response->withRedirect("http://localhost/Reporting-App/public/items/group/".$args['group'].'/reported');

	}
	//Delete item by user
    public function deleteItemByUser($request, $response, $args)
    {
    	$query = $request->getQueryParams();

    	try {
    		$data = $this->client->request('GET', 'items/'.$args['item'].
    			$request->getUri()->getQuery());
            $this->flash->addMessage('succes', 'Berhasil menghapus tugas');
    	} catch (GuzzleException $e) {
    		$data = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat menghapus tugas');
    	}
    	
		$dataDetailItem = json_decode($data->getBody()->getContents(), true);

    	try {
    		$result = $this->client->request('DELETE', 'items/'.$args['item'].'/user'.
    			$request->getUri()->getQuery());
            $this->flash->addMessage('succes', 'Berhasil menghapus tugas');
    	} catch (GuzzleException $e) {
    		$result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat menghapus tugas');
    	}

		$data = json_decode($result->getBody()->getContents(), true);

			return $response->withRedirect($this->router->pathFor('group.item', [
			// 'data'			=>	$data['data'],
			'group' 		=> 	$dataDetailItem['data']['group_id']
		]));
    }

    //Delete item reported
    public function deleteItemReported($request, $response, $args)
    {
    	$query = $request->getQueryParams();

    	try {
    		$data = $this->client->request('GET', 'items/'.$args['item'].
    			$request->getUri()->getQuery());
    	} catch (GuzzleException $e) {
    		$data = $e->getResponse();
    	}
    	
		$dataDetailItem = json_decode($data->getBody()->getContents(), true);

    	try {
    		$result = $this->client->request('DELETE', 'items/'.$args['item'].'/delete'.
    			$request->getUri()->getQuery());
            $this->flash->addMessage('succes', 'Berhasil menghapus tugas yang telah dilaporkan');
    	} catch (GuzzleException $e) {
    		$result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat menghapus tugas');
    	}

		$data = json_decode($result->getBody()->getContents(), true);

		return $response->withRedirect($this->router->pathFor('web.reported.group.item', [
			// 'data'			=>	$data['data'],
			'group' 		=> 	$dataDetailItem['data']['group_id']
		]));
    }

    public function byMonth($request, $response, $args)
    {
        $item = new Item($this->db);
        $result= $item->getByMonth('08','2017',$args['id']);
        var_dump($result);die();
    }
}

 ?>
