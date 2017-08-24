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
        // $query = $request->getQueryParams();

        try {
            $result = $this->client->request('GET', $this->router->pathFor('api.guard.show.user', ['id' => $args['id']]));
            $content = json_decode($client->getBody()->getContents());
        } catch (GuzzleException $e) {
            $content = json_decode($e->getResponse()->getBody()->getContents());
        }
        var_dump($content);die();
            // return $this->view->render($response, 'guard/show-user.twig', $content->reporting);
    }

    // Function Delete Guardian
    public function deleteGuardian($request, $response, $args)
    {
        try {
            $result = $this->client->request('GET', $this->router->pathFor('api.guard.delete', ['id' => $args['id']]));
            $content = json_decode($client->getBody()->getContents());
        } catch (GuzzleException $e) {
            $content = json_decode($e->getResponse()->getBody()->getContents());
        }
            var_dump($content);
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
            $result = $this->client->request('GET', 'guard/show'.$request->getUri()->getQuery());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        var_dump($data);
    }
}