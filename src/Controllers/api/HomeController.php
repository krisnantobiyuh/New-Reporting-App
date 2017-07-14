<?php

namespace App\Controllers\api;

class HomeController extends BaseController
{
        public function index($request, $response)
        {
        	$data = $this->view->render($response, 'index.twig');

       		return $data;
        }
}
