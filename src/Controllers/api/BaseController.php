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
				->withJson($data, $data['code']);
	}

// Detail ResponseWithJson API
	public function responseDetail($code, $error, $message, array $data = null)
	{
		if (empty($data['pagination'])) {
			$data['pagination'] = null;
		}
		if (empty($data['data'])) {
			$data['data'] = null;
		}
		if (empty($data['key'])) {
			$data['key'] = null;
		}
		$response = [
			'code'		=> $code,
			'error'		=> $error,
			'message'	=> $message,
			'data'		=> $data['data'],
			'pagination'=> $data['pagination'],
			'key'		=> $data['key']
		];
		if ($data['pagination'] == null) {
			unset($response['pagination']);
		}
		if ($data['key'] == null) {
			unset($response['key']);
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
}