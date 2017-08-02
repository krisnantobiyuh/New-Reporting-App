<?php

namespace App\Controllers\api;

class HomeController extends BaseController
{
        public function index($request, $response)
        {
<<<<<<< HEAD
        	// $data = $this->view->render($response, 'index.twig');

       		return 'OK';
=======
        	$data = $this->view->render($response, 'users/home.twig');

       		// return $data;
       		return 'test api';
>>>>>>> upstream/api
        }
}
