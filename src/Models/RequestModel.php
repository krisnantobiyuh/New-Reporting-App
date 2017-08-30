<?php

namespace App\Models;

/**
 *
 */
class RequestModel extends BaseModel
{
    protected $table = 'requests';
    protected $column = ['user_id', 'guard_id', 'group_id', 'category', 'status'];

    public function userToGroup(array $data)
    {
        $data = [
            'user_id'   =>  $data['user_id'],
            'group_id'  =>  $data['group_id'],
            'category'  =>  0,
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

    public function guardToUser(array $data)
    {
        $data = [
            'user_id'   =>  $data['user_id'],
            'guard_id'  =>  $data['guard_id'],
            'category'  =>  1,
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

    public function userToGuard(array $data)
    {
        $data = [
            'user_id'   =>  $data['user_id'],
            'guard_id'  =>  $data['guard_id'],
            'category'  =>  2,
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

}
