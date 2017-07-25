<?php

namespace App\Controllers\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Item as Item;
use App\Models\UserItem;

class ItemController extends BaseController
{
    //Get all items
    public function all($request, $response)
    {
        $item = new Item($this->db);
        $getItems = $item->getAll();
        $countItems = count($getItems);
        $query = $request->getQueryParams();

        if ($getItems) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');

            $get = $item->paginate($page, $getItems, 5);
            $pagination = $this->paginate($countItems, 5, $page, ceil($countItems/5));

            if ($get){
                $data = $this->responseDetail(200, 'Data Tersedia', ['query'  => $query,
                 'result' => $getItems,
                 'meta'   => $pagination
                ]);
            } else {
                $data = $this->responseDetail(404, 'Data Tidak Ditemukan', ['query' => $query]);
            }

        } else {
            $data = $this->responseDetail(204, 'Berhasil', [
                'result'  => 'Konten tidak tersedia',
                'query'   => $query
            ]);
        }

        return $data;
    }

    //Get item  by  id
    public function getItemDetail($request, $response, $args)
    {
        $item = new Item($this->db);

        $findItem = $item->find('id', $args['id']);

        if ($findItem) {
            $data = $this->responseDetail(200, 'Data Tersedia', ['result' => $findItem]);
        } else {
            $data = $this->responseDetail(400, 'Item tidak ditemukan');
        }

        return $data;
    }

    //Get group item unreported
    public function getGroupItem($request, $response, $args)
    {
        $item     = new Item($this->db);

        $groupId    = $args['group'];
        $findItem   = $item->getItem('group_id', $groupId, 'status', 0);
        $countItem  = count($findItem);
        $query      = $request->getQueryParams();

        if ($findItem) {
            $page = !$request->getQueryParam('page') ?  1 : $request->getQueryParam('page');
            $pagination = $this->paginate($countItem, 5, $page, ceil($countItem/5));

            $data = $this->responseDetail(200, 'Data tersedia', [
                'query'  => $query,
                'result' => $findItem,
                'meta'   => $pagination
            ]);

        } else {
            $data = $this->responseDetail(404, 'Data tidak ditemukan');
            // var_dump($data); die();
        }

        return $data;
    }
    //Get group item reported
    public function getReportedGroupItem($request, $response, $args)
    {
        $item     = new Item($this->db);

        $groupId    = $args['group'];
        $findItem   = $item->getItem('group_id', $groupId, 'status', 1);
        $countItem  = count($findItem);
        $query      = $request->getQueryParams();

        if ($findItem) {
            $page = !$request->getQueryParam('page') ?  1 : $request->getQueryParam('page');
            $pagination = $this->paginate($countItem, 5, $page, ceil($countItem/5));

            $data = $this->responseDetail(200, 'Data tersedia', [
                'query'  => $query,
                'result' => $findItem,
                'meta'   => $pagination
            ]);

        } else {
            $data = $this->responseDetail(404, 'Data tidak ditemukan');
            // var_dump($data); die();
        }

        return $data;
    }
    //Get user item (unreported)
    public function getUnreportedItem($request, $response, $args)
    {
        $item     = new Item($this->db);
        $groupId    = $args['group'];
        $findItem   = $item->getGroupItem($args['user']);
        $countItem  = count($findItem);
        $query      = $request->getQueryParams();

        // var_dump($findItem); die();
        if ($findItem) {
            $page = !$request->getQueryParam('page') ?  1 : $request->getQueryParam('page');
            $pagination = $this->paginate($countItem, 5, $page, ceil($countItem/5));
            $data = $this->responseDetail(200, 'Data Tersedia', ['result'  => $findItem, 'meta' => $pagination]);
        } else {
            $data = $this->responseDetail(400, 'Data tidak ditemukan');
        }

        return $data;
    }
    //get all user item (reported)
    public function getReportedUserItem($request, $response, $args)
    {
        $item       = new Item($this->db);
        $groupId    = $args['group'];
        $findItem   = $item->getItem('user_id',
            $args['user'], 'status', 1);
        $countItem  = count($findItem);
        $query      = $request->getQueryParams();

        // var_dump($findItem); die();
        if ($findItem) {
            $page = !$request->getQueryParam('page') ?  1 : $request->getQueryParam('page');
            $pagination = $this->paginate($countItem, 5, $page, ceil($countItem/5));
            $data = $this->responseDetail(200, 'Data Tersedia', ['result'  => $findItem, 'meta' => $pagination]);
        } else {
            $data = $this->responseDetail(400, 'Data tidak ditemukan');
        }

        return $data;
    }

    //Set item status
    public function setItemStatus($request, $response, $args)
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
    public function createItem($request, $response)
    {
        $rules = [
            'required' => [
                ['name'],
                ['recurrent'],
                ['description'],
                ['start_date'],
                ['user_id'],
                ['group_id'],
                ['creator'],
                ['public'],
            ],

        ];

        $this->validator->rules($rules);

        $this->validator->labels([
            'name'        => 'Name',
            'recurrent'   => 'Recurrent',
            'description' => 'Description',
            'start_date'  => 'Start date',
            'user_id'     => 'User id',
            'group_id'    => 'Group id',
            'creator '    => 'Creator',
            'public'      => 'Public'
        ]);
        // var_dump($this->validator);
        // die();

        if ($this->validator->validate()) {
            $item = new Item($this->db);
            $newItem = $item->create($request->getParsedBody());
            $recentItem = $item->find('id', $newItem);

            $data = $this->responseDetail(201, 'Item baru telah berhasil ditambahkan', ['result' => $recentItem]);

        } else {

            $data = $this->responseDetail(400, 'Error', ['result' => $this->validator->errors()]);
        }

        return $data;
    }

    //Edit item
    public function updateItem( $request, $response, $args)
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
                    ['group_id'],
                ],

            ];

            $this->validator->rules($rules);

            $this->validator->labels([
                'name'        => 'Name',
                'recurrent'   => 'Recurrent',
                'description' => 'Description',
                'start_date'  => 'Start date',
                'group_id'    => 'Group id'
            ]);


            if ($this->validator->validate()) {
                $item = new \App\Models\Item($this->db);
                $updateItem = $item->update($request->getParsedBody(), $args['id']);
                $recentItemUpdated = $item->find('id', $args['id']);

                $data = $this->responseDetail(200, 'Item berhasil diperbarui', ['result' => $recentItemUpdated]);

            } else {

                $data = $this->responseDetail(400, 'Error', ['result' => $this->validator->errors()]);
            }
        } else {
            $data = $this->responseDetail(400, 'Item tidak ditemukan', null);
        }

        return $data;
    }

    //Delete item
    public function deleteItem( $request, $response, $args)
    {
        $item = new Item($this->db);

        $findItem = $item->find('id', $args['id']);

        if ($findItem) {
            $item->hardDelete($args['id']);
            $data['status']= 200;
            $data['message']= 'Item berhasil dihapus';

        } else {
            $data['status']= 400;
            $data['message']= 'Item tidak ditemukan';
        }

        return $this->responsewithJson($data);

    }
}
