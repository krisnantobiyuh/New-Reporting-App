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
		return $this->response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}
// Detail ResponseWithJson API
	public function responseDetail($code, $message, $data, array $meta = null, array $query = null)
	{
		if ($query == null) {
			$response = [
				'reporting' => [
					'status'	=>  [
						'code'			=> $code,
						'description'	=> $message,
					],
					'results'	=> $data,
					'meta'		=> $meta,
				]
			];
			
		} else {
			$response = [
				'reporting' => [
					'query'		=> $query,
					'status'	=>  [
						'code'			=> $status,
						'description'	=> $message,
					],
					'results'	=> $data,
					'meta'		=> $meta,
				]
			];
		}

		if ($meta == null) {
			array_pop($response);
		}
		return $this->responseWithJson($response);
	}

// Set Paginate
	public function paginate($total, $perPage, $currentPage, $totalPage)
	{
		return [
			'paginate'	=> [
				'total_data'	=> $total,
				'per_page'		=> $perPage,
				'current_page'	=> $currentPage,
				'total_page'	=> $totalPage,
			],
		];
	}
}
