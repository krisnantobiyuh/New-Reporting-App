<?php

namespace App\Controllers\api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Slim\Container;

abstract class BaseController
{
	protected $container;

	public function __construct(Container $container)
	{
		return $this->container = $container;
	}

	public function __get($property)
	{
		return $this->container->{$property};
	}

// Detail ResponseWithJson API
	public function responseWithJson(array $data)
	{
		return $this->response->withHeader('Content-type', 'application/json')
				->withJson($data, $data['reporting']['status']['code']);
	}
// Detail ResponseWithJson API
	public function responseDetail($code, $message, array $data = null)
	{
		if (!isset($data['query'])) {
			$data['query'] = 0;
		}			
		if (!isset($data['meta'])) {
			$data['meta'] = 0;
		}
		if (!isset($data['result'])) {
			$data['result'] = 0;
		}

		$response = [
			'reporting' => [
				'query'		=> $data['query'],
				'status'	=>  [
					'code'			=> $code,
					'description'	=> $message,
				],
				'results'	=> $data['result'],
				'meta'		=> $data['meta'],
			]
		];


		if ($data['query'] == 0) {
			unset($response['reporting']['query']);
		}

		if ($data['meta'] == 0) {
			unset($response['reporting']['meta']);
		}

	return $this->responseWithJson($response, $code);
	}

// Set Paginate
	public function paginate($total, $perPage, $currentPage, $totalPage)
	{
		return [
			'pagination'	=> [
				'total_data'	=> $total,
				'per_page'		=> $perPage,
				'current_page'	=> $currentPage,
				'total_page'	=> $totalPage,
			],
		];
	}

	public function getUser($token)
    {
        
    }

}
