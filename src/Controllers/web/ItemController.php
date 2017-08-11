<?php
namespace App\Controllers\web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;
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
		$query = $request->getQueryParams();
		try {
			$result = $this->client->request('GET', 'items/group/'.$args['group'].
				$request->getUri()->getQuery());
		} catch (GuzzleException $e) {
			$result = $e->getResponse();
		}

        $data = json_decode($result->getBody()->getContents(), true);


		return $this->view->render($response, 'users/item-list.twig', [
			'data'			=>	$data['data'],
			'pagination'  	=>	$data['pagination'],
			'group_id' 		=> 	$args['group'],
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
    		$result = $this->client->request('GET', 'items/group/'.$args['group'].'/reported'.
    			$request->getUri()->getQuery());
    	} catch (GuzzleException $e) {
    		$result = $e->getResponse();
    	}

		$data = json_decode($result->getBody()->getContents(), true);

		return $this->view->render($response, 'users/item-list-reported.twig', [
			'data'			=>	$data['data'],
			'pagination'	=>	$data['pagination'],
			'group_id' 		=> 	$args['group'],
		]);
    }

    //create item by user
	public function reportItem($request, $response, $args)
	{
		$query = $request->getQueryParams();

		var_dump($request->getParam('description'));
		var_dump($request->getParam('public'));
		try {
			$result = $this->client->request('POST', 'items/report/'.$args['item'], [
				'query' => [
	                'description'   => $request->getParam('description'),
	                'public'        => $request->getParam('public')
				]
			]);
            $this->flash->addMessage('succes', 'Berhasil melaporkan tugas');
		} catch (GuzzleException $e) {
			$result = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat melaporkan tugas');
		}

		$content = $result->getBody()->getContents();
        $content = json_decode($content, true);

    	return $response->withRedirect("http://localhost/Reporting-App/public/items/group/".$args['group'].'/reported');

	}
	//Delete item by user
    public function deleteItemByUser($request, $response, $args)
    {
    	$query = $request->getQueryParams();

    	try {
    		// $item = $this->client->request('GET', '/items/group/'.$args['group']);
    		$data = $this->client->request('GET', 'items/'.$args['item'].
    			$request->getUri()->getQuery());
            $this->flash->addMessage('succes', 'Berhasil menghapus tugas');
    	} catch (GuzzleException $e) {
    		$data = $e->getResponse();
            $this->flash->addMessage('error', 'Ada kesalahan saat menghapus tugas');
    	}
		$dataDetailItem = json_decode($data->getBody()->getContents(), true);
		// var_dump($dataDetailItem['data']['group_id']);die();

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

    	// return $response->withRedirect("http://localhost/New-Reporting-App/public/items/group/".$args['group_id']);
    }
}

 ?>
