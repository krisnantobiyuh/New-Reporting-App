<?php

namespace App\Models;

/**
 *
 */
class RequestModel extends BaseModel
{
    protected $table = 'requests';
    protected $column = ['user_id', 'guard_id', 'group_id', 'category'];

    public function requestUserToGroup(array $data)
    {
        $data = [
            'user_id'   =>  $data['user_id'],
            'group_id'  =>  $data['group_id'],
            'category'  =>  0,
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

    public function requestGuardToUser(array $data)
    {
        $data = [
            'user_id'   =>  $data['user_id'],
            'guard_id'  =>  $data['guard_id'],
            'category'  =>  1,
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

    public function requestUserToGuard(array $data)
    {
        $data = [
            'user_id'   =>  $data['user_id'],
            'guard_id'  =>  $data['guard_id'],
            'category'  =>  2,
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

    public function findRequest($column1, $val1, $column2, $val2)
    {
        $param1 = ':'.$column1;
        $param2 = ':'.$column2;
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter($param1, $val1)
            ->setParameter($param2, $val2)
            ->where($column1 . ' = '. $param1 .'&&'. $column2 . ' = '. $param2);
        $result = $qb->execute();
        return $result->fetch();
    }
}


 ?>
