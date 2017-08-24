<?php

namespace App\Controllers\api;

class HomeController extends BaseController
{
<<<<<<< HEAD
        public function index($request, $response)
        {
        	$data = $this->view->render($response, 'users/home.twig');

       		// return $data;
       		return 'test api';
        }
=======
    public function index($request, $response)
    {
        // $data = $this->view->render($response, 'index.twig');

        return 'OK';
        $data = $this->view->render($response, 'users/home.twig');

        // return $data;
        return 'test api';

    }
>>>>>>> upstream/web
}
