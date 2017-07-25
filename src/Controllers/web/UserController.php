<?php

namespace App\Controllers\web;

use GuzzleHttp\Exception\BadResponseException as GuzzleException;

class UserController extends BaseController
{
    /**
     * Method "province" digunakan untuk mendapatkan daftar propinsi yang ada di Indonesia.
     */
    public function getAllUser($request, $response)
    {
        $query = $request->getQueryParams();

        // var_dump($query['page']);die();
        try {
            $response = $this->client->request('GET', 'user?'.$request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
        }

        $data = json_decode($response->getBody()->getContents());
// foreach ($data->reporting->results as $key => $val) {
//     echo $val->name;
// }
        var_dump($data->reporting->status);
    }
}



//
// ['body' => [
//     'user' => 'sadsd',
//     'pass'=> 'aaa'
// ],
// 'headers' => [
//     'accept' => 'aaa'
// ]
// ]
