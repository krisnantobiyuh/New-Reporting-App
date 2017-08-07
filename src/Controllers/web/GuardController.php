<?php 

namespace App\Controllers\web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use App\Models\GuardModel;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class GuardController extends BaseController
{
    // Function show user by guard_id
    public function showUserByGuard($request, $response, $args)
    {
        $query = $request->getQueryParams();

        try {
            $result = $this->client->request('GET', 'guard/index'.$args['id'].$request->getUri()->getQuery());
            // $result->addHeader('Authorization', '7e505da11dd87b99ba9a4ed644a20ba4');
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
            $data = $result->getBody()->getContents();
            $data = json_decode($data, true);
            var_dump($data);
    }

    // Function Delete Guardian
    public function deleteGuardian($request, $response, $args)
    {
        $query = $request->getQueryParams();

        try {
            $result = $this->client->request('GET', 'guard/delete'. $args['id'].$request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
            $data = $result->getBody()->getContents();
            $data = json_decode($data, true);
            var_dump($data);
    }

    // Function Create Guardian
    public function createGuardian($request, $response, $args)
    {
        // $query = $request->getQueryParams();
        try {
            $result = $this->client->request('GET', 'guard/create'. $args['id'], ['form_params' => [
                    'guard_id' => $request->getParam('guard_id', $args['id'])
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        var_dump($data);die();
    }

    // Function show guard by user_id
    public function showGuardByUser($request, $response, $args)
    {
        $query = $request->getQueryParams();
        try {
            
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
    }
}