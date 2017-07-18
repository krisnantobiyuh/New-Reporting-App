<?php

namespace App\Controllers\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Item;
use App\Models\UserItem;

class ItemController extends BaseController
{
    //Get all items
    public function all(Request $request, Response $response)
    {
        $item = new \App\Models\Item($this->db);
        $getItems = $item->getAll();
        $countItems = count($getItems);
        $query = $request->getQueryParams();

        if ($getItems) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $get = $item->paginate($page, $getItems, 5);
            if ($get){
                $data = $this->responseDetail(200, 'Data Available', $getItems,
                $this->paginate($countItems, 5, $page, ceil($countItems/5)), $query);
            } else {
                $data = $this->responseDetail(404, 'Error', 'Data Not Found');
            }

        } else {
            $data = $this->responseDetail(204, 'Success', 'No Content');
        }

        return $data;
    }

    //Get item  by  id
    public function getItemDetail(Request $request, Response $response, $args)
    {
        $item = new Item($this->db);

        $findItem = $item->find('id', $args['id']);

        if ($findItem) {
            $data = $this->responseDetail(200, 'Data Available', $findItem);
        } else {
            $data = $this->responseDetail(400, 'Error', 'User item not found');
        }

        return $data;
    }

    //Get group item
    public function getGroupItem(Request $request, Response $response, $args)
    {
        $item     = new Item($this->db);
        $findItem  = $item->getItem('group_id', $args['group']);
        $countItem = count($findItem);
        $query = $request->getQueryParams();

        if ($findItem) {
            $page = !$request->getQueryParam('page') ?  1 : $request->getQueryParam('page');
            $get = $item->paginate($page, $findItem, 5);
            if ($get) {
                $data = $this->responseDetail(200, 'Data available', $findItem, $this->paginate($countItem, 5, $page, ceil($countItem/5)), $query);
            } else {
                $data = $this->responseDetail(404, 'Error', 'Data Not Found');
            }

        } else {
            $data = $this->responseDetail(204, 'Success', 'No Content');
        }

        return $data;
    }
    //Get user item (unreported)
    public function getUserItem(Request $request, Response $response, $args)
    {
        $item     = new Item($this->db);

        $findItem  = $item->getItem('user_id', $args['user']);
        if ($findItem) {
            $page = !$request->getQueryParam('page') ?  1 : $request->getQueryParam('page');
            $data = $this->responseDetail(200, 'Data available', $findItem);
        } else {
            $data = $this->responseDetail(400, 'Error', 'User item not found');
        }

        return $data;
    }

    //Set item status
    public function setItemStatus(Request $request, Response $response, $args)
    {
        $userItem = new UserItem($this->db);

        $findUserItem = $userItem->findUser('group_id', $args['group'], 'user_id', $args['id']);


        if ($findUserItem) {
            $userItem->setStatusItem($findUserItem['id']);
            $data = $this->responseDetail(200, 'Item done', $findUserItem);
        } else {
            $data = $this->responseDetail(400, 'error', 'Item not found');
        }

        return $data;
    }

    //Create item
    public function createItem(Request $request, Response $response)
    {
        $rules = [
            'required' => [
                ['name'],
                ['recurrent'],
                ['description'],
                ['start_date'],
                ['end_date'],
                ['group_id'],
            ],

        ];

        $this->validator->rules($rules);

        $this->validator->labels([
            'name'        => 'Name',
            'recurrent'   => 'Recurrent',
            'description' => 'Description',
            'start_date'  => 'Start date',
            'end_date'    => 'End date',
            'group_id'    => 'Group id'
        ]);

        if ($this->validator->validate()) {
            $item = new Item($this->db);
            $newItem = $item->create($request->getParsedBody());
            $recentItem = $item->find('id', $newItem);

            $data = $this->responseDetail(201, 'New item successfully added', $recentItem);

        } else {

            $data = $this->responseDetail(400, 'Error occured', $this->validator->errors());
        }

        return $data;
    }

    //Edit item
    public function updateItem(Request $request, Response $response, $args)
    {
        $item     = new Item($this->db);
        $findItem = $item->find('id', $args['id']);

        if ($findItem) {
            $rules = [
                'required' => [
                    ['name'],
                    ['recurrent'],
                    ['description'],
                    ['start_date'],
                    ['end_date'],
                    ['group_id'],
                ],

            ];

            $this->validator->rules($rules);

            $this->validator->labels([
                'name'        => 'Name',
                'recurrent'   => 'Recurrent',
                'description' => 'Description',
                'start_date'  => 'Start date',
                'end_date'    => 'End date',
                'group_id'    => 'Group id'
            ]);


            if ($this->validator->validate()) {
                $item = new \App\Models\Item($this->db);
                $updateItem = $item->update($request->getParsedBody(), $args['id']);
                $recentItemUpdated = $item->find('id', $args['id']);

                $data = $this->responseDetail(200, 'Item successfully updated', $recentItemUpdated);

            } else {

                $data = $this->responseDetail(400, 'Error occured', $this->validator->errors());
            }
        } else {
            $data = $this->responseDetail(400, 'Item not found', null);
        }

        return $data;
    }

    //Delete item
    public function deleteItem(Request $request, Response $response, $args)
    {
        $item = new Item($this->db);

        $findItem = $item->find('id', $args['id']);

        if ($findItem) {

            $item->hardDelete($args['id']);
            $data['status']= 200;
            $data['message']= 'Item deleted';

        } else {
            $data['status']= 400;
            $data['message']= 'Item not found';
        }

        return $this->responsewithJson($data);

    }
}
